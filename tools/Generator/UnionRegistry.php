<?php

declare(strict_types=1);

namespace Synchra\Generator;

/**
 * Collects the polymorphic schemas and emits one resolver class per distinct variant set.
 *
 * The description expresses these inline at the endpoints that use them, and the same union shows
 * up in up to five places (create, read, update, patch, list), so they are keyed by variant set and
 * named after what the variants have in common: `ChatWidget` + `CustomWidget` + … becomes
 * `WidgetUnion`.
 */
final class UnionRegistry
{
    /** @var array<string, array{name: string, discriminator: string|null, mapping: array<string, string>, shapes: array<string, list<string>>}> */
    private array $unions = [];

    /** @var array<string, true> */
    private array $takenNames = [];

    /**
     * Registers a discriminated union and returns its resolver class name.
     *
     * @param array<string, mixed> $schema A schema with `oneOf`/`anyOf` plus `discriminator`.
     */
    public function registerTagged(array $schema): string
    {
        $mapping = [];

        foreach (Spec::objectAt($schema, 'discriminator', 'mapping') ?? [] as $tag => $ref) {
            if (\is_string($ref)) {
                $mapping[$tag] = Names::schemaClass(Spec::refName($ref));
            }
        }

        $discriminator = Spec::dig($schema, 'discriminator', 'propertyName');

        if (!\is_string($discriminator)) {
            throw new \RuntimeException('A discriminated union without a propertyName: ' . \json_encode($schema));
        }

        $key = 'tagged:' . \json_encode($mapping) . ':' . $discriminator;

        if (isset($this->unions[$key])) {
            return $this->unions[$key]['name'];
        }

        $name = $this->claim(Names::unionName(\array_values(\array_unique($mapping))) . 'Union');

        $this->unions[$key] = [
            'name' => $name,
            'discriminator' => $discriminator,
            'mapping' => $mapping,
            'shapes' => [],
        ];

        return $name;
    }

    /**
     * Registers an untagged union, keyed by each variant's distinguishing fields.
     *
     * @param array<string, list<string>> $shapes Variant class to the fields that identify it.
     */
    public function registerShaped(array $shapes): string
    {
        $key = 'shaped:' . \json_encode($shapes);

        if (isset($this->unions[$key])) {
            return $this->unions[$key]['name'];
        }

        $name = $this->claim(Names::unionName(\array_keys($shapes)) . 'Union');

        $this->unions[$key] = [
            'name' => $name,
            'discriminator' => null,
            'mapping' => [],
            'shapes' => $shapes,
        ];

        return $name;
    }

    /**
     * The PHP union type expression for a resolver, for use as a return or property type.
     */
    public function variantType(string $unionClass): string
    {
        foreach ($this->unions as $union) {
            if ($union['name'] === $unionClass) {
                $variants = $union['discriminator'] !== null
                    ? \array_values(\array_unique($union['mapping']))
                    : \array_keys($union['shapes']);

                return \implode('|', $variants);
            }
        }

        throw new \RuntimeException("Unknown union {$unionClass}.");
    }

    /** @return list<string> */
    public function variants(string $unionClass): array
    {
        return \explode('|', $this->variantType($unionClass));
    }

    /**
     * Every registered resolver class name.
     *
     * @return list<string>
     */
    public function names(): array
    {
        return \array_values(\array_map(
            static fn(array $union): string => $union['name'],
            $this->unions,
        ));
    }

    public function emit(Emitter $emitter): void
    {
        $emitter->wipe('src/Model/Union');

        foreach ($this->unions as $union) {
            $emitter->write('src/Model/Union/' . $union['name'] . '.php', $this->render($union));
        }
    }

    public function count(): int
    {
        return \count($this->unions);
    }

    private function claim(string $name): string
    {
        $candidate = $name;
        $suffix = 2;

        while (isset($this->takenNames[$candidate])) {
            $candidate = $name . $suffix++;
        }

        $this->takenNames[$candidate] = true;

        return $candidate;
    }

