<?php

declare(strict_types=1);

namespace Synchra\Generator;

/**
 * Maps a JSON Schema fragment onto a PHP type and the call that reads it.
 *
 * Everything the generated models know about types comes from here, so the mapping rules live in
 * one place: a `date-time` string becomes a `DateTimeImmutable`, a closed value set becomes an
 * enum, a tagged union becomes a resolver, and anything the description leaves open stays `mixed`
 * with an accurate docblock rather than being forced into a type it might not hold.
 */
final class TypeMapper
{
    /**
     * Alias schemas currently being expanded, keyed by schema name.
     *
     * A handful of schemas describe "any JSON value" by referring to themselves
     * (`KvJsonValue`, `CustomWidgetSettingJsonValue`). Expanding those literally never
     * terminates, so the second time one is entered it maps to `mixed` — which is what an
     * arbitrary JSON value is in PHP anyway.
     *
     * @var array<string, true>
     */
    private array $expanding = [];

    public function __construct(
        private readonly Spec $spec,
        private readonly EnumRegistry $enums,
        private readonly UnionRegistry $unions,
    ) {}

    /**
     * @param array<string, mixed> $schema
     * @param string $owner Schema the field belongs to, used to name inline enums.
     */
    public function map(array $schema, string $key, bool $required, string $owner, string $property): MappedType
    {
        $nullable = false;

        if (isset($schema['anyOf']) || isset($schema['oneOf'])) {
            /** @var list<array<string, mixed>> $branches */
            $branches = $schema['anyOf'] ?? $schema['oneOf'];
            $nonNull = \array_values(\array_filter(
                $branches,
                static fn(array $branch): bool => ($branch['type'] ?? null) !== 'null',
            ));
            $nullable = \count($nonNull) !== \count($branches);

            if (\count($nonNull) === 1) {
                $inner = $this->map($nonNull[0], $key, $required && !$nullable, $owner, $property);

                return $nullable ? $this->asNullable($inner, $key, $required) : $inner;
            }

            return $this->mapUnion($schema, $nonNull, $key, $required, $nullable, $owner, $property);
        }

        // Past the union branch above, a schema that reaches here is never nullable on its own.
        $read = $required ? 'required' : 'optional';
        $ref = $schema['$ref'] ?? null;

        if (\is_string($ref)) {
            return $this->mapRef($ref, $key, $required, $owner, $property);
        }

        if (\is_string($schema['const'] ?? null)) {
            return new MappedType(
                $this->nullableNative('string', $required),
                $this->nullableNative('string', $required),
                \sprintf('$reader->%sString(%s)', $read, self::literal($key)),
                default: self::literal($schema['const']),
            );
        }

        if (isset($schema['enum'])) {
            return $this->mapEnum($schema, $key, $required, $owner, $property);
        }

        return match ($schema['type'] ?? null) {
            'string' => $this->mapString($schema, $key, $required),
            'integer' => $this->scalar('int', 'Int', $key, $required),
            'number' => $this->scalar('float', 'Float', $key, $required),
            'boolean' => $this->scalar('bool', 'Bool', $key, $required),
            'array' => $this->mapArray($schema, $key, $required, $owner, $property),
            'object' => $this->mapObject($schema, $key, $required),
            default => $this->mapMixed($key),
        };
    }

    /**
     * The model class a response or request schema refers to, or null when it is not a plain
     * object reference.
     *
     * @param array<string, mixed> $schema
     */
    public function modelClassFor(array $schema): ?string
    {
        $ref = $schema['$ref'] ?? null;

        if (!\is_string($ref)) {
            return null;
        }

        $name = Spec::refName($ref);

        return $this->spec->isObjectSchema($name) ? Names::schemaClass($name) : null;
    }

    private function mapRef(string $ref, string $key, bool $required, string $owner, string $property): MappedType
    {
        $name = Spec::refName($ref);
        $target = $this->spec->schema($name);

        if (isset($target['enum'])) {
            return $this->mapEnum($target, $key, $required, $owner, $property, Names::schemaClass($name));
        }

        if (isset($target['properties'])) {
            $class = Names::schemaClass($name);
            $read = $required ? 'required' : 'optional';

            return new MappedType(
                $this->nullableNative($class, $required),
                $this->nullableNative($class, $required),
                \sprintf('$reader->%sModel(%s, %s::class)', $read, self::literal($key), $class),
                ['Synchra\\Model\\' . $class],
            );
        }

        // An alias schema: a bare scalar, or a union of scalars such as KvJsonValue.
        if (isset($this->expanding[$name])) {
            return $this->mapMixed($key);
        }

        $this->expanding[$name] = true;

        try {
            return $this->map($target, $key, $required, $owner, $property);
        } finally {
            unset($this->expanding[$name]);
        }
    }

