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

namespace Synchra\Model;

use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `CommandScriptTestChatContext` schema.
 */
final readonly class CommandScriptTestChatContext implements DataModel
{
    public function __construct(
        public string $message,
        public string $viewer_name,
        public string $viewer_display_name,
        public string $trigger = 'chat_message',
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            message: $reader->requiredString('message'),
            viewer_name: $reader->requiredString('viewer_name'),
            viewer_display_name: $reader->requiredString('viewer_display_name'),
            trigger: $reader->requiredString('trigger'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'message' => [$this->message, true],
            'viewer_name' => [$this->viewer_name, true],
            'viewer_display_name' => [$this->viewer_display_name, true],
            'trigger' => [$this->trigger, true],
        ]);
    }
}
