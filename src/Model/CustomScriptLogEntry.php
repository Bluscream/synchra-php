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

use Synchra\Enum\Level;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `CustomScriptLogEntry` schema.
 */
final readonly class CustomScriptLogEntry implements DataModel
{
    public function __construct(
        public Level $level,
        public string $message,
        public int $time_ms,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            level: $reader->requiredEnum('level', Level::class),
            message: $reader->requiredString('message'),
            time_ms: $reader->requiredInt('time_ms'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'level' => [$this->level, true],
            'message' => [$this->message, true],
            'time_ms' => [$this->time_ms, true],
        ]);
    }
}
