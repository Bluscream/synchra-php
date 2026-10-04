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
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `ActivityAlertVariantPackVariant` schema.
 */
final readonly class ActivityAlertVariantPackVariant implements DataModel
{
    /**
     * @param list<string>|null $variant_pack_ids
     * @param list<string>|null $media_pack_ids
     * @param list<string>|null $sound_pack_ids
     * @param list<string>|null $tts_pack_ids
     * @param list<ActivityAlertVisualMediaAsset>|null $media
     * @param list<ActivityAlertMediaAsset>|null $sounds
     * @param list<ActivityAlertTtsAsset>|null $tts
     */
    public function __construct(
        public ?string $text_color = null,
        public ?string $viewer_color = null,
        public ?string $count_color = null,
        public ?string $count_name_color = null,
        public ?int $max_width = null,
        public ?string $font_family_id = null,
        public ?int $font_size = null,
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
        public ?ActivityAlertGroupTitleAnimationType $animation_type = null,
        public ?ActivityAlertGroupTitleAnimationType $exit_animation_type = null,
        public ?ActivityAlertGroupCelebrationType $celebration_type = null,
        public ?float $duration_seconds = null,
        public ?string $custom_script_typescript = null,
        public ?string $custom_script_javascript = null,
        public ?string $custom_css = null,
        public ?string $id = null,
        public ?string $name = null,
        public ?bool $enabled = null,
        public ?int $weight = null,
        public ?ActivityAlertFilter $filter = null,
        public ?string $theme_id = null,
        public ?array $variant_pack_ids = null,
        public ?array $media_pack_ids = null,
        public ?array $sound_pack_ids = null,
        public ?array $tts_pack_ids = null,
        public ?string $title_template = null,
        public ?string $message_template = null,
        public ?array $media = null,
        public ?array $sounds = null,
        public ?array $tts = null,
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
            max_width: $reader->optionalInt('max_width'),
            font_family_id: $reader->optionalString('font_family_id'),
            font_size: $reader->optionalInt('font_size'),
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
            animation_type: $reader->optionalEnum('animation_type', ActivityAlertGroupTitleAnimationType::class),
            exit_animation_type: $reader->optionalEnum('exit_animation_type', ActivityAlertGroupTitleAnimationType::class),
            celebration_type: $reader->optionalEnum('celebration_type', ActivityAlertGroupCelebrationType::class),
            duration_seconds: $reader->optionalFloat('duration_seconds'),
            custom_script_typescript: $reader->optionalString('custom_script_typescript'),
            custom_script_javascript: $reader->optionalString('custom_script_javascript'),
            custom_css: $reader->optionalString('custom_css'),
            id: $reader->optionalString('id'),
            name: $reader->optionalString('name'),
            enabled: $reader->optionalBool('enabled'),
            weight: $reader->optionalInt('weight'),
            filter: $reader->optionalModel('filter', ActivityAlertFilter::class),
            theme_id: $reader->optionalString('theme_id'),
            variant_pack_ids: $reader->optionalStringList('variant_pack_ids'),
            media_pack_ids: $reader->optionalStringList('media_pack_ids'),
            sound_pack_ids: $reader->optionalStringList('sound_pack_ids'),
            tts_pack_ids: $reader->optionalStringList('tts_pack_ids'),
            title_template: $reader->optionalString('title_template'),
            message_template: $reader->optionalString('message_template'),
            media: $reader->optionalModelList('media', ActivityAlertVisualMediaAsset::class),
            sounds: $reader->optionalModelList('sounds', ActivityAlertMediaAsset::class),
            tts: $reader->optionalModelList('tts', ActivityAlertTtsAsset::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'text_color' => [$this->text_color, false],
            'viewer_color' => [$this->viewer_color, false],
            'count_color' => [$this->count_color, false],
            'count_name_color' => [$this->count_name_color, false],
            'max_width' => [$this->max_width, true],
            'font_family_id' => [$this->font_family_id, true],
            'font_size' => [$this->font_size, true],
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
            'animation_type' => [$this->animation_type, true],
            'exit_animation_type' => [$this->exit_animation_type, true],
            'celebration_type' => [$this->celebration_type, true],
            'duration_seconds' => [$this->duration_seconds, true],
            'custom_script_typescript' => [$this->custom_script_typescript, false],
            'custom_script_javascript' => [$this->custom_script_javascript, false],
            'custom_css' => [$this->custom_css, false],
            'id' => [$this->id, false],
            'name' => [$this->name, false],
            'enabled' => [$this->enabled, false],
            'weight' => [$this->weight, false],
            'filter' => [$this->filter, false],
            'theme_id' => [$this->theme_id, false],
            'variant_pack_ids' => [$this->variant_pack_ids, false],
            'media_pack_ids' => [$this->media_pack_ids, false],
            'sound_pack_ids' => [$this->sound_pack_ids, false],
            'tts_pack_ids' => [$this->tts_pack_ids, false],
            'title_template' => [$this->title_template, false],
            'message_template' => [$this->message_template, false],
            'media' => [$this->media, false],
            'sounds' => [$this->sounds, false],
            'tts' => [$this->tts, false],
        ]);
    }
}
