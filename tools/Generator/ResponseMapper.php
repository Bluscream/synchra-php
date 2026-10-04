<?php

declare(strict_types=1);

namespace Synchra\Generator;

/**
 * Decides what a resource method returns, and the expression that produces it.
 */
final class ResponseMapper
{
    public function __construct(
        private readonly Spec $spec,
        private readonly TypeMapper $types,
        private readonly UnionRegistry $unions,
    ) {}

    /**
     * @param array<string, mixed> $schema
     *
     * @return array{native: string, expression: string, doc: string|null}
     */
    public function map(array $schema): array
    {
        if (Spec::dig($schema, 'discriminator', 'propertyName') !== null) {
            return $this->tagged($schema);
        }

        $ref = $schema['$ref'] ?? null;

        if (\is_string($ref)) {
            return $this->ref(Spec::refName($ref));
        }

        if (isset($schema['anyOf'])) {
            return $this->nullableRef($schema);
        }

        return match ($schema['type'] ?? null) {
            'array' => $this->arrayOf($schema),
            'object' => [
                'native' => 'array',
                'expression' => '$this->client->send($request)->object()',
                'doc' => 'array<string, mixed>',
            ],
            'integer' => [
                'native' => 'int',
                'expression' => '$this->client->send($request)->integer()',
                'doc' => null,
            ],
            default => [
                'native' => 'mixed',
                'expression' => '$this->client->send($request)->data',
                'doc' => null,
            ],
        };
    }

    /**
     * @param array<string, mixed> $schema
     *
     * @return array{native: string, expression: string, doc: string|null}
     */
    private function tagged(array $schema): array
    {
        $union = $this->unions->registerTagged($schema);
        $variants = \array_map(
            static fn(string $variant): string => '\\Synchra\\Model\\' . $variant,
            $this->unions->variants($union),
        );

        return [
            'native' => \implode('|', $variants),
            'expression' => \sprintf(
                '\\Synchra\\Model\\Union\\%s::fromArray($this->client->send($request)->object())',
                $union,
            ),
            'doc' => null,
        ];
    }

    /**
     * @return array{native: string, expression: string, doc: string|null}
     */
    private function ref(string $name): array
    {
        $pages = $this->spec->pageWrappers();

        if (isset($pages[$name])) {
            $item = '\\Synchra\\Model\\' . Names::schemaClass($pages[$name]);

            return [
                'native' => '\\Synchra\\Pagination\\Page',
                'expression' => \sprintf(
                    '\\Synchra\\Pagination\\Page::ofModel($this->client->send($request)->object(), %s::class)',
                    $item,
                ),
                'doc' => \sprintf('\\Synchra\\Pagination\\Page<%s>', $item),
            ];
        }

        if ($this->spec->isObjectSchema($name)) {
            $class = '\\Synchra\\Model\\' . Names::schemaClass($name);

            return [
                'native' => $class,
                'expression' => \sprintf('%s::fromArray($this->client->send($request)->object())', $class),
                'doc' => null,
            ];
        }

        if ($this->spec->isEnumSchema($name)) {
            $class = '\\Synchra\\Enum\\' . Names::schemaClass($name);

            return [
                'native' => $class,
                'expression' => \sprintf(
                    '%s::from($this->client->send($request)->data)',
                    $class,
                ),
                'doc' => null,
            ];
        }

        // An alias for a scalar or an open value.
        return [
            'native' => 'mixed',
            'expression' => '$this->client->send($request)->data',
            'doc' => null,
        ];
    }

    /**
     * `anyOf` at the response root is only ever "this model, or null".
     *
     * @param array<string, mixed> $schema
     *
     * @return array{native: string, expression: string, doc: string|null}
     */
    private function nullableRef(array $schema): array
    {
        /** @var list<array<string, mixed>> $branches */
        $branches = $schema['anyOf'];
        $class = null;

        foreach ($branches as $branch) {
            $resolved = $this->types->modelClassFor($branch);

            if ($resolved !== null) {
                $class = '\\Synchra\\Model\\' . $resolved;
            }
        }

        if ($class === null) {
            return [
                'native' => 'mixed',
                'expression' => '$this->client->send($request)->data',
                'doc' => null,
            ];
        }

        return [
            'native' => '?' . $class,
            'expression' => \sprintf(
                '($body = $this->client->send($request)->objectOrNull()) === null ? null : %s::fromArray($body)',
                $class,
            ),
            'doc' => null,
        ];
    }

    /**
     * @param array<string, mixed> $schema
     *
     * @return array{native: string, expression: string, doc: string|null}
     */
    private function arrayOf(array $schema): array
    {
        /** @var array<string, mixed> $items */
        $items = \is_array($schema['items'] ?? null) ? $schema['items'] : [];
        $class = $this->types->modelClassFor($items);

        if ($class === null) {
            return [
                'native' => 'array',
                'expression' => '$this->client->send($request)->list()',
                'doc' => 'list<mixed>',
            ];
        }

        $model = '\\Synchra\\Model\\' . $class;

        return [
            'native' => 'array',
            'expression' => \sprintf(
                '\\array_map(%s::fromArray(...), $this->client->send($request)->objects())',
                $model,
            ),
            'doc' => \sprintf('list<%s>', $model),
        ];
    }
}