    /** @param array<string, mixed> $schema */
    private function mapEnum(
        array $schema,
        string $key,
        bool $required,
        string $owner,
        string $property,
        ?string $named = null,
    ): MappedType {
        // The registry has the last word on the class name: when two differently named schemas
        // share a value set they share one enum, so `$named` is a preference, not a guarantee.
        $class = $this->enums->register($schema, $owner, $property, $named);
        $read = $required ? 'required' : 'optional';

        return new MappedType(
            $this->nullableNative($class, $required),
            $this->nullableNative($class, $required),
            \sprintf('$reader->%sEnum(%s, %s::class)', $read, self::literal($key), $class),
            ['Synchra\\Enum\\' . $class],
        );
    }

    /** @param array<string, mixed> $schema */
    private function mapString(array $schema, string $key, bool $required): MappedType
    {
        if (($schema['format'] ?? null) === 'date-time') {
            $read = $required ? 'required' : 'optional';

            return new MappedType(
                $this->nullableNative('\\DateTimeImmutable', $required),
                $this->nullableNative('\\DateTimeImmutable', $required),
                \sprintf('$reader->%sDateTime(%s)', $read, self::literal($key)),
            );
        }

        return $this->scalar('string', 'String', $key, $required);
    }

    private function scalar(string $native, string $readerSuffix, string $key, bool $required): MappedType
    {
        $type = $this->nullableNative($native, $required);
        $read = $required ? 'required' : 'optional';

        return new MappedType(
            $type,
            $type,
            \sprintf('$reader->%s%s(%s)', $read, $readerSuffix, self::literal($key)),
        );
    }

    /** @param array<string, mixed> $schema */
    private function mapArray(array $schema, string $key, bool $required, string $owner, string $property): MappedType
    {
        /** @var array<string, mixed> $items */
        $items = \is_array($schema['items'] ?? null) ? $schema['items'] : [];
        $read = $required ? 'required' : 'optional';
        $native = $required ? 'array' : '?array';

        $item = $items === [] ? null : $this->map($items, $key, true, $owner, $property . ' item');

        [$suffix, $argument, $docItem, $imports] = match (true) {
            $item === null => ['MixedList', '', 'mixed', []],
            \str_starts_with($item->reader, '$reader->requiredModel(') => ['ModelList', ', ' . $this->classArgument($item), $item->native, $item->imports],
            \str_starts_with($item->reader, '$reader->requiredEnum(') => ['EnumList', ', ' . $this->classArgument($item), $item->native, $item->imports],
            \str_starts_with($item->reader, '$reader->requiredVia(') => ['ListVia', ', ' . $this->factoryArgument($item), $item->native, $item->imports],
            $item->native === 'string' => ['StringList', '', 'string', []],
            $item->native === 'int' => ['IntList', '', 'int', []],
            $item->native === 'float' => ['FloatList', '', 'float', []],
            default => ['MixedList', '', 'mixed', $item->imports],
        };

        $doc = \sprintf('list<%s>', $docItem);
        // `requiredMixedList()` returns `list<mixed>`, so what the items actually hold goes into
        // the description and the docblock type stays something analysis can verify.
        $note = $item !== null && $docItem === 'mixed' && ($item->doc !== 'mixed' || $item->note !== '')
            ? 'Items carry ' . ($item->note === ''
                ? $item->doc
                : \lcfirst(\substr($item->note, \strlen('Carries '))))
            : '';

        return new MappedType(
            $native,
            $required ? $doc : $doc . '|null',
            \sprintf('$reader->%s%s(%s%s)', $read, $suffix, self::literal($key), $argument),
            $imports,
            note: $note === '' ? '' : \rtrim($note, '.') . '.',
        );
    }

    /** @param array<string, mixed> $schema */
    private function mapObject(array $schema, string $key, bool $required): MappedType
    {
        $read = $required ? 'required' : 'optional';
        $values = $schema['additionalProperties'] ?? null;
        $valueDoc = \is_array($values) && isset($values['type']) && $values['type'] === 'object' ? 'array<string, mixed>' : 'mixed';
        $doc = \sprintf('array<string, %s>', $valueDoc);

        return new MappedType(
            $required ? 'array' : '?array',
            $required ? $doc : $doc . '|null',
            \sprintf('$reader->%sMap(%s)', $read, self::literal($key)),
        );
    }

    /**
     * @param array<string, mixed> $schema
     * @param list<array<string, mixed>> $branches
     */
    private function mapUnion(
        array $schema,
        array $branches,
        string $key,
        bool $required,
        bool $nullable,
        string $owner,
        string $property,
    ): MappedType {
        if (Spec::dig($schema, 'discriminator', 'propertyName') !== null) {
            $union = $this->unions->registerTagged($schema);

            return $this->unionType($union, $key, $required, $nullable);
        }

        $objectRefs = $this->objectRefs($branches);

        if ($objectRefs !== null) {
            $union = $this->unions->registerShaped($objectRefs);

            return $this->unionType($union, $key, $required, $nullable);
        }

        $scalar = $this->commonScalar($branches);

        if ($scalar !== null) {
            // A union of several closed value sets — the description models these as separate
            // enums per platform. Their underlying type is what the field actually carries.
            return $this->scalar($scalar, \ucfirst($scalar === 'int' ? 'Int' : $scalar), $key, $required && !$nullable);
        }

        return $this->mapMixed($key, $this->describeBranches($branches, $owner, $property));
    }

