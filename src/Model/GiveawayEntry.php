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
 * The `GiveawayEntry` schema.
 */
final readonly class GiveawayEntry implements DataModel
{
    public function __construct(
        public string $id,
        public \DateTimeImmutable $created_at,
        public string $channel_giveaway_id,
        public Provider $provider,
        public string $provider_viewer_id,
        public string $name,
        public string $display_name,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            id: $reader->requiredString('id'),
            created_at: $reader->requiredDateTime('created_at'),
            channel_giveaway_id: $reader->requiredString('channel_giveaway_id'),
            provider: $reader->requiredEnum('provider', Provider::class),
            provider_viewer_id: $reader->requiredString('provider_viewer_id'),
            name: $reader->requiredString('name'),
            display_name: $reader->requiredString('display_name'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'id' => [$this->id, true],
            'created_at' => [$this->created_at, true],
            'channel_giveaway_id' => [$this->channel_giveaway_id, true],
            'provider' => [$this->provider, true],
            'provider_viewer_id' => [$this->provider_viewer_id, true],
            'name' => [$this->name, true],
            'display_name' => [$this->display_name, true],
        ]);
    }
}
