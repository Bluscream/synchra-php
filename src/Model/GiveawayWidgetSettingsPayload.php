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

use Synchra\Enum\ActivityAlertGroupTitleAnimationType;
use Synchra\Enum\Mode;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `GiveawayWidgetSettingsPayload` schema.
 */
final readonly class GiveawayWidgetSettingsPayload implements DataModel
{
    /**
     * @param list<GiveawayWidgetThemePayload>|null $themes
     */
    public function __construct(
        public ?bool $enabled = null,
        public ?Mode $mode = null,
        public ?string $giveaway_id = null,
        public ?string $title = null,
        public ?string $image_url = null,
        public ?bool $show_trigger = null,
        public ?string $trigger_label = null,
        public ?bool $show_count = null,
        public ?bool $show_recent = null,
        public ?int $recent_count = null,
        public ?bool $show_countdown = null,
        public ?ActivityAlertGroupTitleAnimationType $entry_animation_type = null,
        public ?ActivityAlertGroupTitleAnimationType $exit_animation_type = null,
        public ?float $canvas_scale = null,
        public ?string $theme_id = null,
        public ?array $themes = null,
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
            enabled: $reader->optionalBool('enabled'),
            mode: $reader->optionalEnum('mode', Mode::class),
            giveaway_id: $reader->optionalString('giveaway_id'),
            title: $reader->optionalString('title'),
            image_url: $reader->optionalString('image_url'),
            show_trigger: $reader->optionalBool('show_trigger'),
            trigger_label: $reader->optionalString('trigger_label'),
            show_count: $reader->optionalBool('show_count'),
            show_recent: $reader->optionalBool('show_recent'),
            recent_count: $reader->optionalInt('recent_count'),
            show_countdown: $reader->optionalBool('show_countdown'),
            entry_animation_type: $reader->optionalEnum('entry_animation_type', ActivityAlertGroupTitleAnimationType::class),
            exit_animation_type: $reader->optionalEnum('exit_animation_type', ActivityAlertGroupTitleAnimationType::class),
            canvas_scale: $reader->optionalFloat('canvas_scale'),
            theme_id: $reader->optionalString('theme_id'),
            themes: $reader->optionalModelList('themes', GiveawayWidgetThemePayload::class),
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
            'enabled' => [$this->enabled, false],
            'mode' => [$this->mode, false],
            'giveaway_id' => [$this->giveaway_id, true],
            'title' => [$this->title, false],
            'image_url' => [$this->image_url, false],
            'show_trigger' => [$this->show_trigger, false],
            'trigger_label' => [$this->trigger_label, false],
            'show_count' => [$this->show_count, false],
            'show_recent' => [$this->show_recent, false],
            'recent_count' => [$this->recent_count, false],
            'show_countdown' => [$this->show_countdown, false],
            'entry_animation_type' => [$this->entry_animation_type, false],
            'exit_animation_type' => [$this->exit_animation_type, false],
            'canvas_scale' => [$this->canvas_scale, false],
            'theme_id' => [$this->theme_id, false],
            'themes' => [$this->themes, false],
            'font_family_id' => [$this->font_family_id, true],
            'font_size' => [$this->font_size, true],
            'text_color' => [$this->text_color, false],
            'muted_color' => [$this->muted_color, false],
            'accent_color' => [$this->accent_color, false],
            'background_color' => [$this->background_color, false],
            'border_color' => [$this->border_color, false],
            'border_width' => [$this->border_width, true],
            'border_radius' => [$this->border_radius, true],
            'padding' => [$this->padding, true],
            'min_width' => [$this->min_width, true],
            'max_width' => [$this->max_width, true],
            'custom_css' => [$this->custom_css, false],
        ]);
    }
}
