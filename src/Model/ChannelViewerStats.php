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

use Synchra\Enum\Provider;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `ChannelViewerStats` schema.
 */
final readonly class ChannelViewerStats implements DataModel
{
    public function __construct(
        public string $channel_id,
        public Provider $provider,
        public string $provider_viewer_id,
        public ?int $streams = null,
        public ?int $streams_row = null,
        public ?int $streams_row_peak = null,
        public ?string $streams_row_peak_date = null,
        public ?int $watchtime = null,
        public ?ChannelProviderStream $last_channel_provider_stream = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            channel_id: $reader->requiredString('channel_id'),
            provider: $reader->requiredEnum('provider', Provider::class),
            provider_viewer_id: $reader->requiredString('provider_viewer_id'),
            streams: $reader->optionalInt('streams'),
            streams_row: $reader->optionalInt('streams_row'),
            streams_row_peak: $reader->optionalInt('streams_row_peak'),
            streams_row_peak_date: $reader->optionalString('streams_row_peak_date'),
            watchtime: $reader->optionalInt('watchtime'),
            last_channel_provider_stream: $reader->optionalModel('last_channel_provider_stream', ChannelProviderStream::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'channel_id' => [$this->channel_id, true],
            'provider' => [$this->provider, true],
            'provider_viewer_id' => [$this->provider_viewer_id, true],
            'streams' => [$this->streams, false],
            'streams_row' => [$this->streams_row, false],
            'streams_row_peak' => [$this->streams_row_peak, false],
            'streams_row_peak_date' => [$this->streams_row_peak_date, true],
            'watchtime' => [$this->watchtime, false],
            'last_channel_provider_stream' => [$this->last_channel_provider_stream, true],
        ]);
    }
}
