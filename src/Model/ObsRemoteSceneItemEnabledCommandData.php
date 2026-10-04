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
 * The `ObsRemoteSceneItemEnabledCommandData` schema.
 */
final readonly class ObsRemoteSceneItemEnabledCommandData implements DataModel
{
    public function __construct(
        public string $scene_name,
        public int $scene_item_id,
        public bool $enabled,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            scene_name: $reader->requiredString('scene_name'),
            scene_item_id: $reader->requiredInt('scene_item_id'),
            enabled: $reader->requiredBool('enabled'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'scene_name' => [$this->scene_name, true],
            'scene_item_id' => [$this->scene_item_id, true],
            'enabled' => [$this->enabled, true],
        ]);
    }
}
