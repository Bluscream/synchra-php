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

use Synchra\Enum\ChatWidgetSize;
use Synchra\Enum\MessageAlignment;
use Synchra\Enum\MessageOrder;
use Synchra\Enum\ProviderLogoDisplay;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `ChatWidgetSettings` schema.
 */
final readonly class ChatWidgetSettings implements DataModel
{
    /**
     * @param list<string>|null $ignore_names
     * @param list<string>|null $providers
     * @param list<ChatWidgetTheme>|null $themes
     */
    public function __construct(
        public ?float $canvas_scale = null,
        public ?ChatWidgetSize $size = null,
        public ?string $text_color = null,
        public ?string $text_shadow_color = null,
        public ?string $background_color = null,
        public ?float $background_opacity = null,
        public ?int $border_width = null,
        public ?string $border_color = null,
        public ?int $border_radius = null,
        public ?string $font_family_id = null,
        public ?int $message_fade_duration_seconds = null,
        public ?int $message_delay_seconds = null,
        public ?array $ignore_names = null,
        public ?bool $provider_logo = null,
        public ?ProviderLogoDisplay $provider_logo_display = null,
        public ?bool $badges = null,
        public ?bool $username_colon = null,
        public ?bool $notices = null,
        public ?MessageOrder $message_order = null,
        public ?MessageAlignment $message_alignment = null,
        public ?array $providers = null,
        public ?string $style_type = null,
        public ?string $entrance_animation_type = null,
        public ?array $themes = null,
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
            size: $reader->optionalEnum('size', ChatWidgetSize::class),
            text_color: $reader->optionalString('text_color'),
            text_shadow_color: $reader->optionalString('text_shadow_color'),
            background_color: $reader->optionalString('background_color'),
            background_opacity: $reader->optionalFloat('background_opacity'),
            border_width: $reader->optionalInt('border_width'),
            border_color: $reader->optionalString('border_color'),
            border_radius: $reader->optionalInt('border_radius'),
            font_family_id: $reader->optionalString('font_family_id'),
            message_fade_duration_seconds: $reader->optionalInt('message_fade_duration_seconds'),
            message_delay_seconds: $reader->optionalInt('message_delay_seconds'),
            ignore_names: $reader->optionalStringList('ignore_names'),
            provider_logo: $reader->optionalBool('provider_logo'),
            provider_logo_display: $reader->optionalEnum('provider_logo_display', ProviderLogoDisplay::class),
            badges: $reader->optionalBool('badges'),
            username_colon: $reader->optionalBool('username_colon'),
            notices: $reader->optionalBool('notices'),
            message_order: $reader->optionalEnum('message_order', MessageOrder::class),
            message_alignment: $reader->optionalEnum('message_alignment', MessageAlignment::class),
            providers: $reader->optionalStringList('providers'),
            style_type: $reader->optionalString('style_type'),
            entrance_animation_type: $reader->optionalString('entrance_animation_type'),
            themes: $reader->optionalModelList('themes', ChatWidgetTheme::class),
            custom_css: $reader->optionalString('custom_css'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'canvas_scale' => [$this->canvas_scale, false],
            'size' => [$this->size, false],
            'text_color' => [$this->text_color, false],
            'text_shadow_color' => [$this->text_shadow_color, false],
            'background_color' => [$this->background_color, false],
            'background_opacity' => [$this->background_opacity, true],
            'border_width' => [$this->border_width, true],
            'border_color' => [$this->border_color, false],
            'border_radius' => [$this->border_radius, true],
            'font_family_id' => [$this->font_family_id, true],
            'message_fade_duration_seconds' => [$this->message_fade_duration_seconds, false],
            'message_delay_seconds' => [$this->message_delay_seconds, false],
            'ignore_names' => [$this->ignore_names, false],
            'provider_logo' => [$this->provider_logo, false],
            'provider_logo_display' => [$this->provider_logo_display, true],
            'badges' => [$this->badges, false],
            'username_colon' => [$this->username_colon, false],
            'notices' => [$this->notices, false],
            'message_order' => [$this->message_order, false],
            'message_alignment' => [$this->message_alignment, false],
            'providers' => [$this->providers, false],
            'style_type' => [$this->style_type, false],
            'entrance_animation_type' => [$this->entrance_animation_type, false],
            'themes' => [$this->themes, false],
            'custom_css' => [$this->custom_css, false],
        ]);
    }
}
