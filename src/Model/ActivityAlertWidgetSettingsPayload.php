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
 * The `ActivityAlertWidgetSettingsPayload` schema.
 */
final readonly class ActivityAlertWidgetSettingsPayload implements DataModel
{
    /**
     * @param list<ActivityAlertThemePayload>|null $themes
     * @param list<ActivityAlertMediaPackPayload>|null $media_packs
     * @param list<ActivityAlertSoundPackPayload>|null $sound_packs
     * @param list<ActivityAlertTtsPackPayload>|null $tts_packs
     * @param list<ActivityAlertVariantPackPayload>|null $variant_packs
     * @param list<ActivityAlertGroupPayload>|null $groups
     */
    public function __construct(
        public ?float $canvas_scale = null,
        public ?bool $enabled = null,
        public ?string $active_group_id = null,
        public ?array $themes = null,
        public ?array $media_packs = null,
        public ?array $sound_packs = null,
        public ?array $tts_packs = null,
        public ?array $variant_packs = null,
        public ?array $groups = null,
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
            active_group_id: $reader->optionalString('active_group_id'),
            themes: $reader->optionalModelList('themes', ActivityAlertThemePayload::class),
            media_packs: $reader->optionalModelList('media_packs', ActivityAlertMediaPackPayload::class),
            sound_packs: $reader->optionalModelList('sound_packs', ActivityAlertSoundPackPayload::class),
            tts_packs: $reader->optionalModelList('tts_packs', ActivityAlertTtsPackPayload::class),
            variant_packs: $reader->optionalModelList('variant_packs', ActivityAlertVariantPackPayload::class),
            groups: $reader->optionalModelList('groups', ActivityAlertGroupPayload::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'canvas_scale' => [$this->canvas_scale, false],
            'enabled' => [$this->enabled, false],
            'active_group_id' => [$this->active_group_id, false],
            'themes' => [$this->themes, false],
            'media_packs' => [$this->media_packs, false],
            'sound_packs' => [$this->sound_packs, false],
            'tts_packs' => [$this->tts_packs, false],
            'variant_packs' => [$this->variant_packs, false],
            'groups' => [$this->groups, false],
        ]);
    }
}
