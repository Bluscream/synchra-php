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
 * The `ObsRemoteSceneItem` schema.
 */
final readonly class ObsRemoteSceneItem implements DataModel
{
    public function __construct(
        public ?string $scene_name = null,
        public ?int $scene_item_id = null,
        public ?string $source_name = null,
        public ?bool $enabled = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            scene_name: $reader->optionalString('scene_name'),
            scene_item_id: $reader->optionalInt('scene_item_id'),
            source_name: $reader->optionalString('source_name'),
            enabled: $reader->optionalBool('enabled'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'scene_name' => [$this->scene_name, false],
            'scene_item_id' => [$this->scene_item_id, false],
            'source_name' => [$this->source_name, false],
            'enabled' => [$this->enabled, false],
        ]);
    }
}
