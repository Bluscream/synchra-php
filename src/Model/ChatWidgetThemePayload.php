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

use Synchra\Enum\ProviderLogoDisplay;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `ChatWidgetThemePayload` schema.
 */
final readonly class ChatWidgetThemePayload implements DataModel
{
    public function __construct(
        public ?string $text_color = null,
        public ?string $text_shadow_color = null,
        public ?string $background_color = null,
        public ?float $background_opacity = null,
        public ?int $border_width = null,
        public ?string $border_color = null,
        public ?int $border_radius = null,
        public ?string $font_family_id = null,
        public ?string $custom_css = null,
        public ?string $id = null,
        public ?string $name = null,
        public ?ProviderLogoDisplay $provider_logo_display = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            text_color: $reader->optionalString('text_color'),
            text_shadow_color: $reader->optionalString('text_shadow_color'),
            background_color: $reader->optionalString('background_color'),
            background_opacity: $reader->optionalFloat('background_opacity'),
            border_width: $reader->optionalInt('border_width'),
            border_color: $reader->optionalString('border_color'),
            border_radius: $reader->optionalInt('border_radius'),
            font_family_id: $reader->optionalString('font_family_id'),
            custom_css: $reader->optionalString('custom_css'),
            id: $reader->optionalString('id'),
            name: $reader->optionalString('name'),
            provider_logo_display: $reader->optionalEnum('provider_logo_display', ProviderLogoDisplay::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'text_color' => [$this->text_color, false],
            'text_shadow_color' => [$this->text_shadow_color, false],
            'background_color' => [$this->background_color, false],
            'background_opacity' => [$this->background_opacity, false],
            'border_width' => [$this->border_width, false],
            'border_color' => [$this->border_color, false],
            'border_radius' => [$this->border_radius, false],
            'font_family_id' => [$this->font_family_id, false],
            'custom_css' => [$this->custom_css, false],
            'id' => [$this->id, false],
            'name' => [$this->name, false],
            'provider_logo_display' => [$this->provider_logo_display, false],
        ]);
    }
}
