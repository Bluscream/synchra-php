<?php

declare(strict_types=1);

namespace Synchra\Generator;

/**
 * Read access to the vendored OpenAPI document.
 */
final class Spec
{
    /** @var array<string, array<string, mixed>> */
    public readonly array $schemas;

    /** @var list<Operation> */
    public readonly array $operations;

    /** @param array<string, mixed> $document */
    public function __construct(public readonly array $document)
    {
        $schemas = [];

        foreach (self::objectAt($document, 'components', 'schemas') ?? [] as $name => $schema) {
            if (\is_array($schema)) {
                $schemas[$name] = self::stringKeyed($schema);
            }
        }

        $this->schemas = $schemas;
        $this->operations = $this->collectOperations();
    }

    /**
     * Walks a path of keys through nested arrays, stopping at the first one that is missing or
     * does not hold an array.
     *
     * A JSON document is `mixed` all the way down, so reading
     * `$doc['responses']['200']['content']['application/json']['schema']` in one chain is five
     * offset accesses static analysis cannot verify. This narrows at every step instead.
     *
     * @param array<array-key, mixed> $data
     */
    public static function dig(array $data, string ...$keys): mixed
    {
        $value = $data;

        foreach ($keys as $key) {
            if (!\is_array($value) || !\array_key_exists($key, $value)) {
                return null;
            }

            $value = $value[$key];
        }

        return $value;
    }

    /**
     * {@see self::dig()}, for a path that is expected to end at a JSON object.
     *
     * @param array<array-key, mixed> $data
     *
     * @return array<string, mixed>|null
     */
    public static function objectAt(array $data, string ...$keys): ?array
    {
        $value = self::dig($data, ...$keys);

        return \is_array($value) ? self::stringKeyed($value) : null;
    }

    /**
     * Re-keys a decoded JSON object so its key type is provable.
     *
     * @param array<array-key, mixed> $value
     *
     * @return array<string, mixed>
     */
    public static function stringKeyed(array $value): array
    {
        $out = [];

        foreach ($value as $key => $item) {
            $out[(string) $key] = $item;
        }

        return $out;
    }

    public static function fromFile(string $path): self
    {
        $raw = \file_get_contents($path);

        if ($raw === false) {
            throw new \RuntimeException("Could not read the API description at {$path}.");
        }

        /** @var array<string, mixed> $decoded */
        $decoded = \json_decode($raw, true, 512, \JSON_THROW_ON_ERROR);

        return new self($decoded);
    }

    /** @return array<string, mixed> */
    public function schema(string $name): array
    {
        return $this->schemas[$name] ?? throw new \RuntimeException("Unknown schema {$name}.");
    }

    /**
     * Resolves a `$ref` to the schema name it points at.
     */
    public static function refName(string $ref): string
    {
        $parts = \explode('/', $ref);

        return \end($parts);
    }

    public function isEnumSchema(string $name): bool
    {
        return isset($this->schemas[$name]['enum']);
    }

    public function isObjectSchema(string $name): bool
    {
        return isset($this->schemas[$name]['properties']);
    }

    /**
     * Names of the `PageCursor_X_` wrappers, mapped to the schema they page over.
     *
     * @return array<string, string>
     */
    public function pageWrappers(): array
    {
        $out = [];

        foreach ($this->schemas as $name => $schema) {
            if (!\str_starts_with($name, 'PageCursor_')) {
                continue;
            }

            $itemRef = self::dig($schema, 'properties', 'records', 'items', '$ref');

            if (\is_string($itemRef)) {
                $out[$name] = self::refName($itemRef);
            }
        }

        return $out;
    }

    /** @return list<Operation> */
    private function collectOperations(): array
    {
        /** @var array<string, array<string, mixed>> $paths */
        $paths = $this->document['paths'] ?? [];
        $operations = [];

        foreach ($paths as $path => $item) {
            foreach ($item as $method => $operation) {
                if (!\in_array($method, ['get', 'post', 'put', 'patch', 'delete'], true) || !\is_array($operation)) {
                    continue;
                }

                /** @var array<string, mixed> $operation */
                $operations[] = new Operation($path, \strtoupper($method), $operation);
            }
        }

        \usort($operations, static fn(Operation $a, Operation $b): int => [$a->tag, $a->path, $a->method] <=> [$b->tag, $b->path, $b->method]);

        return $operations;
    }
}
