<?php

declare(strict_types=1);

namespace Synchra\Http;

use Synchra\Exception\ConfigurationException;

/**
 * Fills the `{placeholder}` segments of an endpoint template.
 *
 * Values are percent-encoded per segment, so an id that somehow contains a slash cannot escape
 * its position and address a different endpoint.
 */
final class Path
{
    /**
     * @param array<string, string|int|\BackedEnum> $params
     */
    public static function expand(string $template, array $params = []): string
    {
        $result = \preg_replace_callback(
            '/\{([A-Za-z_][A-Za-z0-9_]*)\}/',
            static function (array $match) use ($params, $template): string {
                $name = $match[1];

                if (!\array_key_exists($name, $params)) {
                    throw new ConfigurationException(\sprintf(
                        'Path "%s" needs a value for {%s}.',
                        $template,
                        $name,
                    ));
                }

                return self::segment($params[$name], $name);
            },
            $template,
        );

        if ($result === null) {
            throw new ConfigurationException(\sprintf('Could not expand path template "%s".', $template));
        }

        return $result;
    }

    private static function segment(string|int|\BackedEnum $value, string $name): string
    {
        $raw = $value instanceof \BackedEnum ? (string) $value->value : (string) $value;

        if ($raw === '') {
            throw new ConfigurationException(\sprintf('Path parameter {%s} cannot be empty.', $name));
        }

        return \rawurlencode($raw);
    }
}
