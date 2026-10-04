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

use Synchra\Enum\ActivityActivityGroup;
use Synchra\Enum\ActivityContributionGroup;
use Synchra\Enum\CurrencyType;
use Synchra\Enum\Provider;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `Activity` schema.
 */
final readonly class Activity implements DataModel
{
    /**
     * @param list<MentionPart>|null $gifted_viewers
     * @param list<ChatMessagePart>|null $message_parts
     */
    public function __construct(
        public string $id,
        public string $channel_id,
        public Provider $provider,
        public string $provider_message_id,
        public string $provider_channel_id,
        public string $provider_viewer_id,
        public string $viewer_name,
        public string $viewer_display_name,
        public string $type,
        public string $sub_type,
        public int $count,
        public int $count_decimal_place,
        public ?string $count_currency,
        public \DateTimeImmutable $created_at,
        public ?array $gifted_viewers,
        public string $system_message,
        public ?array $message_parts,
        public bool $read,
        public string $color,
        public ?string $font_color,
        public string $count_name,
        public string $type_display_name,
        public string $sub_type_display_name,
        public ?ActivityActivityGroup $activity_group,
        public ?ActivityContributionGroup $contribution_group,
        public ?string $viewer_profile_picture_url = null,
        public ?\DateTimeImmutable $viewer_created_at = null,
        public ?CurrencyType $count_currency_type = null,
        public ?ActivityUnitValue $unit_value = null,
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
            provider: $reader->requiredEnum('provider', Provider::class),
            provider_message_id: $reader->requiredString('provider_message_id'),
            provider_channel_id: $reader->requiredString('provider_channel_id'),
            provider_viewer_id: $reader->requiredString('provider_viewer_id'),
            viewer_name: $reader->requiredString('viewer_name'),
            viewer_display_name: $reader->requiredString('viewer_display_name'),
            type: $reader->requiredString('type'),
            sub_type: $reader->requiredString('sub_type'),
            count: $reader->requiredInt('count'),
            count_decimal_place: $reader->requiredInt('count_decimal_place'),
            count_currency: $reader->optionalString('count_currency'),
            created_at: $reader->requiredDateTime('created_at'),
            gifted_viewers: $reader->optionalModelList('gifted_viewers', MentionPart::class),
            system_message: $reader->requiredString('system_message'),
            message_parts: $reader->optionalModelList('message_parts', ChatMessagePart::class),
            read: $reader->requiredBool('read'),
            color: $reader->requiredString('color'),
            font_color: $reader->optionalString('font_color'),
            count_name: $reader->requiredString('count_name'),
            type_display_name: $reader->requiredString('type_display_name'),
            sub_type_display_name: $reader->requiredString('sub_type_display_name'),
            activity_group: $reader->optionalEnum('activity_group', ActivityActivityGroup::class),
            contribution_group: $reader->optionalEnum('contribution_group', ActivityContributionGroup::class),
            viewer_profile_picture_url: $reader->optionalString('viewer_profile_picture_url'),
            viewer_created_at: $reader->optionalDateTime('viewer_created_at'),
            count_currency_type: $reader->optionalEnum('count_currency_type', CurrencyType::class),
            unit_value: $reader->optionalModel('unit_value', ActivityUnitValue::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'id' => [$this->id, true],
            'channel_id' => [$this->channel_id, true],
            'provider' => [$this->provider, true],
            'provider_message_id' => [$this->provider_message_id, true],
            'provider_channel_id' => [$this->provider_channel_id, true],
            'provider_viewer_id' => [$this->provider_viewer_id, true],
            'viewer_name' => [$this->viewer_name, true],
            'viewer_display_name' => [$this->viewer_display_name, true],
            'type' => [$this->type, true],
            'sub_type' => [$this->sub_type, true],
            'count' => [$this->count, true],
            'count_decimal_place' => [$this->count_decimal_place, true],
            'count_currency' => [$this->count_currency, true],
            'created_at' => [$this->created_at, true],
            'gifted_viewers' => [$this->gifted_viewers, true],
            'system_message' => [$this->system_message, true],
            'message_parts' => [$this->message_parts, true],
            'read' => [$this->read, true],
            'color' => [$this->color, true],
            'font_color' => [$this->font_color, true],
            'count_name' => [$this->count_name, true],
            'type_display_name' => [$this->type_display_name, true],
            'sub_type_display_name' => [$this->sub_type_display_name, true],
            'activity_group' => [$this->activity_group, true],
            'contribution_group' => [$this->contribution_group, true],
            'viewer_profile_picture_url' => [$this->viewer_profile_picture_url, true],
            'viewer_created_at' => [$this->viewer_created_at, true],
            'count_currency_type' => [$this->count_currency_type, false],
            'unit_value' => [$this->unit_value, true],
        ]);
    }
}
