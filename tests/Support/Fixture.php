<?php

declare(strict_types=1);

namespace Synchra\Tests\Support;

/**
 * Loads a recorded API response from `tests/Fixtures`.
 *
 * The fixtures are real responses from `api.synchra.net`, passed through
 * `tools/sanitise-fixtures.py`: shape, keys and enum values are untouched, while ids, handles,
 * display names, avatar URLs and anything a person typed are replaced with placeholders. That is
 * what lets the hydration tests assert against the API as it actually answers without publishing
 * anyone's data.
 */
final class Fixture
{
    public const DIRECTORY = __DIR__ . '/../Fixtures';

    /** @return array<string, mixed> */
    public static function object(string $name): array
    {
        $decoded = self::decode($name);

        if (!\is_array($decoded) || \array_is_list($decoded)) {
            throw new \RuntimeException("Fixture {$name} is not a JSON object.");
        }

        /** @var array<string, mixed> $decoded */
        return $decoded;
    }

    /** @return list<array<string, mixed>> */
    public static function objects(string $name): array
    {
        $decoded = self::decode($name);

        if (!\is_array($decoded) || !\array_is_list($decoded)) {
            throw new \RuntimeException("Fixture {$name} is not a JSON array.");
        }

        $out = [];

        foreach ($decoded as $index => $item) {
            if (!\is_array($item) || \array_is_list($item)) {
                throw new \RuntimeException("Fixture {$name} index {$index} is not an object.");
            }

            /** @var array<string, mixed> $item */
            $out[] = $item;
        }

        return $out;
    }

    public static function raw(string $name): string
    {
        $path = self::DIRECTORY . '/' . $name;
        $raw = \file_get_contents($path);

        if ($raw === false) {
            throw new \RuntimeException("Could not read fixture {$path}.");
        }

        return $raw;
    }

    /** @return list<string> */
    public static function names(): array
    {
        $names = [];

        foreach (\glob(self::DIRECTORY . '/*.json') ?: [] as $path) {
            $names[] = \basename($path);
        }

        return $names;
    }

    private static function decode(string $name): mixed
    {
        return \json_decode(self::raw($name), true, 512, \JSON_THROW_ON_ERROR);
    }
}
