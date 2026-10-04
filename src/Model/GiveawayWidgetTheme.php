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
 * The `GiveawayWidgetTheme` schema.
 */
final readonly class GiveawayWidgetTheme implements DataModel
{
    public function __construct(
        public ?string $id = null,
        public ?string $name = null,
        public ?string $font_family_id = null,
        public ?int $font_size = null,
        public ?string $text_color = null,
        public ?string $muted_color = null,
        public ?string $accent_color = null,
        public ?string $background_color = null,
        public ?string $border_color = null,
        public ?int $border_width = null,
        public ?int $border_radius = null,
        public ?int $padding = null,
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
            font_family_id: $reader->optionalString('font_family_id'),
            font_size: $reader->optionalInt('font_size'),
            text_color: $reader->optionalString('text_color'),
            muted_color: $reader->optionalString('muted_color'),
            accent_color: $reader->optionalString('accent_color'),
            background_color: $reader->optionalString('background_color'),
            border_color: $reader->optionalString('border_color'),
            border_width: $reader->optionalInt('border_width'),
            border_radius: $reader->optionalInt('border_radius'),
            padding: $reader->optionalInt('padding'),
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
            'font_family_id' => [$this->font_family_id, false],
            'font_size' => [$this->font_size, false],
            'text_color' => [$this->text_color, false],
            'muted_color' => [$this->muted_color, false],
            'accent_color' => [$this->accent_color, false],
            'background_color' => [$this->background_color, false],
            'border_color' => [$this->border_color, false],
            'border_width' => [$this->border_width, false],
            'border_radius' => [$this->border_radius, false],
            'padding' => [$this->padding, false],
            'min_width' => [$this->min_width, true],
            'max_width' => [$this->max_width, true],
            'custom_css' => [$this->custom_css, false],
        ]);
    }
}
