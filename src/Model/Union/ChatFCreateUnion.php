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

use Synchra\Model\ChatFilterBannedTermsCreate;
use Synchra\Model\ChatFilterCapsCreate;
use Synchra\Model\ChatFilterEmoteCreate;
use Synchra\Model\ChatFilterLinkCreate;
use Synchra\Model\ChatFilterNonLatinCreate;
use Synchra\Model\ChatFilterParagraphCreate;
use Synchra\Model\ChatFilterSymbolCreate;
use Synchra\Serialization\Union;

/**
 * Resolves a `ChatFCreateUnion` object to the variant named by its `type` field.
 */
final class ChatFCreateUnion
{
    public const DISCRIMINATOR = 'type';

    /** @var list<string> */
    public const TAGS = ['banned_terms', 'caps', 'emote', 'link', 'non_latin', 'paragraph', 'symbol'];

    /**
     * @param array<string, mixed> $data
     *
     * @throws \Synchra\Exception\SerializationException When the tag is missing or unknown.
     */
    public static function fromArray(array $data): ChatFilterBannedTermsCreate|ChatFilterCapsCreate|ChatFilterEmoteCreate|ChatFilterLinkCreate|ChatFilterNonLatinCreate|ChatFilterParagraphCreate|ChatFilterSymbolCreate
    {
        $tag = Union::tag($data, self::DISCRIMINATOR, self::class);

        return match ($tag) {
            'banned_terms' => ChatFilterBannedTermsCreate::fromArray($data),
            'caps' => ChatFilterCapsCreate::fromArray($data),
            'emote' => ChatFilterEmoteCreate::fromArray($data),
            'link' => ChatFilterLinkCreate::fromArray($data),
            'non_latin' => ChatFilterNonLatinCreate::fromArray($data),
            'paragraph' => ChatFilterParagraphCreate::fromArray($data),
            'symbol' => ChatFilterSymbolCreate::fromArray($data),
            default => throw Union::unknownTag($tag, self::DISCRIMINATOR, self::TAGS, self::class),
        };
    }
}