    /** @param array{name: string, discriminator: string|null, mapping: array<string, string>, shapes: array<string, list<string>>} $union */
    private function render(array $union): string
    {
        $variants = $union['discriminator'] !== null
            ? \array_values(\array_unique($union['mapping']))
            : \array_keys($union['shapes']);
        $returnType = \implode('|', $variants);

        $imports = ['Synchra\\Serialization\\Union'];

        foreach ($variants as $variant) {
            $imports[] = 'Synchra\\Model\\' . $variant;
        }

        $body = $union['discriminator'] !== null
            ? $this->renderTagged($union, $returnType)
            : $this->renderShaped($union, $returnType);

        return Emitter::file('Synchra\\Model\\Union', $imports, $body);
    }

    /** @param array{name: string, discriminator: string|null, mapping: array<string, string>, shapes: array<string, list<string>>} $union */
    private function renderTagged(array $union, string $returnType): string
    {
        $arms = [];

        foreach ($union['mapping'] as $tag => $class) {
            $arms[] = \sprintf("            '%s' => %s::fromArray(\$data),", \addcslashes($tag, "'\\"), $class);
        }

        $tags = \implode("', '", \array_keys($union['mapping']));
        $discriminator = $union['discriminator'] ?? 'type';

        $doc = Emitter::docBlock([
            \sprintf('Resolves a `%s` object to the variant named by its `%s` field.', $union['name'], $discriminator),
        ]);

        $methodDoc = Emitter::docBlock([
            '@param array<string, mixed> $data',
            '',
            '@throws \\Synchra\\Exception\\SerializationException When the tag is missing or unknown.',
        ], '    ');

        return $doc . \sprintf(
            <<<'PHP'
                final class %1$s
                {
                    public const DISCRIMINATOR = '%2$s';

                    /** @var list<string> */
                    public const TAGS = ['%3$s'];

                %4$s    public static function fromArray(array $data): %5$s
                    {
                        $tag = Union::tag($data, self::DISCRIMINATOR, self::class);

                        return match ($tag) {
                %6$s
                            default => throw Union::unknownTag($tag, self::DISCRIMINATOR, self::TAGS, self::class),
                        };
                    }
                }
                PHP,
            $union['name'],
            \addcslashes($discriminator, "'\\"),
            $tags,
            $methodDoc,
            $returnType,
            \implode("\n", $arms),
        );
    }

    /** @param array{name: string, discriminator: string|null, mapping: array<string, string>, shapes: array<string, list<string>>} $union */
    private function renderShaped(array $union, string $returnType): string
    {
        $arms = [];

        // Most specific first: a variant with more distinguishing fields is a narrower match, so
        // testing it earlier stops a broader variant from swallowing it.
        $shapes = $union['shapes'];
        \uasort($shapes, static fn(array $a, array $b): int => \count($b) <=> \count($a));

        foreach ($shapes as $class => $fields) {
            $list = $fields === [] ? '[]' : "['" . \implode("', '", $fields) . "']";
            $arms[] = \sprintf(
                "            Union::matchesShape(\$data, %s) => %s::fromArray(\$data),",
                $list,
                $class,
            );
        }

        $variantList = "'" . \implode("', '", \array_keys($union['shapes'])) . "'";

        $doc = Emitter::docBlock([
            \sprintf('Resolves a `%s` object by matching it against each variant.', $union['name']),
            '',
            'The description gives these alternatives no discriminator field, so the variant whose',
            'distinguishing fields are all present wins, most specific first.',
        ]);

        $methodDoc = Emitter::docBlock([
            '@param array<string, mixed> $data',
            '',
            '@throws \\Synchra\\Exception\\SerializationException When no variant matches.',
        ], '    ');

        return $doc . \sprintf(
            <<<'PHP'
                final class %1$s
                {
                    /** @var list<string> */
                    public const VARIANTS = [%2$s];

                %3$s    public static function fromArray(array $data): %4$s
                    {
                        return match (true) {
                %5$s
                            default => throw Union::noVariant($data, self::VARIANTS, self::class),
                        };
                    }
                }
                PHP,
            $union['name'],
            $variantList,
            $methodDoc,
            $returnType,
            \implode("\n", $arms),
        );
    }
}
