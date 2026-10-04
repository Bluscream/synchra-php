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
 * The `ObsRemoteInputMuteCommandData` schema.
 */
final readonly class ObsRemoteInputMuteCommandData implements DataModel
{
    public function __construct(
        public string $input_name,
        public bool $muted,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            input_name: $reader->requiredString('input_name'),
            muted: $reader->requiredBool('muted'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'input_name' => [$this->input_name, true],
            'muted' => [$this->muted, true],
        ]);
    }
}
