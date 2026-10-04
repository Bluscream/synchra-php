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

use Synchra\Enum\CurrencyType;
use Synchra\Enum\Provider;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `ActivityCreate` schema.
 */
final readonly class ActivityCreate implements DataModel
{
    /**
     * @param list<MentionPartRequest>|null $gifted_viewers
     * @param list<ChatMessagePartRequest>|null $message_parts
     */
    public function __construct(
        public string $channel_id,
        public string $type,
        public Provider $provider,
        public string $provider_message_id,
        public string $provider_channel_id,
        public string $provider_viewer_id,
        public string $viewer_name,
        public string $viewer_display_name,
        public ?string $id = null,
        public ?string $sub_type = null,
        public ?string $viewer_profile_picture_url = null,
        public ?string $viewer_created_at = null,
        public ?int $count = null,
        public ?int $count_decimal_place = null,
        public ?string $count_currency = null,
        public ?CurrencyType $count_currency_type = null,
        public ?\DateTimeImmutable $created_at = null,
        public ?array $gifted_viewers = null,
        public ?string $system_message = null,
        public ?array $message_parts = null,
        public ?bool $read = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            channel_id: $reader->requiredString('channel_id'),
            type: $reader->requiredString('type'),
            provider: $reader->requiredEnum('provider', Provider::class),
            provider_message_id: $reader->requiredString('provider_message_id'),
            provider_channel_id: $reader->requiredString('provider_channel_id'),
            provider_viewer_id: $reader->requiredString('provider_viewer_id'),
            viewer_name: $reader->requiredString('viewer_name'),
            viewer_display_name: $reader->requiredString('viewer_display_name'),
            id: $reader->optionalString('id'),
            sub_type: $reader->optionalString('sub_type'),
            viewer_profile_picture_url: $reader->optionalString('viewer_profile_picture_url'),
            viewer_created_at: $reader->optionalString('viewer_created_at'),
            count: $reader->optionalInt('count'),
            count_decimal_place: $reader->optionalInt('count_decimal_place'),
            count_currency: $reader->optionalString('count_currency'),
            count_currency_type: $reader->optionalEnum('count_currency_type', CurrencyType::class),
            created_at: $reader->optionalDateTime('created_at'),
            gifted_viewers: $reader->optionalModelList('gifted_viewers', MentionPartRequest::class),
            system_message: $reader->optionalString('system_message'),
            message_parts: $reader->optionalModelList('message_parts', ChatMessagePartRequest::class),
            read: $reader->optionalBool('read'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'channel_id' => [$this->channel_id, true],
            'type' => [$this->type, true],
            'provider' => [$this->provider, true],
            'provider_message_id' => [$this->provider_message_id, true],
            'provider_channel_id' => [$this->provider_channel_id, true],
            'provider_viewer_id' => [$this->provider_viewer_id, true],
            'viewer_name' => [$this->viewer_name, true],
            'viewer_display_name' => [$this->viewer_display_name, true],
            'id' => [$this->id, false],
            'sub_type' => [$this->sub_type, false],
            'viewer_profile_picture_url' => [$this->viewer_profile_picture_url, true],
            'viewer_created_at' => [$this->viewer_created_at, false],
            'count' => [$this->count, false],
            'count_decimal_place' => [$this->count_decimal_place, false],
            'count_currency' => [$this->count_currency, true],
            'count_currency_type' => [$this->count_currency_type, false],
            'created_at' => [$this->created_at, false],
            'gifted_viewers' => [$this->gifted_viewers, true],
            'system_message' => [$this->system_message, false],
            'message_parts' => [$this->message_parts, true],
            'read' => [$this->read, false],
        ]);
    }
}
