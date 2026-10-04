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
 * The `StreamStatsPeriod` schema.
 */
final readonly class StreamStatsPeriod implements DataModel
{
    public function __construct(
        public string $period,
        public int $stream_count,
        public int $total_duration_seconds,
        public int $avg_viewer_count,
        public int $peak_viewer_count,
        public int $viewer_watched_minutes,
        public int $chat_message_count,
        public int $unique_chatter_count,
        public string $chat_viewer_ratio,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            period: $reader->requiredString('period'),
            stream_count: $reader->requiredInt('stream_count'),
            total_duration_seconds: $reader->requiredInt('total_duration_seconds'),
            avg_viewer_count: $reader->requiredInt('avg_viewer_count'),
            peak_viewer_count: $reader->requiredInt('peak_viewer_count'),
            viewer_watched_minutes: $reader->requiredInt('viewer_watched_minutes'),
            chat_message_count: $reader->requiredInt('chat_message_count'),
            unique_chatter_count: $reader->requiredInt('unique_chatter_count'),
            chat_viewer_ratio: $reader->requiredString('chat_viewer_ratio'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'period' => [$this->period, true],
            'stream_count' => [$this->stream_count, true],
            'total_duration_seconds' => [$this->total_duration_seconds, true],
            'avg_viewer_count' => [$this->avg_viewer_count, true],
            'peak_viewer_count' => [$this->peak_viewer_count, true],
            'viewer_watched_minutes' => [$this->viewer_watched_minutes, true],
            'chat_message_count' => [$this->chat_message_count, true],
            'unique_chatter_count' => [$this->unique_chatter_count, true],
            'chat_viewer_ratio' => [$this->chat_viewer_ratio, true],
        ]);
    }
}
