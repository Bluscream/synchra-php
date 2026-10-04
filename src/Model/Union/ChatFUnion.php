<?php

/*
 * This file is generated — do not edit it by hand.
 *
 * Source:    spec/openapi.json (and spec/websocket.md for the gateway)
 * Generator: tools/generate.php
 *
 * To pick up an API change: ./tools/fetch-spec.sh && composer generate
 */

declare(strict_types=1);

namespace Synchra\Model\Union;

use Synchra\Model\ChatFilterBannedTerms;
use Synchra\Model\ChatFilterCaps;
use Synchra\Model\ChatFilterEmote;
use Synchra\Model\ChatFilterLink;
use Synchra\Model\ChatFilterNonLatin;
use Synchra\Model\ChatFilterParagraph;
use Synchra\Model\ChatFilterSymbol;
use Synchra\Serialization\Union;

/**
 * Resolves a `ChatFUnion` object to the variant named by its `type` field.
 */
final class ChatFUnion
{
    public const DISCRIMINATOR = 'type';

    /** @var list<string> */
    public const TAGS = ['banned_terms', 'caps', 'emote', 'link', 'non_latin', 'paragraph', 'symbol'];

    /**
     * @param array<string, mixed> $data
     *
     * @throws \Synchra\Exception\SerializationException When the tag is missing or unknown.
     */
    public static function fromArray(array $data): ChatFilterBannedTerms|ChatFilterCaps|ChatFilterEmote|ChatFilterLink|ChatFilterNonLatin|ChatFilterParagraph|ChatFilterSymbol
    {
        $tag = Union::tag($data, self::DISCRIMINATOR, self::class);

        return match ($tag) {
            'banned_terms' => ChatFilterBannedTerms::fromArray($data),
            'caps' => ChatFilterCaps::fromArray($data),
            'emote' => ChatFilterEmote::fromArray($data),
            'link' => ChatFilterLink::fromArray($data),
            'non_latin' => ChatFilterNonLatin::fromArray($data),
            'paragraph' => ChatFilterParagraph::fromArray($data),
            'symbol' => ChatFilterSymbol::fromArray($data),
            default => throw Union::unknownTag($tag, self::DISCRIMINATOR, self::TAGS, self::class),
        };
    }
}
