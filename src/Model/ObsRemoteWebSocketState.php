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
 * The `ObsRemoteWebSocketState` schema.
 */
final readonly class ObsRemoteWebSocketState implements DataModel
{
    /**
     * @param list<string>|null $profiles
     * @param list<string>|null $scene_collections
     * @param list<ObsRemoteAudioInput>|null $audio_inputs
     * @param list<ObsRemoteSceneItem>|null $current_scene_items
     */
    public function __construct(
        public ?bool $enabled = null,
        public ?bool $connected = null,
        public ?string $error = null,
        public ?string $current_profile = null,
        public ?array $profiles = null,
        public ?string $current_scene_collection = null,
        public ?array $scene_collections = null,
        public ?array $audio_inputs = null,
        public ?array $current_scene_items = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            enabled: $reader->optionalBool('enabled'),
            connected: $reader->optionalBool('connected'),
            error: $reader->optionalString('error'),
            current_profile: $reader->optionalString('current_profile'),
            profiles: $reader->optionalStringList('profiles'),
            current_scene_collection: $reader->optionalString('current_scene_collection'),
            scene_collections: $reader->optionalStringList('scene_collections'),
            audio_inputs: $reader->optionalModelList('audio_inputs', ObsRemoteAudioInput::class),
            current_scene_items: $reader->optionalModelList('current_scene_items', ObsRemoteSceneItem::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'enabled' => [$this->enabled, false],
            'connected' => [$this->connected, false],
            'error' => [$this->error, true],
            'current_profile' => [$this->current_profile, true],
            'profiles' => [$this->profiles, false],
            'current_scene_collection' => [$this->current_scene_collection, true],
            'scene_collections' => [$this->scene_collections, false],
            'audio_inputs' => [$this->audio_inputs, false],
            'current_scene_items' => [$this->current_scene_items, false],
        ]);
    }
}
