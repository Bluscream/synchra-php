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

use Synchra\Enum\ActivityPeriod;
use Synchra\Enum\DisplayMode;
use Synchra\Enum\FilterCurrency;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `GoalWidgetSettingsPayload` schema.
 */
final readonly class GoalWidgetSettingsPayload implements DataModel
{
    /**
     * @param list<GoalWidgetQueueGoalPayload>|null $goals
     * @param list<GoalWidgetThemePayload>|null $themes
     * @param list<GoalWidgetActivitySourcePayload>|null $activity_sources
     */
    public function __construct(
        public ?string $title_color = null,
        public ?string $secondary_text_color = null,
        public ?string $background_color = null,
        public ?string $border_color = null,
        public ?string $progress_track_color = null,
        public ?string $progress_fill_color = null,
        public ?string $goal_amount_color = null,
        public ?string $completed_fill_color = null,
        public ?int $border_width = null,
        public ?int $border_radius = null,
        public ?int $bar_height = null,
        public ?int $padding = null,
        public ?string $font_family_id = null,
        public ?int $font_size = null,
        public ?int $min_width = null,
        public ?int $max_width = null,
        public ?string $custom_css = null,
        public ?float $canvas_scale = null,
        public ?bool $enabled = null,
        public ?string $title = null,
        public ?DisplayMode $display_mode = null,
        public ?string $points_label = null,
        public ?FilterCurrency $currency = null,
        public ?float $base_value = null,
        public ?float $goal_value = null,
        public ?ActivityPeriod $activity_period = null,
        public ?\DateTimeImmutable $start_at = null,
        public ?\DateTimeImmutable $end_at = null,
        public ?\DateTimeImmutable $activity_checkpoint_at = null,
        public ?float $activity_checkpoint_value = null,
        public ?array $goals = null,
        public ?bool $show_end_date = null,
        public ?bool $show_title = null,
        public ?bool $show_current_value = null,
        public ?bool $show_goal_value = null,
        public ?string $theme_id = null,
        public ?array $themes = null,
        public ?float $value_per_unit = null,
        public ?array $activity_sources = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            title_color: $reader->optionalString('title_color'),
            secondary_text_color: $reader->optionalString('secondary_text_color'),
            background_color: $reader->optionalString('background_color'),
            border_color: $reader->optionalString('border_color'),
            progress_track_color: $reader->optionalString('progress_track_color'),
            progress_fill_color: $reader->optionalString('progress_fill_color'),
            goal_amount_color: $reader->optionalString('goal_amount_color'),
            completed_fill_color: $reader->optionalString('completed_fill_color'),
            border_width: $reader->optionalInt('border_width'),
            border_radius: $reader->optionalInt('border_radius'),
            bar_height: $reader->optionalInt('bar_height'),
            padding: $reader->optionalInt('padding'),
            font_family_id: $reader->optionalString('font_family_id'),
            font_size: $reader->optionalInt('font_size'),
            min_width: $reader->optionalInt('min_width'),
            max_width: $reader->optionalInt('max_width'),
            custom_css: $reader->optionalString('custom_css'),
            canvas_scale: $reader->optionalFloat('canvas_scale'),
            enabled: $reader->optionalBool('enabled'),
            title: $reader->optionalString('title'),
            display_mode: $reader->optionalEnum('display_mode', DisplayMode::class),
            points_label: $reader->optionalString('points_label'),
            currency: $reader->optionalEnum('currency', FilterCurrency::class),
            base_value: $reader->optionalFloat('base_value'),
            goal_value: $reader->optionalFloat('goal_value'),
            activity_period: $reader->optionalEnum('activity_period', ActivityPeriod::class),
            start_at: $reader->optionalDateTime('start_at'),
            end_at: $reader->optionalDateTime('end_at'),
            activity_checkpoint_at: $reader->optionalDateTime('activity_checkpoint_at'),
            activity_checkpoint_value: $reader->optionalFloat('activity_checkpoint_value'),
            goals: $reader->optionalModelList('goals', GoalWidgetQueueGoalPayload::class),
            show_end_date: $reader->optionalBool('show_end_date'),
            show_title: $reader->optionalBool('show_title'),
            show_current_value: $reader->optionalBool('show_current_value'),
            show_goal_value: $reader->optionalBool('show_goal_value'),
            theme_id: $reader->optionalString('theme_id'),
            themes: $reader->optionalModelList('themes', GoalWidgetThemePayload::class),
            value_per_unit: $reader->optionalFloat('value_per_unit'),
            activity_sources: $reader->optionalModelList('activity_sources', GoalWidgetActivitySourcePayload::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'title_color' => [$this->title_color, false],
            'secondary_text_color' => [$this->secondary_text_color, false],
            'background_color' => [$this->background_color, false],
            'border_color' => [$this->border_color, false],
            'progress_track_color' => [$this->progress_track_color, false],
            'progress_fill_color' => [$this->progress_fill_color, false],
            'goal_amount_color' => [$this->goal_amount_color, false],
            'completed_fill_color' => [$this->completed_fill_color, false],
            'border_width' => [$this->border_width, true],
            'border_radius' => [$this->border_radius, true],
            'bar_height' => [$this->bar_height, true],
            'padding' => [$this->padding, true],
            'font_family_id' => [$this->font_family_id, true],
            'font_size' => [$this->font_size, true],
            'min_width' => [$this->min_width, true],
            'max_width' => [$this->max_width, true],
            'custom_css' => [$this->custom_css, false],
            'canvas_scale' => [$this->canvas_scale, false],
            'enabled' => [$this->enabled, false],
            'title' => [$this->title, false],
            'display_mode' => [$this->display_mode, false],
            'points_label' => [$this->points_label, false],
            'currency' => [$this->currency, true],
            'base_value' => [$this->base_value, false],
            'goal_value' => [$this->goal_value, false],
            'activity_period' => [$this->activity_period, false],
            'start_at' => [$this->start_at, false],
            'end_at' => [$this->end_at, true],
            'activity_checkpoint_at' => [$this->activity_checkpoint_at, true],
            'activity_checkpoint_value' => [$this->activity_checkpoint_value, true],
            'goals' => [$this->goals, false],
            'show_end_date' => [$this->show_end_date, false],
            'show_title' => [$this->show_title, false],
            'show_current_value' => [$this->show_current_value, false],
            'show_goal_value' => [$this->show_goal_value, false],
            'theme_id' => [$this->theme_id, false],
            'themes' => [$this->themes, false],
            'value_per_unit' => [$this->value_per_unit, false],
            'activity_sources' => [$this->activity_sources, false],
        ]);
    }
}
