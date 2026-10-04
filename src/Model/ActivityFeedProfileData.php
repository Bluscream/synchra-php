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
use Synchra\Enum\ActivityFeedProfileSize;
use Synchra\Enum\ProviderLogoDisplay;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `ActivityFeedProfileData` schema.
 */
final readonly class ActivityFeedProfileData implements DataModel
{
    /**
     * @param list<string>|null $not_types
     * @param array<string, mixed>|null $type_min_count
     * @param list<string>|null $notification_not_types
     * @param array<string, mixed>|null $notification_type_min_count
     * @param list<string>|null $hidden_alert_control_bars
     */
    public function __construct(
        public ?array $not_types = null,
        public ?array $type_min_count = null,
        public ?bool $read_indicator = null,
        public ?bool $word_wrap = null,
        public ?bool $show_local_currency = null,
        public ?string $local_currency = null,
        public ?bool $hide_provider = null,
        public ?ProviderLogoDisplay $provider_logo_display = null,
        public ?bool $render_animated_emotes = null,
        public ?bool $notification_sound = null,
        public ?ActivityFeedNotificationSoundTone $notification_sound_tone = null,
        public ?int $notification_sound_volume = null,
        public ?int $notification_sound_cooldown_ms = null,
        public ?string $notification_sound_url = null,
        public ?array $notification_not_types = null,
        public ?array $notification_type_min_count = null,
        public ?bool $alert_controls = null,
        public ?array $hidden_alert_control_bars = null,
        public ?ActivityFeedProfileSize $size = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            not_types: $reader->optionalStringList('not_types'),
            type_min_count: $reader->optionalMap('type_min_count'),
            read_indicator: $reader->optionalBool('read_indicator'),
            word_wrap: $reader->optionalBool('word_wrap'),
            show_local_currency: $reader->optionalBool('show_local_currency'),
            local_currency: $reader->optionalString('local_currency'),
            hide_provider: $reader->optionalBool('hide_provider'),
            provider_logo_display: $reader->optionalEnum('provider_logo_display', ProviderLogoDisplay::class),
            render_animated_emotes: $reader->optionalBool('render_animated_emotes'),
            notification_sound: $reader->optionalBool('notification_sound'),
            notification_sound_tone: $reader->optionalEnum('notification_sound_tone', ActivityFeedNotificationSoundTone::class),
            notification_sound_volume: $reader->optionalInt('notification_sound_volume'),
            notification_sound_cooldown_ms: $reader->optionalInt('notification_sound_cooldown_ms'),
            notification_sound_url: $reader->optionalString('notification_sound_url'),
            notification_not_types: $reader->optionalStringList('notification_not_types'),
            notification_type_min_count: $reader->optionalMap('notification_type_min_count'),
            alert_controls: $reader->optionalBool('alert_controls'),
            hidden_alert_control_bars: $reader->optionalStringList('hidden_alert_control_bars'),
            size: $reader->optionalEnum('size', ActivityFeedProfileSize::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'not_types' => [$this->not_types, false],
            'type_min_count' => [$this->type_min_count, false],
            'read_indicator' => [$this->read_indicator, false],
            'word_wrap' => [$this->word_wrap, false],
            'show_local_currency' => [$this->show_local_currency, false],
            'local_currency' => [$this->local_currency, true],
            'hide_provider' => [$this->hide_provider, false],
            'provider_logo_display' => [$this->provider_logo_display, false],
            'render_animated_emotes' => [$this->render_animated_emotes, false],
            'notification_sound' => [$this->notification_sound, false],
            'notification_sound_tone' => [$this->notification_sound_tone, false],
            'notification_sound_volume' => [$this->notification_sound_volume, false],
            'notification_sound_cooldown_ms' => [$this->notification_sound_cooldown_ms, false],
            'notification_sound_url' => [$this->notification_sound_url, false],
            'notification_not_types' => [$this->notification_not_types, false],
            'notification_type_min_count' => [$this->notification_type_min_count, false],
            'alert_controls' => [$this->alert_controls, false],
            'hidden_alert_control_bars' => [$this->hidden_alert_control_bars, false],
            'size' => [$this->size, false],
        ]);
    }
}
