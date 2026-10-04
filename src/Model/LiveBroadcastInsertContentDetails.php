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
 * The `LiveBroadcastInsertContentDetails` schema.
 */
final readonly class LiveBroadcastInsertContentDetails implements DataModel
{
    public function __construct(
        public ?MonitorStream $monitor_stream,
        public ?bool $enable_auto_start,
        public ?bool $enable_auto_stop,
        public ?bool $enable_closed_captions,
        public ?bool $enable_dvr,
        public ?bool $enable_embed,
        public ?bool $record_from_start,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            monitor_stream: $reader->optionalModel('monitor_stream', MonitorStream::class),
            enable_auto_start: $reader->optionalBool('enable_auto_start'),
            enable_auto_stop: $reader->optionalBool('enable_auto_stop'),
            enable_closed_captions: $reader->optionalBool('enable_closed_captions'),
            enable_dvr: $reader->optionalBool('enable_dvr'),
            enable_embed: $reader->optionalBool('enable_embed'),
            record_from_start: $reader->optionalBool('record_from_start'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'monitor_stream' => [$this->monitor_stream, true],
            'enable_auto_start' => [$this->enable_auto_start, true],
            'enable_auto_stop' => [$this->enable_auto_stop, true],
            'enable_closed_captions' => [$this->enable_closed_captions, true],
            'enable_dvr' => [$this->enable_dvr, true],
            'enable_embed' => [$this->enable_embed, true],
            'record_from_start' => [$this->record_from_start, true],
        ]);
    }
}
