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
 * The `ViewerCountWidgetSettings` schema.
 */
final readonly class ViewerCountWidgetSettings implements DataModel
{
    /**
     * @param list<string>|null $providers
     * @param list<ViewerCountWidgetTheme>|null $themes
     */
    public function __construct(
        public ?float $canvas_scale = null,
        public ?bool $enabled = null,
        public ?array $providers = null,
        public ?string $theme_id = null,
        public ?array $themes = null,
        public ?string $text_color = null,
        public ?string $background_color = null,
        public ?string $border_color = null,
        public ?int $border_width = null,
        public ?int $border_radius = null,
        public ?int $padding = null,
        public ?string $font_family_id = null,
        public ?int $font_size = null,
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
            providers: $reader->optionalStringList('providers'),
            theme_id: $reader->optionalString('theme_id'),
            themes: $reader->optionalModelList('themes', ViewerCountWidgetTheme::class),
            text_color: $reader->optionalString('text_color'),
            background_color: $reader->optionalString('background_color'),
            border_color: $reader->optionalString('border_color'),
            border_width: $reader->optionalInt('border_width'),
            border_radius: $reader->optionalInt('border_radius'),
            padding: $reader->optionalInt('padding'),
            font_family_id: $reader->optionalString('font_family_id'),
            font_size: $reader->optionalInt('font_size'),
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
            'providers' => [$this->providers, false],
            'theme_id' => [$this->theme_id, false],
            'themes' => [$this->themes, false],
            'text_color' => [$this->text_color, false],
            'background_color' => [$this->background_color, false],
            'border_color' => [$this->border_color, false],
            'border_width' => [$this->border_width, true],
            'border_radius' => [$this->border_radius, true],
            'padding' => [$this->padding, true],
            'font_family_id' => [$this->font_family_id, true],
            'font_size' => [$this->font_size, true],
            'min_width' => [$this->min_width, true],
            'max_width' => [$this->max_width, true],
            'custom_css' => [$this->custom_css, false],
        ]);
    }
}
