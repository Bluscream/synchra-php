<?php

declare(strict_types=1);

namespace Synchra\Serialization;

use Synchra\Exception\SerializationException;

/**
 * Helpers the generated union classes use to pick a variant.
 *
 * Synchra uses tagged unions for widgets, chat filters, user profiles and OBS remote commands:
 * one field — usually `type` — names which variant an object is. The generated classes in
 * {@see \Synchra\Model\Union} do the dispatch themselves so the result is a precise type rather
 * than a common interface; this class only reads the tag and builds the failure messages.
 */
final class Union
{
    /**
     * Reads the discriminator value out of a union object.
     *
     * @param array<string, mixed> $data
     */
    public static function tag(array $data, string $discriminator, string $union): string
    {
        $tag = $data[$discriminator] ?? null;

        if (!\is_string($tag)) {
            throw new SerializationException(\sprintf(
                '%s needs a string "%s" to tell its variants apart, got %s.',
                $union,
                $discriminator,
                \get_debug_type($tag),
            ));
        }

        return $tag;
    }

    /**
     * Whether every one of a variant's distinguishing fields is present.
     *
     * @param array<string, mixed> $data
     * @param list<string> $fields
     */
    public static function matchesShape(array $data, array $fields): bool
    {
        foreach ($fields as $field) {
            if (!\array_key_exists($field, $data)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param list<string> $known
     */
    public static function unknownTag(string $tag, string $discriminator, array $known, string $union): SerializationException
    {
        return new SerializationException(\sprintf(
            '%s has %s "%s", which matches no known variant (expected one of: %s). '
            . 'Run tools/fetch-spec.sh and regenerate if the API added a variant.',
            $union,
            $discriminator,
            $tag,
            \implode(', ', $known),
        ));
    }

    /**
     * @param array<string, mixed> $data
     * @param list<string> $variants
     */
    public static function noVariant(array $data, array $variants, string $union): SerializationException
    {
        return new SerializationException(\sprintf(
            '%s matched none of its variants (%s) — fields present: %s.',
            $union,
            \implode(', ', $variants),
            \implode(', ', \array_keys($data)),
        ));
    }
}
