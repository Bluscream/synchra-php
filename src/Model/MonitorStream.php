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
 * The `MonitorStream` schema.
 */
final readonly class MonitorStream implements DataModel
{
    public function __construct(
        public bool $enable_monitor_stream,
        public ?int $broadcast_stream_delay_ms,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            enable_monitor_stream: $reader->requiredBool('enable_monitor_stream'),
            broadcast_stream_delay_ms: $reader->optionalInt('broadcast_stream_delay_ms'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'enable_monitor_stream' => [$this->enable_monitor_stream, true],
            'broadcast_stream_delay_ms' => [$this->broadcast_stream_delay_ms, true],
        ]);
    }
}
