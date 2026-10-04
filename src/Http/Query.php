<?php

declare(strict_types=1);

namespace Synchra\Http;

use Synchra\Serialization\Writer;

/**
 * Builds the query string for a request.
 *
 * Null means "not sent" rather than "send null", repeated parameters are emitted once per value
 * (`?status=pending&status=live`, which is what the API expects for its list filters), and
 * booleans are spelled `true`/`false` rather than PHP's `1`/``.
 */
final class Query
{
    /**
     * @param array<string, mixed> $params
     */
    public static function build(array $params): string
    {
        $pairs = [];

        foreach ($params as $name => $value) {
            if ($value === null) {
                continue;
            }

            foreach (self::flatten($value) as $scalar) {
                $pairs[] = \rawurlencode($name) . '=' . \rawurlencode($scalar);
            }
        }

        return \implode('&', $pairs);
    }

    /**
     * @return list<string>
     */
    private static function flatten(mixed $value): array
    {
        $wire = Writer::value($value);

        if (\is_array($wire)) {
            $out = [];

            foreach ($wire as $item) {
                foreach (self::flatten($item) as $scalar) {
                    $out[] = $scalar;
                }
            }

            return $out;
        }

        return [self::scalar($wire)];
    }

    private static function scalar(mixed $value): string
    {
        return match (true) {
            \is_bool($value) => $value ? 'true' : 'false',
            \is_string($value) => $value,
            \is_int($value), \is_float($value) => (string) $value,
            default => throw new \Synchra\Exception\ConfigurationException(\sprintf(
                'Query parameters must be scalar, %s given.',
                \get_debug_type($value),
            )),
        };
    }
}
