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

use Synchra\Enum\ObsRemoteLastCommandStatus;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `ObsRemoteLastCommand` schema.
 */
final readonly class ObsRemoteLastCommand implements DataModel
{
    public function __construct(
        public ?string $id = null,
        public ?string $command = null,
        public ?ObsRemoteLastCommandStatus $status = null,
        public ?string $message = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            id: $reader->optionalString('id'),
            command: $reader->optionalString('command'),
            status: $reader->optionalEnum('status', ObsRemoteLastCommandStatus::class),
            message: $reader->optionalString('message'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'id' => [$this->id, false],
            'command' => [$this->command, false],
            'status' => [$this->status, false],
            'message' => [$this->message, false],
        ]);
    }
}
