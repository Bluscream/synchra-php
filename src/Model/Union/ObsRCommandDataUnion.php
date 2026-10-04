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

use Synchra\Model\ObsRemoteInputMuteCommandData;
use Synchra\Model\ObsRemoteInputVolumeCommandData;
use Synchra\Model\ObsRemoteNamedCommandData;
use Synchra\Model\ObsRemoteNoDataCommandData;
use Synchra\Model\ObsRemoteSceneItemEnabledCommandData;
use Synchra\Serialization\Union;

/**
 * Resolves a `ObsRCommandDataUnion` object by matching it against each variant.
 *
 * The description gives these alternatives no discriminator field, so the variant whose
 * distinguishing fields are all present wins, most specific first.
 */
final class ObsRCommandDataUnion
{
    /** @var list<string> */
    public const VARIANTS = ['ObsRemoteNoDataCommandData', 'ObsRemoteNamedCommandData', 'ObsRemoteInputMuteCommandData', 'ObsRemoteInputVolumeCommandData', 'ObsRemoteSceneItemEnabledCommandData'];

    /**
     * @param array<string, mixed> $data
     *
     * @throws \Synchra\Exception\SerializationException When no variant matches.
     */
    public static function fromArray(array $data): ObsRemoteNoDataCommandData|ObsRemoteNamedCommandData|ObsRemoteInputMuteCommandData|ObsRemoteInputVolumeCommandData|ObsRemoteSceneItemEnabledCommandData
    {
        return match (true) {
            Union::matchesShape($data, ['scene_name', 'scene_item_id', 'enabled']) => ObsRemoteSceneItemEnabledCommandData::fromArray($data),
            Union::matchesShape($data, ['input_name', 'muted']) => ObsRemoteInputMuteCommandData::fromArray($data),
            Union::matchesShape($data, ['input_name', 'volume_mul']) => ObsRemoteInputVolumeCommandData::fromArray($data),
            Union::matchesShape($data, ['name']) => ObsRemoteNamedCommandData::fromArray($data),
            Union::matchesShape($data, []) => ObsRemoteNoDataCommandData::fromArray($data),
            default => throw Union::noVariant($data, self::VARIANTS, self::class),
        };
    }
}
