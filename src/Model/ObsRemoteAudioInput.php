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
 * The `ObsRemoteAudioInput` schema.
 */
final readonly class ObsRemoteAudioInput implements DataModel
{
    public function __construct(
        public ?string $input_name = null,
        public ?string $input_uuid = null,
        public ?string $input_kind = null,
        public ?bool $muted = null,
        public ?float $volume_mul = null,
        public ?float $volume_db = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            input_name: $reader->optionalString('input_name'),
            input_uuid: $reader->optionalString('input_uuid'),
            input_kind: $reader->optionalString('input_kind'),
            muted: $reader->optionalBool('muted'),
            volume_mul: $reader->optionalFloat('volume_mul'),
            volume_db: $reader->optionalFloat('volume_db'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'input_name' => [$this->input_name, false],
            'input_uuid' => [$this->input_uuid, false],
            'input_kind' => [$this->input_kind, false],
            'muted' => [$this->muted, false],
            'volume_mul' => [$this->volume_mul, false],
            'volume_db' => [$this->volume_db, false],
        ]);
    }
}
