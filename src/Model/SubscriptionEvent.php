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

use Synchra\Enum\SubscriptionEventStatus;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `SubscriptionEvent` schema.
 */
final readonly class SubscriptionEvent implements DataModel
{
    public function __construct(
        public string $id,
        public ?string $channel_id,
        public ?string $channel_name,
        public string $provider,
        public string $external_event_id,
        public string $event_type,
        public SubscriptionEventStatus $status,
        public int $attempts,
        public ?string $last_error,
        public \DateTimeImmutable $received_at,
        public ?\DateTimeImmutable $processed_at,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            id: $reader->requiredString('id'),
            channel_id: $reader->optionalString('channel_id'),
            channel_name: $reader->optionalString('channel_name'),
            provider: $reader->requiredString('provider'),
            external_event_id: $reader->requiredString('external_event_id'),
            event_type: $reader->requiredString('event_type'),
            status: $reader->requiredEnum('status', SubscriptionEventStatus::class),
            attempts: $reader->requiredInt('attempts'),
            last_error: $reader->optionalString('last_error'),
            received_at: $reader->requiredDateTime('received_at'),
            processed_at: $reader->optionalDateTime('processed_at'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'id' => [$this->id, true],
            'channel_id' => [$this->channel_id, true],
            'channel_name' => [$this->channel_name, true],
            'provider' => [$this->provider, true],
            'external_event_id' => [$this->external_event_id, true],
            'event_type' => [$this->event_type, true],
            'status' => [$this->status, true],
            'attempts' => [$this->attempts, true],
            'last_error' => [$this->last_error, true],
            'received_at' => [$this->received_at, true],
            'processed_at' => [$this->processed_at, true],
        ]);
    }
}
