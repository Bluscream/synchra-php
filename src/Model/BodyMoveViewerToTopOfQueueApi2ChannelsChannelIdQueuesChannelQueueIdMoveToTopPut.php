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
 * The `Body_Move_viewer_to_top_of_queue_api_2_channels__channel_id__queues__channel_queue_id__move_to_top_put` schema.
 * Named `Body_Move_viewer_to_top_of_queue_api_2_channels__channel_id__queues__channel_queue_id__move_to_top_put` in the API description.
 */
final readonly class BodyMoveViewerToTopOfQueueApi2ChannelsChannelIdQueuesChannelQueueIdMoveToTopPut implements DataModel
{
    public function __construct(
        public string $channel_queue_viewer_id,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            channel_queue_viewer_id: $reader->requiredString('channel_queue_viewer_id'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'channel_queue_viewer_id' => [$this->channel_queue_viewer_id, true],
        ]);
    }
}
