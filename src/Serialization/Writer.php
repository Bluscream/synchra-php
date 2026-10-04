<?php

declare(strict_types=1);

namespace Synchra\Serialization;

/**
 * Turns model properties back into wire values.
 *
 * The generated models call {@see self::payload()} from `jsonSerialize()`. Pass every field as
 * `[$wireName => [$value, $alwaysSend]]`: `$alwaysSend` is true for fields the schema marks
 * required or nullable, and false for optional non-nullable ones — those are dropped when null,
 * which is what makes a partial update send only the fields the caller actually set.
 */
final class Writer
{
    /**
     * @param array<string, array{mixed, bool}> $fields
     *
     * @return array<string, mixed>
     */
    public static function payload(array $fields): array
    {
        $out = [];

        foreach ($fields as $name => [$value, $alwaysSend]) {
            if ($value === null && !$alwaysSend) {
                continue;
            }

            $out[$name] = self::value($value);
        }

        return $out;
    }

    /**
     * Converts one value to its wire form, recursing into lists and maps.
     */
    public static function value(mixed $value): mixed
    {
        if ($value instanceof \DateTimeInterface) {
            // The API emits and accepts RFC 3339 with a trailing Z for UTC.
            return $value->format('Y-m-d\TH:i:s.up');
        }

        if ($value instanceof \BackedEnum) {
            return $value->value;
        }

        if ($value instanceof \JsonSerializable) {
            return $value->jsonSerialize();
        }

        if (\is_array($value)) {
            return \array_map(static fn(mixed $item): mixed => self::value($item), $value);
        }

        return $value;
    }
}
