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

use Synchra\Enum\ObsRemoteNamedCommandName;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `ObsRemoteNamedCommandCreate` schema.
 */
final readonly class ObsRemoteNamedCommandCreate implements DataModel
{
    public function __construct(
        public ObsRemoteNamedCommandName $command,
        public ObsRemoteNamedCommandData $data,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            command: $reader->requiredEnum('command', ObsRemoteNamedCommandName::class),
            data: $reader->requiredModel('data', ObsRemoteNamedCommandData::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'command' => [$this->command, true],
            'data' => [$this->data, true],
        ]);
    }
}
