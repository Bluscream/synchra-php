<?php

declare(strict_types=1);

namespace Synchra\Serialization;

use Synchra\Exception\SerializationException;

/**
 * Reads typed values out of a decoded JSON object, failing loudly on anything the schema did
 * not promise.
 *
 * The generated models read every field through this class, so a response that has drifted
 * from the vendored API description produces one precise error naming the model and field
 * instead of a type error deep inside a constructor.
 */
final class Reader
{
    /** @param array<string, mixed> $data */
    public function __construct(
        private readonly array $data,
        private readonly string $model,
    ) {}

    /** @return array<string, mixed> */
    public function raw(): array
    {
        return $this->data;
    }

    public function requiredString(string $key): string
    {
        $value = $this->required($key);

        return \is_string($value) ? $value : $this->fail($key, 'string', $value);
    }

    public function optionalString(string $key): ?string
    {
        $value = $this->optional($key);

        return $value === null || \is_string($value) ? $value : $this->fail($key, 'string', $value);
    }

    public function requiredInt(string $key): int
    {
        $value = $this->required($key);

        return \is_int($value) ? $value : $this->fail($key, 'integer', $value);
    }

    public function optionalInt(string $key): ?int
    {
        $value = $this->optional($key);

        return $value === null || \is_int($value) ? $value : $this->fail($key, 'integer', $value);
    }

    public function requiredFloat(string $key): float
    {
        $value = $this->required($key);

        // JSON has one number type, so a whole number arrives as an int even where the schema
        // says number — 0 and 0.0 are the same value on the wire.
        return \is_float($value) || \is_int($value) ? (float) $value : $this->fail($key, 'number', $value);
    }

    public function optionalFloat(string $key): ?float
    {
        $value = $this->optional($key);

        if ($value === null) {
            return null;
        }

        return \is_float($value) || \is_int($value) ? (float) $value : $this->fail($key, 'number', $value);
    }

    public function requiredBool(string $key): bool
    {
        $value = $this->required($key);

        return \is_bool($value) ? $value : $this->fail($key, 'boolean', $value);
    }

    public function optionalBool(string $key): ?bool
    {
        $value = $this->optional($key);

        return $value === null || \is_bool($value) ? $value : $this->fail($key, 'boolean', $value);
    }

    public function requiredDateTime(string $key): \DateTimeImmutable
    {
        return $this->parseDateTime($key, $this->requiredString($key));
    }

    public function optionalDateTime(string $key): ?\DateTimeImmutable
    {
        $value = $this->optionalString($key);

        return $value === null ? null : $this->parseDateTime($key, $value);
    }

    public function mixed(string $key): mixed
    {
        return $this->data[$key] ?? null;
    }

    /**
     * @template T of DataModel
     *
     * @param class-string<T> $class
     *
     * @return T
     */
    public function requiredModel(string $key, string $class): DataModel
    {
        return $class::fromArray($this->requiredObject($key));
    }

    /**
     * @template T of DataModel
     *
     * @param class-string<T> $class
     *
     * @return T|null
     */
    public function optionalModel(string $key, string $class): ?DataModel
    {
        $value = $this->optional($key);

        if ($value === null) {
            return null;
        }

        return $class::fromArray($this->asObject($key, $value));
    }

    /**
     * @template T of \BackedEnum
     *
     * @param class-string<T> $class
     *
     * @return T
     */
    public function requiredEnum(string $key, string $class): \BackedEnum
    {
        return $this->toEnum($key, $this->required($key), $class);
    }

    /**
     * @template T of \BackedEnum
     *
     * @param class-string<T> $class
     *
     * @return T|null
     */
    public function optionalEnum(string $key, string $class): ?\BackedEnum
    {
        $value = $this->optional($key);

        return $value === null ? null : $this->toEnum($key, $value, $class);
    }

    /**
     * @template T of DataModel
     *
     * @param class-string<T> $class
     *
     * @return list<T>
     */
    public function requiredModelList(string $key, string $class): array
    {
        $out = [];

        foreach ($this->requiredList($key) as $index => $item) {
            $out[] = $class::fromArray($this->asObject("{$key}[{$index}]", $item));
        }

        return $out;
    }

    /**
     * @template T of DataModel
     *
     * @param class-string<T> $class
     *
     * @return list<T>|null
     */
    public function optionalModelList(string $key, string $class): ?array
    {
        return $this->optional($key) === null ? null : $this->requiredModelList($key, $class);
    }

    /**
     * @template T of \BackedEnum
     *
     * @param class-string<T> $class
     *
     * @return list<T>
     */
    public function requiredEnumList(string $key, string $class): array
    {
        $out = [];

        foreach ($this->requiredList($key) as $index => $item) {
            $out[] = $this->toEnum("{$key}[{$index}]", $item, $class);
        }

        return $out;
    }

    /**
     * @template T of \BackedEnum
     *
     * @param class-string<T> $class
     *
     * @return list<T>|null
     */
    public function optionalEnumList(string $key, string $class): ?array
    {
        return $this->optional($key) === null ? null : $this->requiredEnumList($key, $class);
    }

    /** @return list<string> */
    public function requiredStringList(string $key): array
    {
        $out = [];

        foreach ($this->requiredList($key) as $index => $item) {
            $out[] = \is_string($item) ? $item : $this->fail("{$key}[{$index}]", 'string', $item);
        }

        return $out;
    }

