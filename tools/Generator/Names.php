<?php

declare(strict_types=1);

namespace Synchra\Generator;

/**
 * Turns names from the API description into PHP identifiers.
 *
 * Everything here is deterministic: the same description always produces the same identifiers,
 * so regenerating after an unrelated API change does not churn the whole tree.
 */
final class Names
{
    /**
     * Schema names the description spells awkwardly, or that FastAPI derived from a Python type
     * annotation and so carry the whole annotation in the name.
     *
     * @var array<string, string>
     */
    private const SCHEMA_OVERRIDES = [
        'UserProfiles_Annotated_Union_DashboardUserProfile__ChatUserProfile__ActivityFeedUserProfile__ControlsUserProfile___FieldInfo_annotation_NoneType__required_True__discriminator__type____' => 'UserProfileList',
    ];

    /**
     * Tags whose PHP name needs the API's own capitalisation rather than title case.
     *
     * @var array<string, string>
     */
    private const TAG_OVERRIDES = [
        'ElevenLabs' => 'ElevenLabs',
        'StreamElements' => 'StreamElements',
        'TTSMonster' => 'TtsMonster',
        'WebSocket' => 'Gateway',
        'YouTube' => 'YouTube',
        'OBS Remote' => 'ObsRemote',
        'Ko-fi' => 'KoFi',
        'Admin HTTP Proxies' => 'AdminHttpProxies',
    ];

    /**
     * Operations whose summary is not unique inside its tag, or is actively misleading — the
     * Twitch and YouTube moderator endpoints are all summarised "Ban User".
     *
     * Keyed by `METHOD path`.
     *
     * @var array<string, string>
     */
    private const METHOD_OVERRIDES = [
        'POST /api/2/channels/{channel_id}/twitch/{channel_provider_id}/moderators' => 'addModerator',
        'DELETE /api/2/channels/{channel_id}/twitch/{channel_provider_id}/moderators' => 'removeModerator',
        'POST /api/2/channels/{channel_id}/youtube/{channel_provider_id}/moderators' => 'addModerator',
        'DELETE /api/2/channels/{channel_id}/youtube/{channel_provider_id}/moderators' => 'removeModerator',
        'PUT /api/2/channels/{channel_id}/providers/{channel_provider_id}/stream' => 'updateStream',
    ];

    public static function schemaClass(string $name): string
    {
        return self::pascal(self::SCHEMA_OVERRIDES[$name] ?? $name);
    }

    public static function tagClass(string $tag): string
    {
        return self::TAG_OVERRIDES[$tag] ?? self::pascal($tag);
    }

    public static function operationMethod(string $httpMethod, string $path, string $summary): string
    {
        $override = self::METHOD_OVERRIDES[\strtoupper($httpMethod) . ' ' . $path] ?? null;

        if ($override !== null) {
            return $override;
        }

        // Summaries generated from FastAPI route function names keep a "Route" suffix that says
        // nothing about the operation.
        $cleaned = \preg_replace('/\s+Route$/i', '', $summary) ?? $summary;

        return self::camel($cleaned);
    }

    public static function pascal(string $value): string
    {
        $words = \preg_split('/[^A-Za-z0-9]+/', $value, -1, \PREG_SPLIT_NO_EMPTY) ?: [];
        $out = '';

        foreach ($words as $word) {
            // Keep inner capitals that are already meaningful (HTTP, TTS, OBS) instead of
            // lowercasing them into Http, Tts, Obs.
            $out .= \ctype_upper($word) ? \ucfirst(\strtolower($word)) : \ucfirst($word);
        }

        if ($out === '') {
            return 'Unnamed';
        }

        return \ctype_digit($out[0]) ? 'N' . $out : $out;
    }

    public static function camel(string $value): string
    {
        $pascal = self::pascal($value);

        return \lcfirst($pascal);
    }

    /**
     * A PHP enum case name for one wire value.
     */
    public static function enumCase(string|int $value): string
    {
        if (\is_int($value)) {
            return 'N' . ($value < 0 ? 'eg' . \abs($value) : (string) $value);
        }

        $name = self::pascal($value);

        return $name === 'Unnamed' ? 'Empty' : $name;
    }

    /**
     * Longest common prefix plus longest common suffix of the union's variant names, which is how
     * a union of `ChatWidget`, `CustomWidget`, … becomes `Widget`.
     *
     * @param list<string> $variants
     */
    public static function unionName(array $variants): string
    {
        if ($variants === []) {
            return 'Unnamed';
        }

        if (\count($variants) === 1) {
            return $variants[0];
        }

        $prefix = self::commonPrefix($variants);
        $suffix = self::commonSuffix($variants);
        $name = $prefix . $suffix;

        return $name === '' ? $variants[0] . 'Variant' : self::pascal($name);
    }

    /** @param list<string> $values */
    private static function commonPrefix(array $values): string
    {
        $prefix = $values[0];

        foreach ($values as $value) {
            $length = \min(\strlen($prefix), \strlen($value));

            while ($length > 0 && \substr($prefix, 0, $length) !== \substr($value, 0, $length)) {
                --$length;
            }

            $prefix = \substr($prefix, 0, $length);
        }

        // Only keep a prefix that ends on a word boundary, so ChatFilterCaps/ChatFilterCapsUpdate
        // do not yield "ChatFilterCap".
        return \preg_replace('/[a-z0-9]+$/', '', $prefix) ?? '';
    }

    /** @param list<string> $values */
    private static function commonSuffix(array $values): string
    {
        $reversed = \array_map(\strrev(...), $values);
        $suffix = $reversed[0];

        foreach ($reversed as $value) {
            $length = \min(\strlen($suffix), \strlen($value));

            while ($length > 0 && \substr($suffix, 0, $length) !== \substr($value, 0, $length)) {
                --$length;
            }

            $suffix = \substr($suffix, 0, $length);
        }

        $suffix = \strrev($suffix);

        return \preg_replace('/^[a-z0-9]+/', '', $suffix) ?? '';
    }
}
