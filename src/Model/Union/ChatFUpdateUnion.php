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

use Synchra\Model\ChatFilterBannedTermsUpdate;
use Synchra\Model\ChatFilterCapsUpdate;
use Synchra\Model\ChatFilterEmoteUpdate;
use Synchra\Model\ChatFilterLinkUpdate;
use Synchra\Model\ChatFilterNonLatinUpdate;
use Synchra\Model\ChatFilterParagraphUpdate;
use Synchra\Model\ChatFilterSymbolUpdate;
use Synchra\Serialization\Union;

/**
 * Resolves a `ChatFUpdateUnion` object to the variant named by its `type` field.
 */
final class ChatFUpdateUnion
{
    public const DISCRIMINATOR = 'type';

    /** @var list<string> */
    public const TAGS = ['banned_terms', 'caps', 'emote', 'link', 'non_latin', 'paragraph', 'symbol'];

    /**
     * @param array<string, mixed> $data
     *
     * @throws \Synchra\Exception\SerializationException When the tag is missing or unknown.
     */
    public static function fromArray(array $data): ChatFilterBannedTermsUpdate|ChatFilterCapsUpdate|ChatFilterEmoteUpdate|ChatFilterLinkUpdate|ChatFilterNonLatinUpdate|ChatFilterParagraphUpdate|ChatFilterSymbolUpdate
    {
        $tag = Union::tag($data, self::DISCRIMINATOR, self::class);

        return match ($tag) {
            'banned_terms' => ChatFilterBannedTermsUpdate::fromArray($data),
            'caps' => ChatFilterCapsUpdate::fromArray($data),
            'emote' => ChatFilterEmoteUpdate::fromArray($data),
            'link' => ChatFilterLinkUpdate::fromArray($data),
            'non_latin' => ChatFilterNonLatinUpdate::fromArray($data),
            'paragraph' => ChatFilterParagraphUpdate::fromArray($data),
            'symbol' => ChatFilterSymbolUpdate::fromArray($data),
            default => throw Union::unknownTag($tag, self::DISCRIMINATOR, self::TAGS, self::class),
        };
    }
}
