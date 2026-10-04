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

use Synchra\Enum\Provider;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `ChannelStream` schema.
 */
final readonly class ChannelStream implements DataModel
{
    /**
     * @param list<Provider>|null $providers
     */
    public function __construct(
        public string $id,
        public string $channel_id,
        public \DateTimeImmutable $started_at,
        public ?int $duration_seconds = null,
        public ?array $providers = null,
        public ?int $avg_viewer_count = null,
        public ?int $peak_viewer_count = null,
        public ?int $viewer_watched_minutes = null,
        public ?int $chat_message_count = null,
        public ?int $unique_chatter_count = null,
        public ?string $chat_viewer_ratio = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            id: $reader->requiredString('id'),
            channel_id: $reader->requiredString('channel_id'),
            started_at: $reader->requiredDateTime('started_at'),
            duration_seconds: $reader->optionalInt('duration_seconds'),
            providers: $reader->optionalEnumList('providers', Provider::class),
            avg_viewer_count: $reader->optionalInt('avg_viewer_count'),
            peak_viewer_count: $reader->optionalInt('peak_viewer_count'),
            viewer_watched_minutes: $reader->optionalInt('viewer_watched_minutes'),
            chat_message_count: $reader->optionalInt('chat_message_count'),
            unique_chatter_count: $reader->optionalInt('unique_chatter_count'),
            chat_viewer_ratio: $reader->optionalString('chat_viewer_ratio'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'id' => [$this->id, true],
            'channel_id' => [$this->channel_id, true],
            'started_at' => [$this->started_at, true],
            'duration_seconds' => [$this->duration_seconds, true],
            'providers' => [$this->providers, false],
            'avg_viewer_count' => [$this->avg_viewer_count, true],
            'peak_viewer_count' => [$this->peak_viewer_count, true],
            'viewer_watched_minutes' => [$this->viewer_watched_minutes, true],
            'chat_message_count' => [$this->chat_message_count, true],
            'unique_chatter_count' => [$this->unique_chatter_count, true],
            'chat_viewer_ratio' => [$this->chat_viewer_ratio, false],
        ]);
    }
}
