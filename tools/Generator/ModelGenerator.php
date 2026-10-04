<?php

declare(strict_types=1);

namespace Synchra\Generator;

/**
 * Emits one immutable value object per object schema.
 *
 * Properties keep the API's own names, in snake_case. That is deliberate: what you read in a model
 * is exactly what you see in the API reference, a HAR capture or a `var_dump`, and the mapping both
 * ways is the identity — there is no table of renames to get wrong.
 */
final class ModelGenerator
{
    /** @var list<string> */
    private array $generated = [];

    public function __construct(
        private readonly Spec $spec,
        private readonly TypeMapper $types,
    ) {}

    public function emit(Emitter $emitter): void
    {
        $emitter->wipe('src/Model');
        $pageWrappers = $this->spec->pageWrappers();

        foreach ($this->spec->schemas as $name => $schema) {
            // Page wrappers become Page<T> at the call site rather than a class of their own.
            if (isset($pageWrappers[$name]) || !isset($schema['properties'])) {
                continue;
            }

            $class = Names::schemaClass($name);
            $emitter->write('src/Model/' . $class . '.php', $this->render($name, $class, $schema));
            $this->generated[] = $class;
        }
    }

    public function count(): int
    {
        return \count($this->generated);
    }

    /**
     * One property, mapped and ready to render.
     *
     * @param array<string, mixed> $schema
     *
     * @return list<array{name: string, mapped: MappedType, required: bool, alwaysSend: bool, title: string, description: string}>
     */
    private function fields(string $name, array $schema): array
    {
        /** @var array<string, array<string, mixed>> $properties */
        $properties = $schema['properties'];
        /** @var list<string> $required */
        $required = $schema['required'] ?? [];

        $fields = [];

        foreach ($properties as $property => $definition) {
            $isRequired = \in_array($property, $required, true);
            $mapped = $this->types->map($definition, $property, $isRequired, $name, $property);
            $fields[] = [
                'name' => $property,
                'mapped' => $mapped,
                'required' => $isRequired,
                // A field the schema declares nullable has to keep its null on the wire; an
                // optional non-nullable one is omitted, which is what makes a partial update
                // leave untouched fields alone.
                'alwaysSend' => $isRequired || $mapped->nullable,
                'title' => \is_string($definition['title'] ?? null) ? $definition['title'] : '',
                'description' => \is_string($definition['description'] ?? null) ? $definition['description'] : '',
            ];
        }

        // Parameters without a default have to come first for positional construction to work.
        \usort($fields, static function (array $a, array $b): int {
            $aHasDefault = $a['required'] === false || $a['mapped']->default !== null;
            $bHasDefault = $b['required'] === false || $b['mapped']->default !== null;

            return [$aHasDefault] <=> [$bHasDefault];
        });

        return $fields;
    }

    /**
     * The four parallel lists the class template needs, plus the imports they pull in.
     *
     * @param list<array{name: string, mapped: MappedType, required: bool, alwaysSend: bool, title: string, description: string}> $fields
     *
     * @return array{imports: list<string>, params: list<string>, paramDocs: list<string>, hydrations: list<string>, serialisations: list<string>}
     */
    private function parts(array $fields): array
    {
        $imports = ['Synchra\\Serialization\\DataModel', 'Synchra\\Serialization\\Reader', 'Synchra\\Serialization\\Writer'];
        $params = [];
        $paramDocs = [];
        $hydrations = [];
        $serialisations = [];

        foreach ($fields as $field) {
            $mapped = $field['mapped'];
            $imports = [...$imports, ...$mapped->imports];

            $default = $field['required'] && $mapped->default === null
                ? ''
                : ' = ' . ($mapped->default ?? 'null');
            $params[] = \sprintf('        public %s $%s%s,', $mapped->native, $field['name'], $default);
            $description = $this->describe($field);

            if ($mapped->needsDocType()) {
                $paramDocs[] = \sprintf('@param %s $%s%s', $mapped->doc, $field['name'], $description);
            } elseif ($description !== '') {
                $paramDocs[] = \sprintf('@param %s $%s%s', $mapped->native, $field['name'], $description);
            }

            $hydrations[] = \sprintf('            %s: %s,', $field['name'], $mapped->reader);
            $serialisations[] = \sprintf(
                "            '%s' => [\$this->%s, %s],",
                \addcslashes($field['name'], "'\\"),
                $field['name'],
                $field['alwaysSend'] ? 'true' : 'false',
            );
        }

        return \compact('imports', 'params', 'paramDocs', 'hydrations', 'serialisations');
    }

    /** @param array<string, mixed> $schema */
    private function render(string $name, string $class, array $schema): string
    {
        [
            'imports' => $imports,
            'params' => $params,
            'paramDocs' => $paramDocs,
            'hydrations' => $hydrations,
            'serialisations' => $serialisations,
        ] = $this->parts($this->fields($name, $schema));

        $classDoc = Emitter::docBlock(\array_merge(
            [\sprintf('The `%s` schema.', $name)],
            $name === $class ? [] : [\sprintf('Named `%s` in the API description.', $name)],
        ));

        $constructorDoc = $paramDocs === [] ? '' : Emitter::docBlock($paramDocs, '    ');

        $body = $classDoc . \sprintf(
            <<<'PHP'
                final readonly class %1$s implements DataModel
                {
                %2$s    public function __construct(
                %3$s
                    ) {}

                    /**
                     * @param array<string, mixed> $data
                     */
                    public static function fromArray(array $data): static
                    {
                        $reader = new Reader($data, self::class);

                        return new self(
                %4$s
                        );
                    }

                    public function jsonSerialize(): array
                    {
                        return Writer::payload([
                %5$s
                        ]);
                    }
                }
                PHP,
            $class,
            $constructorDoc,
            \implode("\n", $params),
            \implode("\n", $hydrations),
            \implode("\n", $serialisations),
        );

        return Emitter::file('Synchra\\Model', $imports, $body);
    }

    /** @param array{name: string, mapped: MappedType, required: bool, alwaysSend: bool, title: string, description: string} $field */
    private function describe(array $field): string
    {
        $parts = [];

        if ($field['description'] !== '') {
            $parts[] = \rtrim($field['description'], '.') . '.';
        }

        if ($field['mapped']->note !== '') {
            $parts[] = $field['mapped']->note;
        }

        return $parts === [] ? '' : ' ' . \implode(' ', $parts);
    }
}
