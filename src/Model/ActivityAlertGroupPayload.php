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

use Synchra\Enum\ActivityAlertGroupCelebrationType;
use Synchra\Enum\ActivityAlertGroupMediaPosition;
use Synchra\Enum\ActivityAlertGroupTitleAlignment;
use Synchra\Enum\ActivityAlertGroupTitleAnimationType;
use Synchra\Enum\FilterCurrency;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `ActivityAlertGroupPayload` schema.
 */
final readonly class ActivityAlertGroupPayload implements DataModel
{
    /**
     * @param list<ActivityAlertRulePayload>|null $rules
     */
    public function __construct(
        public ?string $text_color = null,
        public ?string $viewer_color = null,
        public ?string $count_color = null,
        public ?string $count_name_color = null,
        public ?string $custom_css = null,
        public ?ActivityAlertGroupMediaPosition $media_position = null,
        public ?int $title_offset_x = null,
        public ?int $title_offset_y = null,
        public ?float $title_delay_seconds = null,
        public ?ActivityAlertGroupTitleAnimationType $title_animation_type = null,
        public ?int $message_offset_x = null,
        public ?int $message_offset_y = null,
        public ?float $message_delay_seconds = null,
        public ?ActivityAlertGroupTitleAnimationType $message_animation_type = null,
        public ?ActivityAlertGroupTitleAlignment $title_alignment = null,
        public ?ActivityAlertGroupTitleAlignment $message_alignment = null,
        public ?int $max_width = null,
        public ?string $font_family_id = null,
        public ?int $font_size = null,
        public ?ActivityAlertGroupTitleAnimationType $animation_type = null,
        public ?ActivityAlertGroupTitleAnimationType $exit_animation_type = null,
        public ?ActivityAlertGroupCelebrationType $celebration_type = null,
        public ?float $duration_seconds = null,
        public ?string $custom_script_typescript = null,
        public ?string $custom_script_javascript = null,
        public ?string $id = null,
        public ?string $name = null,
        public ?bool $enabled = null,
        public ?float $volume = null,
        public ?string $theme_id = null,
        public ?float $queue_delay_seconds = null,
        public ?FilterCurrency $filter_currency = null,
        public ?array $rules = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            text_color: $reader->optionalString('text_color'),
            viewer_color: $reader->optionalString('viewer_color'),
            count_color: $reader->optionalString('count_color'),
            count_name_color: $reader->optionalString('count_name_color'),
            custom_css: $reader->optionalString('custom_css'),
            media_position: $reader->optionalEnum('media_position', ActivityAlertGroupMediaPosition::class),
            title_offset_x: $reader->optionalInt('title_offset_x'),
            title_offset_y: $reader->optionalInt('title_offset_y'),
            title_delay_seconds: $reader->optionalFloat('title_delay_seconds'),
            title_animation_type: $reader->optionalEnum('title_animation_type', ActivityAlertGroupTitleAnimationType::class),
            message_offset_x: $reader->optionalInt('message_offset_x'),
            message_offset_y: $reader->optionalInt('message_offset_y'),
            message_delay_seconds: $reader->optionalFloat('message_delay_seconds'),
            message_animation_type: $reader->optionalEnum('message_animation_type', ActivityAlertGroupTitleAnimationType::class),
            title_alignment: $reader->optionalEnum('title_alignment', ActivityAlertGroupTitleAlignment::class),
            message_alignment: $reader->optionalEnum('message_alignment', ActivityAlertGroupTitleAlignment::class),
            max_width: $reader->optionalInt('max_width'),
            font_family_id: $reader->optionalString('font_family_id'),
            font_size: $reader->optionalInt('font_size'),
            animation_type: $reader->optionalEnum('animation_type', ActivityAlertGroupTitleAnimationType::class),
            exit_animation_type: $reader->optionalEnum('exit_animation_type', ActivityAlertGroupTitleAnimationType::class),
            celebration_type: $reader->optionalEnum('celebration_type', ActivityAlertGroupCelebrationType::class),
            duration_seconds: $reader->optionalFloat('duration_seconds'),
            custom_script_typescript: $reader->optionalString('custom_script_typescript'),
            custom_script_javascript: $reader->optionalString('custom_script_javascript'),
            id: $reader->optionalString('id'),
            name: $reader->optionalString('name'),
            enabled: $reader->optionalBool('enabled'),
            volume: $reader->optionalFloat('volume'),
            theme_id: $reader->optionalString('theme_id'),
            queue_delay_seconds: $reader->optionalFloat('queue_delay_seconds'),
            filter_currency: $reader->optionalEnum('filter_currency', FilterCurrency::class),
            rules: $reader->optionalModelList('rules', ActivityAlertRulePayload::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'text_color' => [$this->text_color, false],
            'viewer_color' => [$this->viewer_color, false],
            'count_color' => [$this->count_color, false],
            'count_name_color' => [$this->count_name_color, false],
            'custom_css' => [$this->custom_css, false],
            'media_position' => [$this->media_position, true],
            'title_offset_x' => [$this->title_offset_x, true],
            'title_offset_y' => [$this->title_offset_y, true],
            'title_delay_seconds' => [$this->title_delay_seconds, true],
            'title_animation_type' => [$this->title_animation_type, true],
            'message_offset_x' => [$this->message_offset_x, true],
            'message_offset_y' => [$this->message_offset_y, true],
            'message_delay_seconds' => [$this->message_delay_seconds, true],
            'message_animation_type' => [$this->message_animation_type, true],
            'title_alignment' => [$this->title_alignment, true],
            'message_alignment' => [$this->message_alignment, true],
            'max_width' => [$this->max_width, true],
            'font_family_id' => [$this->font_family_id, true],
            'font_size' => [$this->font_size, true],
            'animation_type' => [$this->animation_type, true],
            'exit_animation_type' => [$this->exit_animation_type, true],
            'celebration_type' => [$this->celebration_type, true],
            'duration_seconds' => [$this->duration_seconds, true],
            'custom_script_typescript' => [$this->custom_script_typescript, false],
            'custom_script_javascript' => [$this->custom_script_javascript, false],
            'id' => [$this->id, false],
            'name' => [$this->name, false],
            'enabled' => [$this->enabled, false],
            'volume' => [$this->volume, false],
            'theme_id' => [$this->theme_id, false],
            'queue_delay_seconds' => [$this->queue_delay_seconds, false],
            'filter_currency' => [$this->filter_currency, false],
            'rules' => [$this->rules, false],
        ]);
    }
}
