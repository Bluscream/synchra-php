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

namespace Synchra\Model\Union;

use Synchra\Model\ObsRemoteNamedCommandCreate;
use Synchra\Model\ObsRemoteNoDataCommandCreate;
use Synchra\Model\ObsRemoteSetInputMuteCommandCreate;
use Synchra\Model\ObsRemoteSetInputVolumeCommandCreate;
use Synchra\Model\ObsRemoteSetSceneItemEnabledCommandCreate;
use Synchra\Serialization\Union;

/**
 * Resolves a `ObsRCommandCreateUnion` object to the variant named by its `command` field.
 */
final class ObsRCommandCreateUnion
{
    public const DISCRIMINATOR = 'command';

    /** @var list<string> */
    public const TAGS = ['refresh_state', 'start_streaming', 'stop_streaming', 'start_recording', 'stop_recording', 'pause_recording', 'unpause_recording', 'set_current_scene', 'set_current_profile', 'set_current_scene_collection', 'set_input_mute', 'set_input_volume', 'set_scene_item_enabled'];

    /**
     * @param array<string, mixed> $data
     *
     * @throws \Synchra\Exception\SerializationException When the tag is missing or unknown.
     */
    public static function fromArray(array $data): ObsRemoteNoDataCommandCreate|ObsRemoteNamedCommandCreate|ObsRemoteSetInputMuteCommandCreate|ObsRemoteSetInputVolumeCommandCreate|ObsRemoteSetSceneItemEnabledCommandCreate
    {
        $tag = Union::tag($data, self::DISCRIMINATOR, self::class);

        return match ($tag) {
            'refresh_state' => ObsRemoteNoDataCommandCreate::fromArray($data),
            'start_streaming' => ObsRemoteNoDataCommandCreate::fromArray($data),
            'stop_streaming' => ObsRemoteNoDataCommandCreate::fromArray($data),
            'start_recording' => ObsRemoteNoDataCommandCreate::fromArray($data),
            'stop_recording' => ObsRemoteNoDataCommandCreate::fromArray($data),
            'pause_recording' => ObsRemoteNoDataCommandCreate::fromArray($data),
            'unpause_recording' => ObsRemoteNoDataCommandCreate::fromArray($data),
            'set_current_scene' => ObsRemoteNamedCommandCreate::fromArray($data),
            'set_current_profile' => ObsRemoteNamedCommandCreate::fromArray($data),
            'set_current_scene_collection' => ObsRemoteNamedCommandCreate::fromArray($data),
            'set_input_mute' => ObsRemoteSetInputMuteCommandCreate::fromArray($data),
            'set_input_volume' => ObsRemoteSetInputVolumeCommandCreate::fromArray($data),
            'set_scene_item_enabled' => ObsRemoteSetSceneItemEnabledCommandCreate::fromArray($data),
            default => throw Union::unknownTag($tag, self::DISCRIMINATOR, self::TAGS, self::class),
        };
    }
}
