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
 * The `GoalWidgetThemePayload` schema.
 */
final readonly class GoalWidgetThemePayload implements DataModel
{
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
        public ?string $id = null,
        public ?string $name = null,
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
            id: $reader->optionalString('id'),
            name: $reader->optionalString('name'),
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
            'border_width' => [$this->border_width, false],
            'border_radius' => [$this->border_radius, false],
            'bar_height' => [$this->bar_height, false],
            'padding' => [$this->padding, false],
            'font_family_id' => [$this->font_family_id, false],
            'font_size' => [$this->font_size, false],
            'min_width' => [$this->min_width, true],
            'max_width' => [$this->max_width, true],
            'custom_css' => [$this->custom_css, false],
            'id' => [$this->id, false],
            'name' => [$this->name, false],
        ]);
    }
}
