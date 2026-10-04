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

use Synchra\Enum\Layout;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `ValueWidgetTheme` schema.
 */
final readonly class ValueWidgetTheme implements DataModel
{
    public function __construct(
        public ?string $id = null,
        public ?string $name = null,
        public ?string $label_color = null,
        public ?string $value_color = null,
        public ?string $background_color = null,
        public ?string $border_color = null,
        public ?int $border_width = null,
        public ?int $border_radius = null,
        public ?int $padding = null,
        public ?int $gap = null,
        public ?Layout $layout = null,
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
            id: $reader->optionalString('id'),
            name: $reader->optionalString('name'),
            label_color: $reader->optionalString('label_color'),
            value_color: $reader->optionalString('value_color'),
            background_color: $reader->optionalString('background_color'),
            border_color: $reader->optionalString('border_color'),
            border_width: $reader->optionalInt('border_width'),
            border_radius: $reader->optionalInt('border_radius'),
            padding: $reader->optionalInt('padding'),
            gap: $reader->optionalInt('gap'),
            layout: $reader->optionalEnum('layout', Layout::class),
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
            'id' => [$this->id, false],
            'name' => [$this->name, false],
            'label_color' => [$this->label_color, false],
            'value_color' => [$this->value_color, false],
            'background_color' => [$this->background_color, false],
            'border_color' => [$this->border_color, false],
            'border_width' => [$this->border_width, false],
            'border_radius' => [$this->border_radius, false],
            'padding' => [$this->padding, false],
            'gap' => [$this->gap, false],
            'layout' => [$this->layout, false],
            'label_font_family_id' => [$this->label_font_family_id, false],
            'value_font_family_id' => [$this->value_font_family_id, false],
            'label_font_size' => [$this->label_font_size, false],
            'value_font_size' => [$this->value_font_size, false],
            'min_width' => [$this->min_width, true],
            'max_width' => [$this->max_width, true],
            'custom_css' => [$this->custom_css, false],
        ]);
    }
}
