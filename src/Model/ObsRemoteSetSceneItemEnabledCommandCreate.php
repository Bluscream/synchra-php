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
 * The `ObsRemoteSetSceneItemEnabledCommandCreate` schema.
 */
final readonly class ObsRemoteSetSceneItemEnabledCommandCreate implements DataModel
{
    public function __construct(
        public ObsRemoteSceneItemEnabledCommandData $data,
        public string $command = 'set_scene_item_enabled',
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            data: $reader->requiredModel('data', ObsRemoteSceneItemEnabledCommandData::class),
            command: $reader->requiredString('command'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'data' => [$this->data, true],
            'command' => [$this->command, true],
        ]);
    }
}
