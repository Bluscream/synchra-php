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
 * The `ChatMessageParent` schema.
 */
final readonly class ChatMessageParent implements DataModel
{
    public function __construct(
        public string $provider_message_id,
        public string $message,
        public string $provider_viewer_id,
        public string $viewer_name,
        public string $viewer_display_name,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            provider_message_id: $reader->requiredString('provider_message_id'),
            message: $reader->requiredString('message'),
            provider_viewer_id: $reader->requiredString('provider_viewer_id'),
            viewer_name: $reader->requiredString('viewer_name'),
            viewer_display_name: $reader->requiredString('viewer_display_name'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'provider_message_id' => [$this->provider_message_id, true],
            'message' => [$this->message, true],
            'provider_viewer_id' => [$this->provider_viewer_id, true],
            'viewer_name' => [$this->viewer_name, true],
            'viewer_display_name' => [$this->viewer_display_name, true],
        ]);
    }
}
