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

use Synchra\Model\Union\ObsRCommandDataUnion;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `ObsRemoteCommand` schema.
 */
final readonly class ObsRemoteCommand implements DataModel
{
    public function __construct(
        public string $id,
        public string $obs_remote_id,
        public string $command,
        public ObsRemoteNoDataCommandData|ObsRemoteNamedCommandData|ObsRemoteInputMuteCommandData|ObsRemoteInputVolumeCommandData|ObsRemoteSceneItemEnabledCommandData $data,
        public \DateTimeImmutable $created_at,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            id: $reader->requiredString('id'),
            obs_remote_id: $reader->requiredString('obs_remote_id'),
            command: $reader->requiredString('command'),
            data: $reader->requiredVia('data', ObsRCommandDataUnion::fromArray(...)),
            created_at: $reader->requiredDateTime('created_at'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'id' => [$this->id, true],
            'obs_remote_id' => [$this->obs_remote_id, true],
            'command' => [$this->command, true],
            'data' => [$this->data, true],
            'created_at' => [$this->created_at, true],
        ]);
    }
}
