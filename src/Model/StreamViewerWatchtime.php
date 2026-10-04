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
 * The `StreamViewerWatchtime` schema.
 */
final readonly class StreamViewerWatchtime implements DataModel
{
    public function __construct(
        public string $channel_provider_stream_id,
        public string $provider_viewer_id,
        public int $watchtime,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            channel_provider_stream_id: $reader->requiredString('channel_provider_stream_id'),
            provider_viewer_id: $reader->requiredString('provider_viewer_id'),
            watchtime: $reader->requiredInt('watchtime'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'channel_provider_stream_id' => [$this->channel_provider_stream_id, true],
            'provider_viewer_id' => [$this->provider_viewer_id, true],
            'watchtime' => [$this->watchtime, true],
        ]);
    }
}
