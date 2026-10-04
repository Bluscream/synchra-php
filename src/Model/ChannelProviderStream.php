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
use Synchra\Enum\Status;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `ChannelProviderStream` schema.
 */
final readonly class ChannelProviderStream implements DataModel
{
    /**
     * @param list<string> $tags
     */
    public function __construct(
        public string $id,
        public string $channel_id,
        public ?string $channel_provider_id,
        public ?string $channel_stream_id,
        public Provider $provider,
        public string $provider_channel_id,
        public ?string $provider_stream_id,
        public ?string $title,
        public ?string $category,
        public array $tags,
        public ?int $viewer_count,
        public ?string $variant_label,
        public ?string $provider_logo_variant,
        public Status $status,
        public ?\DateTimeImmutable $started_at,
        public ?\DateTimeImmutable $ended_at,
        public ?int $avg_viewer_count,
        public ?int $peak_viewer_count,
        public ?int $viewer_watched_minutes,
        public ?int $chat_message_count,
        public ?int $unique_chatter_count,
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
            channel_provider_id: $reader->optionalString('channel_provider_id'),
            channel_stream_id: $reader->optionalString('channel_stream_id'),
            provider: $reader->requiredEnum('provider', Provider::class),
            provider_channel_id: $reader->requiredString('provider_channel_id'),
            provider_stream_id: $reader->optionalString('provider_stream_id'),
            title: $reader->optionalString('title'),
            category: $reader->optionalString('category'),
            tags: $reader->requiredStringList('tags'),
            viewer_count: $reader->optionalInt('viewer_count'),
            variant_label: $reader->optionalString('variant_label'),
            provider_logo_variant: $reader->optionalString('provider_logo_variant'),
            status: $reader->requiredEnum('status', Status::class),
            started_at: $reader->optionalDateTime('started_at'),
            ended_at: $reader->optionalDateTime('ended_at'),
            avg_viewer_count: $reader->optionalInt('avg_viewer_count'),
            peak_viewer_count: $reader->optionalInt('peak_viewer_count'),
            viewer_watched_minutes: $reader->optionalInt('viewer_watched_minutes'),
            chat_message_count: $reader->optionalInt('chat_message_count'),
            unique_chatter_count: $reader->optionalInt('unique_chatter_count'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'id' => [$this->id, true],
            'channel_id' => [$this->channel_id, true],
            'channel_provider_id' => [$this->channel_provider_id, true],
            'channel_stream_id' => [$this->channel_stream_id, true],
            'provider' => [$this->provider, true],
            'provider_channel_id' => [$this->provider_channel_id, true],
            'provider_stream_id' => [$this->provider_stream_id, true],
            'title' => [$this->title, true],
            'category' => [$this->category, true],
            'tags' => [$this->tags, true],
            'viewer_count' => [$this->viewer_count, true],
            'variant_label' => [$this->variant_label, true],
            'provider_logo_variant' => [$this->provider_logo_variant, true],
            'status' => [$this->status, true],
            'started_at' => [$this->started_at, true],
            'ended_at' => [$this->ended_at, true],
            'avg_viewer_count' => [$this->avg_viewer_count, true],
            'peak_viewer_count' => [$this->peak_viewer_count, true],
            'viewer_watched_minutes' => [$this->viewer_watched_minutes, true],
            'chat_message_count' => [$this->chat_message_count, true],
            'unique_chatter_count' => [$this->unique_chatter_count, true],
        ]);
    }
}
