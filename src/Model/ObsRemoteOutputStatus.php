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
 * The `ObsRemoteOutputStatus` schema.
 */
final readonly class ObsRemoteOutputStatus implements DataModel
{
    public function __construct(
        public ?bool $recording = null,
        public ?bool $recordingPaused = null,
        public ?bool $streaming = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            recording: $reader->optionalBool('recording'),
            recordingPaused: $reader->optionalBool('recordingPaused'),
            streaming: $reader->optionalBool('streaming'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'recording' => [$this->recording, false],
            'recordingPaused' => [$this->recordingPaused, false],
            'streaming' => [$this->streaming, false],
        ]);
    }
}
