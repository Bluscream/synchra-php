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
 * The `CustomScriptLogRecord` schema.
 */
final readonly class CustomScriptLogRecord implements DataModel
{
    /**
     * @param list<CustomScriptLogEntry> $logs
     */
    public function __construct(
        public string $id,
        public string $channel_id,
        public string $owner_uuid,
        public string $trigger,
        public array $logs,
        public int $duration_ms,
        public \DateTimeImmutable $created_at,
        public string $owner_module = 'command',
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            id: $reader->requiredString('id'),
            channel_id: $reader->requiredString('channel_id'),
            owner_uuid: $reader->requiredString('owner_uuid'),
            trigger: $reader->requiredString('trigger'),
            logs: $reader->requiredModelList('logs', CustomScriptLogEntry::class),
            duration_ms: $reader->requiredInt('duration_ms'),
            created_at: $reader->requiredDateTime('created_at'),
            owner_module: $reader->requiredString('owner_module'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'id' => [$this->id, true],
            'channel_id' => [$this->channel_id, true],
            'owner_uuid' => [$this->owner_uuid, true],
            'trigger' => [$this->trigger, true],
            'logs' => [$this->logs, true],
            'duration_ms' => [$this->duration_ms, true],
            'created_at' => [$this->created_at, true],
            'owner_module' => [$this->owner_module, true],
        ]);
    }
}
