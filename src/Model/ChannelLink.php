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
 * The `ChannelLink` schema.
 */
final readonly class ChannelLink implements DataModel
{
    public function __construct(
        public string $id,
        public string $channel_id,
        public string $name,
        public string $slug,
        public string $destination_url,
        public string $public_url,
        public \DateTimeImmutable $created_at,
        public \DateTimeImmutable $updated_at,
        public ?\DateTimeImmutable $deleted_at = null,
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
            name: $reader->requiredString('name'),
            slug: $reader->requiredString('slug'),
            destination_url: $reader->requiredString('destination_url'),
            public_url: $reader->requiredString('public_url'),
            created_at: $reader->requiredDateTime('created_at'),
            updated_at: $reader->requiredDateTime('updated_at'),
            deleted_at: $reader->optionalDateTime('deleted_at'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'id' => [$this->id, true],
            'channel_id' => [$this->channel_id, true],
            'name' => [$this->name, true],
            'slug' => [$this->slug, true],
            'destination_url' => [$this->destination_url, true],
            'public_url' => [$this->public_url, true],
            'created_at' => [$this->created_at, true],
            'updated_at' => [$this->updated_at, true],
            'deleted_at' => [$this->deleted_at, true],
        ]);
    }
}
