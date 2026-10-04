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

use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `ValueWidgetSettings` schema.
 */
final readonly class ValueWidgetSettings implements DataModel
{
    /**
     * @param list<ValueWidgetTheme>|null $themes
     */
    public function __construct(
        public ?float $canvas_scale = null,
        public ?bool $enabled = null,
        public ?string $image_url = null,
        public ?string $key = null,
        public ?string $label = null,
        public ?bool $show_label = null,
        public ?string $fallback_value = null,
        public ?bool $format_numbers = null,
        public ?string $theme_id = null,
        public ?array $themes = null,
        public ?string $label_color = null,
        public ?string $value_color = null,
        public ?string $background_color = null,
        public ?string $border_color = null,
        public ?int $border_width = null,
        public ?int $border_radius = null,
        public ?int $padding = null,
        public ?int $gap = null,
        public ?string $label_font_family_id = null,
        public ?string $value_font_family_id = null,
        public ?int $label_font_size = null,
        public ?int $value_font_size = null,
        public ?int $min_width = null,
        public ?int $max_width = null,
        public ?string $custom_css = null,
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
            image_url: $reader->optionalString('image_url'),
            key: $reader->optionalString('key'),
            label: $reader->optionalString('label'),
            show_label: $reader->optionalBool('show_label'),
            fallback_value: $reader->optionalString('fallback_value'),
            format_numbers: $reader->optionalBool('format_numbers'),
            theme_id: $reader->optionalString('theme_id'),
            themes: $reader->optionalModelList('themes', ValueWidgetTheme::class),
            label_color: $reader->optionalString('label_color'),
            value_color: $reader->optionalString('value_color'),
            background_color: $reader->optionalString('background_color'),
            border_color: $reader->optionalString('border_color'),
            border_width: $reader->optionalInt('border_width'),
            border_radius: $reader->optionalInt('border_radius'),
            padding: $reader->optionalInt('padding'),
            gap: $reader->optionalInt('gap'),
            label_font_family_id: $reader->optionalString('label_font_family_id'),
            value_font_family_id: $reader->optionalString('value_font_family_id'),
            label_font_size: $reader->optionalInt('label_font_size'),
            value_font_size: $reader->optionalInt('value_font_size'),
            min_width: $reader->optionalInt('min_width'),
            max_width: $reader->optionalInt('max_width'),
            custom_css: $reader->optionalString('custom_css'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'canvas_scale' => [$this->canvas_scale, false],
            'enabled' => [$this->enabled, false],
            'image_url' => [$this->image_url, false],
            'key' => [$this->key, false],
            'label' => [$this->label, false],
            'show_label' => [$this->show_label, false],
            'fallback_value' => [$this->fallback_value, false],
            'format_numbers' => [$this->format_numbers, false],
            'theme_id' => [$this->theme_id, false],
            'themes' => [$this->themes, false],
            'label_color' => [$this->label_color, false],
            'value_color' => [$this->value_color, false],
            'background_color' => [$this->background_color, false],
            'border_color' => [$this->border_color, false],
            'border_width' => [$this->border_width, true],
            'border_radius' => [$this->border_radius, true],
            'padding' => [$this->padding, true],
            'gap' => [$this->gap, true],
            'label_font_family_id' => [$this->label_font_family_id, true],
            'value_font_family_id' => [$this->value_font_family_id, true],
            'label_font_size' => [$this->label_font_size, true],
            'value_font_size' => [$this->value_font_size, true],
            'min_width' => [$this->min_width, true],
            'max_width' => [$this->max_width, true],
            'custom_css' => [$this->custom_css, false],
        ]);
    }
}
