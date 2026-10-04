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

use Synchra\Model\CommandScriptTestActivityContext;
use Synchra\Model\CommandScriptTestChatContext;
use Synchra\Serialization\Union;

/**
 * Resolves a `CommandScriptTContextUnion` object to the variant named by its `trigger` field.
 */
final class CommandScriptTContextUnion
{
    public const DISCRIMINATOR = 'trigger';

    /** @var list<string> */
    public const TAGS = ['activity', 'chat_message'];

    /**
     * @param array<string, mixed> $data
     *
     * @throws \Synchra\Exception\SerializationException When the tag is missing or unknown.
     */
    public static function fromArray(array $data): CommandScriptTestActivityContext|CommandScriptTestChatContext
    {
        $tag = Union::tag($data, self::DISCRIMINATOR, self::class);

        return match ($tag) {
            'activity' => CommandScriptTestActivityContext::fromArray($data),
            'chat_message' => CommandScriptTestChatContext::fromArray($data),
            default => throw Union::unknownTag($tag, self::DISCRIMINATOR, self::TAGS, self::class),
        };
    }
}
