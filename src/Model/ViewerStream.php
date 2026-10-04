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
 * The `ViewerStream` schema.
 */
final readonly class ViewerStream implements DataModel
{
    public function __construct(
        public ChannelProviderStream $channel_provider_stream,
        public StreamViewerWatchtime $viewer_watchtime,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            channel_provider_stream: $reader->requiredModel('channel_provider_stream', ChannelProviderStream::class),
            viewer_watchtime: $reader->requiredModel('viewer_watchtime', StreamViewerWatchtime::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'channel_provider_stream' => [$this->channel_provider_stream, true],
            'viewer_watchtime' => [$this->viewer_watchtime, true],
        ]);
    }
}