    private function unionType(string $union, string $key, bool $required, bool $nullable): MappedType
    {
        $variantType = $this->unions->variantType($union);
        $effectivelyRequired = $required && !$nullable;
        $native = $effectivelyRequired ? $variantType : $variantType . '|null';
        $read = $effectivelyRequired ? 'requiredVia' : 'optionalVia';

        $imports = ['Synchra\\Model\\Union\\' . $union];

        foreach ($this->unions->variants($union) as $variant) {
            $imports[] = 'Synchra\\Model\\' . $variant;
        }

        return new MappedType(
            $native,
            $native,
            \sprintf('$reader->%s(%s, %s::fromArray(...))', $read, self::literal($key), $union),
            $imports,
            $nullable,
        );
    }

    /**
     * Each variant's distinguishing fields, or null when a branch is not an object reference.
     *
     * @param list<array<string, mixed>> $branches
     *
     * @return array<string, list<string>>|null
     */
    private function objectRefs(array $branches): ?array
    {
        $shapes = [];

        foreach ($branches as $branch) {
            $ref = $branch['$ref'] ?? null;

            if (!\is_string($ref)) {
                return null;
            }

            $name = Spec::refName($ref);

            if (!$this->spec->isObjectSchema($name)) {
                return null;
            }

            /** @var list<string> $requiredFields */
            $requiredFields = $this->spec->schema($name)['required'] ?? [];
            $shapes[Names::schemaClass($name)] = $requiredFields;
        }

        return $shapes === [] ? null : $shapes;
    }

    /**
     * The single scalar type behind a union of enums or scalars, or null when they disagree.
     *
     * @param list<array<string, mixed>> $branches
     */
    private function commonScalar(array $branches): ?string
    {
        $types = [];

        foreach ($branches as $branch) {
            $branchRef = $branch['$ref'] ?? null;
            $resolved = \is_string($branchRef) ? $this->spec->schema(Spec::refName($branchRef)) : $branch;
            $type = $resolved['type'] ?? null;

            if (!\is_string($type)) {
                return null;
            }

            $types[] = match ($type) {
                'string' => 'string',
                'integer' => 'int',
                'number' => 'float',
                'boolean' => 'bool',
                default => '?',
            };
        }

        $unique = \array_unique($types);

        return \count($unique) === 1 && $unique[\array_key_first($unique)] !== '?'
            ? $unique[\array_key_first($unique)]
            : null;
    }

    /** @param list<array<string, mixed>> $branches */
    private function describeBranches(array $branches, string $owner, string $property): string
    {
        $parts = [];

        foreach ($branches as $index => $branch) {
            $mapped = $this->map($branch, 'value', true, $owner, $property . ' variant ' . $index);
            // A branch that is itself an open union keeps its own description rather than
            // collapsing to a bare `mixed` nobody can act on.
            $parts[] = $mapped->note === '' ? $mapped->doc : \rtrim($mapped->note, '.');
        }

        return \implode('|', \array_unique($parts));
    }

    private function mapMixed(string $key, string $shape = ''): MappedType
    {
        return new MappedType(
            'mixed',
            'mixed',
            \sprintf('$reader->mixed(%s)', self::literal($key)),
            nullable: true,
            note: $shape === '' || $shape === 'mixed' ? '' : 'Carries one of ' . $shape . '.',
        );
    }

    private function asNullable(MappedType $inner, string $key, bool $required): MappedType
    {
        return new MappedType(
            $inner->native,
            $inner->doc,
            $inner->reader,
            $inner->imports,
            nullable: true,
            default: $required ? null : 'null',
            note: $inner->note,
        );
    }

    /**
     * Pulls the `Foo::class` argument back out of a reader expression, so a list of models can
     * reuse the item mapping.
     */
    private function classArgument(MappedType $item): string
    {
        if (\preg_match('/, ([A-Za-z0-9_\\\\]+)::class\)$/', $item->reader, $matches) !== 1) {
            throw new \RuntimeException("Could not read the class out of: {$item->reader}");
        }

        return $matches[1] . '::class';
    }

    /**
     * Pulls the `Foo::fromArray(...)` argument back out of a union reader expression.
     */
    private function factoryArgument(MappedType $item): string
    {
        if (\preg_match('/, ([A-Za-z0-9_\\\\]+::fromArray\(\.\.\.\))\)$/', $item->reader, $matches) !== 1) {
            throw new \RuntimeException("Could not read the factory out of: {$item->reader}");
        }

        return $matches[1];
    }

    private function nullableNative(string $type, bool $required): string
    {
        return $required ? $type : '?' . $type;
    }

    public static function literal(string $value): string
    {
        return "'" . \addcslashes($value, "'\\") . "'";
    }
}
