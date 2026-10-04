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

use Synchra\Enum\ActivityFeedNotificationSoundTone;
use Synchra\Enum\ChatProfileSize;
use Synchra\Enum\ProviderLogoDisplay;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `ChatProfileData` schema.
 */
final readonly class ChatProfileData implements DataModel
{
    /**
     * @param list<string>|null $hide_badges
     */
    public function __construct(
        public ?bool $show_timestamp = null,
        public ?bool $show_provider_logo = null,
        public ?ProviderLogoDisplay $provider_logo_display = null,
        public ?bool $show_badges = null,
        public ?array $hide_badges = null,
        public ?bool $show_mod_icons = null,
        public ?bool $show_username = null,
        public ?bool $show_first_time_chatter = null,
        public ?bool $show_returning_chatter = null,
        public ?bool $show_source_channel = null,
        public ?bool $show_chat_input = null,
        public ?bool $show_chat_events = null,
        public ?bool $highlight_chat_mentions = null,
        public ?bool $show_message_dividers = null,
        public ?bool $striped_message_background = null,
        public ?bool $notification_sound = null,
        public ?ActivityFeedNotificationSoundTone $notification_sound_tone = null,
        public ?int $notification_sound_volume = null,
        public ?int $notification_sound_cooldown_ms = null,
        public ?string $notification_sound_url = null,
        public ?ChatProfileFilters $notification_filters = null,
        public ?ChatProfileSize $size = null,
        public ?ChatProfileFilters $filters = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            show_timestamp: $reader->optionalBool('show_timestamp'),
            show_provider_logo: $reader->optionalBool('show_provider_logo'),
            provider_logo_display: $reader->optionalEnum('provider_logo_display', ProviderLogoDisplay::class),
            show_badges: $reader->optionalBool('show_badges'),
            hide_badges: $reader->optionalStringList('hide_badges'),
            show_mod_icons: $reader->optionalBool('show_mod_icons'),
            show_username: $reader->optionalBool('show_username'),
            show_first_time_chatter: $reader->optionalBool('show_first_time_chatter'),
            show_returning_chatter: $reader->optionalBool('show_returning_chatter'),
            show_source_channel: $reader->optionalBool('show_source_channel'),
            show_chat_input: $reader->optionalBool('show_chat_input'),
            show_chat_events: $reader->optionalBool('show_chat_events'),
            highlight_chat_mentions: $reader->optionalBool('highlight_chat_mentions'),
            show_message_dividers: $reader->optionalBool('show_message_dividers'),
            striped_message_background: $reader->optionalBool('striped_message_background'),
            notification_sound: $reader->optionalBool('notification_sound'),
            notification_sound_tone: $reader->optionalEnum('notification_sound_tone', ActivityFeedNotificationSoundTone::class),
            notification_sound_volume: $reader->optionalInt('notification_sound_volume'),
            notification_sound_cooldown_ms: $reader->optionalInt('notification_sound_cooldown_ms'),
            notification_sound_url: $reader->optionalString('notification_sound_url'),
            notification_filters: $reader->optionalModel('notification_filters', ChatProfileFilters::class),
            size: $reader->optionalEnum('size', ChatProfileSize::class),
            filters: $reader->optionalModel('filters', ChatProfileFilters::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'show_timestamp' => [$this->show_timestamp, false],
            'show_provider_logo' => [$this->show_provider_logo, false],
            'provider_logo_display' => [$this->provider_logo_display, false],
            'show_badges' => [$this->show_badges, false],
            'hide_badges' => [$this->hide_badges, false],
            'show_mod_icons' => [$this->show_mod_icons, false],
            'show_username' => [$this->show_username, false],
            'show_first_time_chatter' => [$this->show_first_time_chatter, false],
            'show_returning_chatter' => [$this->show_returning_chatter, false],
            'show_source_channel' => [$this->show_source_channel, false],
            'show_chat_input' => [$this->show_chat_input, false],
            'show_chat_events' => [$this->show_chat_events, false],
            'highlight_chat_mentions' => [$this->highlight_chat_mentions, false],
            'show_message_dividers' => [$this->show_message_dividers, false],
            'striped_message_background' => [$this->striped_message_background, false],
            'notification_sound' => [$this->notification_sound, false],
            'notification_sound_tone' => [$this->notification_sound_tone, false],
            'notification_sound_volume' => [$this->notification_sound_volume, false],
            'notification_sound_cooldown_ms' => [$this->notification_sound_cooldown_ms, false],
            'notification_sound_url' => [$this->notification_sound_url, false],
            'notification_filters' => [$this->notification_filters, false],
            'size' => [$this->size, false],
            'filters' => [$this->filters, false],
        ]);
    }
}