    /** @return list<string>|null */
    public function optionalStringList(string $key): ?array
    {
        return $this->optional($key) === null ? null : $this->requiredStringList($key);
    }

    /** @return list<int> */
    public function requiredIntList(string $key): array
    {
        $out = [];

        foreach ($this->requiredList($key) as $index => $item) {
            $out[] = \is_int($item) ? $item : $this->fail("{$key}[{$index}]", 'integer', $item);
        }

        return $out;
    }

    /** @return list<int>|null */
    public function optionalIntList(string $key): ?array
    {
        return $this->optional($key) === null ? null : $this->requiredIntList($key);
    }

    /** @return list<float> */
    public function requiredFloatList(string $key): array
    {
        $out = [];

        foreach ($this->requiredList($key) as $index => $item) {
            $out[] = \is_float($item) || \is_int($item)
                ? (float) $item
                : $this->fail("{$key}[{$index}]", 'number', $item);
        }

        return $out;
    }

    /** @return list<float>|null */
    public function optionalFloatList(string $key): ?array
    {
        return $this->optional($key) === null ? null : $this->requiredFloatList($key);
    }

    /** @return list<mixed> */
    public function requiredMixedList(string $key): array
    {
        return $this->requiredList($key);
    }

    /** @return list<mixed>|null */
    public function optionalMixedList(string $key): ?array
    {
        return $this->optional($key) === null ? null : $this->requiredList($key);
    }

    /** @return array<string, mixed> */
    public function requiredMap(string $key): array
    {
        return $this->requiredObject($key);
    }

    /** @return array<string, mixed>|null */
    public function optionalMap(string $key): ?array
    {
        $value = $this->optional($key);

        return $value === null ? null : $this->asObject($key, $value);
    }

    /**
     * Hydrates a value through a factory — used for the generated union resolvers, which are not
     * themselves models.
     *
     * @template T
     *
     * @param callable(array<string, mixed>): T $factory
     *
     * @return T
     */
    public function requiredVia(string $key, callable $factory): mixed
    {
        return $factory($this->requiredObject($key));
    }

    /**
     * @template T
     *
     * @param callable(array<string, mixed>): T $factory
     *
     * @return T|null
     */
    public function optionalVia(string $key, callable $factory): mixed
    {
        $value = $this->optional($key);

        return $value === null ? null : $factory($this->asObject($key, $value));
    }

    /**
     * @template T
     *
     * @param callable(array<string, mixed>): T $factory
     *
     * @return list<T>
     */
    public function requiredListVia(string $key, callable $factory): array
    {
        $out = [];

        foreach ($this->requiredList($key) as $index => $item) {
            $out[] = $factory($this->asObject("{$key}[{$index}]", $item));
        }

        return $out;
    }

    /**
     * @template T
     *
     * @param callable(array<string, mixed>): T $factory
     *
     * @return list<T>|null
     */
    public function optionalListVia(string $key, callable $factory): ?array
    {
        return $this->optional($key) === null ? null : $this->requiredListVia($key, $factory);
    }

    private function required(string $key): mixed
    {
        if (!\array_key_exists($key, $this->data)) {
            throw new SerializationException(\sprintf(
                '%s is missing required field "%s". The vendored API description may be out of date — '
                . 'run tools/fetch-spec.sh and regenerate.',
                $this->model,
                $key,
            ));
        }

        $value = $this->data[$key];

        if ($value === null) {
            throw new SerializationException(\sprintf(
                '%s received null for required field "%s".',
                $this->model,
                $key,
            ));
        }

        return $value;
    }

    private function optional(string $key): mixed
    {
        return $this->data[$key] ?? null;
    }

    /** @return array<string, mixed> */
    private function requiredObject(string $key): array
    {
        return $this->asObject($key, $this->required($key));
    }

    /** @return array<string, mixed> */
    private function asObject(string $key, mixed $value): array
    {
        if (!\is_array($value)) {
            $this->fail($key, 'object', $value);
        }

        /** @var array<string, mixed> $value */
        return $value;
    }

    /** @return list<mixed> */
    private function requiredList(string $key): array
    {
        $value = $this->required($key);

        if (!\is_array($value) || !\array_is_list($value)) {
            $this->fail($key, 'array', $value);
        }

        return $value;
    }

    /**
     * @template T of \BackedEnum
     *
     * @param class-string<T> $class
     *
     * @return T
     */
    private function toEnum(string $key, mixed $value, string $class): \BackedEnum
    {
        if (!\is_string($value) && !\is_int($value)) {
            $this->fail($key, 'string or integer', $value);
        }

        $case = $class::tryFrom($value);

        if ($case === null) {
            throw new SerializationException(\sprintf(
                '%s.%s has value %s, which is not a case of %s. The API may have added a value — '
                . 'run tools/fetch-spec.sh and regenerate.',
                $this->model,
                $key,
                \json_encode($value),
                $class,
            ));
        }

        return $case;
    }

    private function parseDateTime(string $key, string $value): \DateTimeImmutable
    {
        try {
            return new \DateTimeImmutable($value);
        } catch (\Exception $e) {
            throw new SerializationException(
                \sprintf('%s.%s is not a parsable timestamp: %s', $this->model, $key, $value),
                0,
                $e,
            );
        }
    }

    /** @return never */
    private function fail(string $key, string $expected, mixed $actual): mixed
    {
        throw new SerializationException(\sprintf(
            '%s.%s should be %s, got %s.',
            $this->model,
            $key,
            $expected,
            \get_debug_type($actual),
        ));
    }
}
