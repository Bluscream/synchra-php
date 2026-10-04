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
 * The `ChatMessagePinUpdateRequest` schema.
 */
final readonly class ChatMessagePinUpdateRequest implements DataModel
{
    public function __construct(
        public string $channel_provider_id,
        public ?int $duration_seconds = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            channel_provider_id: $reader->requiredString('channel_provider_id'),
            duration_seconds: $reader->optionalInt('duration_seconds'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'channel_provider_id' => [$this->channel_provider_id, true],
            'duration_seconds' => [$this->duration_seconds, true],
        ]);
    }
}
