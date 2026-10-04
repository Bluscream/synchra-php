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

use Synchra\Enum\StreamathonWidgetSettingsStatus;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `StreamathonWidgetSettings` schema.
 */
final readonly class StreamathonWidgetSettings implements DataModel
{
    /**
     * @param list<StreamathonWidgetPausePeriod>|null $pause_periods
     * @param list<StreamathonWidgetTheme>|null $themes
     * @param list<StreamathonWidgetActivitySource>|null $activity_sources
     */
    public function __construct(
        public ?float $canvas_scale = null,
        public ?bool $enabled = null,
        public ?string $title = null,
        public ?string $currency = null,
        public ?float $seconds_per_unit = null,
        public ?StreamathonWidgetSettingsStatus $status = null,
        public ?float $start_seconds = null,
        public ?float $manual_adjust_seconds = null,
        public ?\DateTimeImmutable $started_at = null,
        public ?\DateTimeImmutable $end_at = null,
        public ?\DateTimeImmutable $activity_checkpoint_at = null,
        public ?float $activity_checkpoint_remaining_seconds = null,
        public ?\DateTimeImmutable $pause_started_at = null,
        public ?array $pause_periods = null,
        public ?bool $show_title = null,
        public ?bool $show_status = null,
        public ?bool $show_recent_events = null,
        public ?string $theme_id = null,
        public ?array $themes = null,
        public ?string $text_color = null,
        public ?string $background_color = null,
        public ?string $border_color = null,
        public ?string $time_left_color = null,
        public ?string $warning_timer_color = null,
        public ?string $ended_timer_color = null,
        public ?int $border_width = null,
        public ?int $border_radius = null,
        public ?int $padding = null,
        public ?string $font_family_id = null,
        public ?int $font_size = null,
        public ?int $min_width = null,
        public ?int $max_width = null,
        public ?string $custom_css = null,
        public ?array $activity_sources = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            canvas_scale: $reader->optionalFloat('canvas_scale'),
            enabled: $reader->optionalBool('enabled'),
            title: $reader->optionalString('title'),
            currency: $reader->optionalString('currency'),
            seconds_per_unit: $reader->optionalFloat('seconds_per_unit'),
            status: $reader->optionalEnum('status', StreamathonWidgetSettingsStatus::class),
            start_seconds: $reader->optionalFloat('start_seconds'),
            manual_adjust_seconds: $reader->optionalFloat('manual_adjust_seconds'),
            started_at: $reader->optionalDateTime('started_at'),
            end_at: $reader->optionalDateTime('end_at'),
            activity_checkpoint_at: $reader->optionalDateTime('activity_checkpoint_at'),
            activity_checkpoint_remaining_seconds: $reader->optionalFloat('activity_checkpoint_remaining_seconds'),
            pause_started_at: $reader->optionalDateTime('pause_started_at'),
            pause_periods: $reader->optionalModelList('pause_periods', StreamathonWidgetPausePeriod::class),
            show_title: $reader->optionalBool('show_title'),
            show_status: $reader->optionalBool('show_status'),
            show_recent_events: $reader->optionalBool('show_recent_events'),
            theme_id: $reader->optionalString('theme_id'),
            themes: $reader->optionalModelList('themes', StreamathonWidgetTheme::class),
            text_color: $reader->optionalString('text_color'),
            background_color: $reader->optionalString('background_color'),
            border_color: $reader->optionalString('border_color'),
            time_left_color: $reader->optionalString('time_left_color'),
            warning_timer_color: $reader->optionalString('warning_timer_color'),
            ended_timer_color: $reader->optionalString('ended_timer_color'),
            border_width: $reader->optionalInt('border_width'),
            border_radius: $reader->optionalInt('border_radius'),
            padding: $reader->optionalInt('padding'),
            font_family_id: $reader->optionalString('font_family_id'),
            font_size: $reader->optionalInt('font_size'),
            min_width: $reader->optionalInt('min_width'),
            max_width: $reader->optionalInt('max_width'),
            custom_css: $reader->optionalString('custom_css'),
            activity_sources: $reader->optionalModelList('activity_sources', StreamathonWidgetActivitySource::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'canvas_scale' => [$this->canvas_scale, false],
            'enabled' => [$this->enabled, false],
            'title' => [$this->title, false],
            'currency' => [$this->currency, true],
            'seconds_per_unit' => [$this->seconds_per_unit, false],
            'status' => [$this->status, false],
            'start_seconds' => [$this->start_seconds, false],
            'manual_adjust_seconds' => [$this->manual_adjust_seconds, false],
            'started_at' => [$this->started_at, true],
            'end_at' => [$this->end_at, true],
            'activity_checkpoint_at' => [$this->activity_checkpoint_at, true],
            'activity_checkpoint_remaining_seconds' => [$this->activity_checkpoint_remaining_seconds, true],
            'pause_started_at' => [$this->pause_started_at, true],
            'pause_periods' => [$this->pause_periods, false],
            'show_title' => [$this->show_title, false],
            'show_status' => [$this->show_status, false],
            'show_recent_events' => [$this->show_recent_events, false],
            'theme_id' => [$this->theme_id, false],
            'themes' => [$this->themes, false],
            'text_color' => [$this->text_color, false],
            'background_color' => [$this->background_color, false],
            'border_color' => [$this->border_color, false],
            'time_left_color' => [$this->time_left_color, false],
            'warning_timer_color' => [$this->warning_timer_color, false],
            'ended_timer_color' => [$this->ended_timer_color, false],
            'border_width' => [$this->border_width, true],
            'border_radius' => [$this->border_radius, true],
            'padding' => [$this->padding, true],
            'font_family_id' => [$this->font_family_id, true],
            'font_size' => [$this->font_size, true],
            'min_width' => [$this->min_width, true],
            'max_width' => [$this->max_width, true],
            'custom_css' => [$this->custom_css, false],
            'activity_sources' => [$this->activity_sources, false],
        ]);
    }
}
