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
 * The `QueueViewer` schema.
 */
final readonly class QueueViewer implements DataModel
{
    public function __construct(
        public string $id,
        public string $channel_queue_id,
        public int $position,
        public Provider $provider,
        public string $provider_viewer_id,
        public string $display_name,
        public \DateTimeImmutable $created_at,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            id: $reader->requiredString('id'),
            channel_queue_id: $reader->requiredString('channel_queue_id'),
            position: $reader->requiredInt('position'),
            provider: $reader->requiredEnum('provider', Provider::class),
            provider_viewer_id: $reader->requiredString('provider_viewer_id'),
            display_name: $reader->requiredString('display_name'),
            created_at: $reader->requiredDateTime('created_at'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'id' => [$this->id, true],
            'channel_queue_id' => [$this->channel_queue_id, true],
            'position' => [$this->position, true],
            'provider' => [$this->provider, true],
            'provider_viewer_id' => [$this->provider_viewer_id, true],
            'display_name' => [$this->display_name, true],
            'created_at' => [$this->created_at, true],
        ]);
    }
}
