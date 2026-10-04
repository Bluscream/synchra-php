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
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `VersusWidgetSettings` schema.
 */
final readonly class VersusWidgetSettings implements DataModel
{
    /**
     * @param array<string, mixed>|null $activity_checkpoint_option_values
     * @param list<VersusWidgetTheme>|null $themes
     * @param list<VersusWidgetOption>|null $options
     * @param list<VersusWidgetActivitySource>|null $activity_sources
     */
    public function __construct(
        public ?float $canvas_scale = null,
        public ?bool $enabled = null,
        public ?string $title = null,
        public ?DisplayMode $display_mode = null,
        public ?string $points_label = null,
        public ?string $currency = null,
        public ?ActivityPeriod $activity_period = null,
        public ?\DateTimeImmutable $start_at = null,
        public ?\DateTimeImmutable $end_at = null,
        public ?\DateTimeImmutable $activity_checkpoint_at = null,
        public ?array $activity_checkpoint_option_values = null,
        public ?bool $show_countdown = null,
        public ?string $ended_text = null,
        public ?bool $show_lead_amount = null,
        public ?bool $show_title = null,
        public ?bool $show_option_titles = null,
        public ?bool $show_values = null,
        public ?string $theme_id = null,
        public ?array $themes = null,
        public ?string $title_color = null,
        public ?string $text_color = null,
        public ?string $value_color = null,
        public ?string $secondary_text_color = null,
        public ?string $background_color = null,
        public ?string $border_color = null,
        public ?int $border_width = null,
        public ?int $border_radius = null,
        public ?int $bar_height = null,
        public ?int $image_size = null,
        public ?int $padding = null,
        public ?string $font_family_id = null,
        public ?int $font_size = null,
        public ?int $min_width = null,
        public ?int $max_width = null,
        public ?string $custom_css = null,
        public ?float $value_per_unit = null,
        public ?array $options = null,
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
            display_mode: $reader->optionalEnum('display_mode', DisplayMode::class),
            points_label: $reader->optionalString('points_label'),
            currency: $reader->optionalString('currency'),
            activity_period: $reader->optionalEnum('activity_period', ActivityPeriod::class),
            start_at: $reader->optionalDateTime('start_at'),
            end_at: $reader->optionalDateTime('end_at'),
            activity_checkpoint_at: $reader->optionalDateTime('activity_checkpoint_at'),
            activity_checkpoint_option_values: $reader->optionalMap('activity_checkpoint_option_values'),
            show_countdown: $reader->optionalBool('show_countdown'),
            ended_text: $reader->optionalString('ended_text'),
            show_lead_amount: $reader->optionalBool('show_lead_amount'),
            show_title: $reader->optionalBool('show_title'),
            show_option_titles: $reader->optionalBool('show_option_titles'),
            show_values: $reader->optionalBool('show_values'),
            theme_id: $reader->optionalString('theme_id'),
            themes: $reader->optionalModelList('themes', VersusWidgetTheme::class),
            title_color: $reader->optionalString('title_color'),
            text_color: $reader->optionalString('text_color'),
            value_color: $reader->optionalString('value_color'),
            secondary_text_color: $reader->optionalString('secondary_text_color'),
            background_color: $reader->optionalString('background_color'),
            border_color: $reader->optionalString('border_color'),
            border_width: $reader->optionalInt('border_width'),
            border_radius: $reader->optionalInt('border_radius'),
            bar_height: $reader->optionalInt('bar_height'),
            image_size: $reader->optionalInt('image_size'),
            padding: $reader->optionalInt('padding'),
            font_family_id: $reader->optionalString('font_family_id'),
            font_size: $reader->optionalInt('font_size'),
            min_width: $reader->optionalInt('min_width'),
            max_width: $reader->optionalInt('max_width'),
            custom_css: $reader->optionalString('custom_css'),
            value_per_unit: $reader->optionalFloat('value_per_unit'),
            options: $reader->optionalModelList('options', VersusWidgetOption::class),
            activity_sources: $reader->optionalModelList('activity_sources', VersusWidgetActivitySource::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'canvas_scale' => [$this->canvas_scale, false],
            'enabled' => [$this->enabled, false],
            'title' => [$this->title, false],
            'display_mode' => [$this->display_mode, false],
            'points_label' => [$this->points_label, false],
            'currency' => [$this->currency, true],
            'activity_period' => [$this->activity_period, false],
            'start_at' => [$this->start_at, false],
            'end_at' => [$this->end_at, true],
            'activity_checkpoint_at' => [$this->activity_checkpoint_at, true],
            'activity_checkpoint_option_values' => [$this->activity_checkpoint_option_values, true],
            'show_countdown' => [$this->show_countdown, false],
            'ended_text' => [$this->ended_text, false],
            'show_lead_amount' => [$this->show_lead_amount, false],
            'show_title' => [$this->show_title, false],
            'show_option_titles' => [$this->show_option_titles, false],
            'show_values' => [$this->show_values, false],
            'theme_id' => [$this->theme_id, false],
            'themes' => [$this->themes, false],
            'title_color' => [$this->title_color, false],
            'text_color' => [$this->text_color, false],
            'value_color' => [$this->value_color, false],
            'secondary_text_color' => [$this->secondary_text_color, false],
            'background_color' => [$this->background_color, false],
            'border_color' => [$this->border_color, false],
            'border_width' => [$this->border_width, true],
            'border_radius' => [$this->border_radius, true],
            'bar_height' => [$this->bar_height, true],
            'image_size' => [$this->image_size, true],
            'padding' => [$this->padding, true],
            'font_family_id' => [$this->font_family_id, true],
            'font_size' => [$this->font_size, true],
            'min_width' => [$this->min_width, true],
            'max_width' => [$this->max_width, true],
            'custom_css' => [$this->custom_css, false],
            'value_per_unit' => [$this->value_per_unit, false],
            'options' => [$this->options, false],
            'activity_sources' => [$this->activity_sources, false],
        ]);
    }
}
