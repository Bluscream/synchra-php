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
 * The `ObsRemoteInputVolumeCommandData` schema.
 */
final readonly class ObsRemoteInputVolumeCommandData implements DataModel
{
    public function __construct(
        public string $input_name,
        public float $volume_mul,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            input_name: $reader->requiredString('input_name'),
            volume_mul: $reader->requiredFloat('volume_mul'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'input_name' => [$this->input_name, true],
            'volume_mul' => [$this->volume_mul, true],
        ]);
    }
}
