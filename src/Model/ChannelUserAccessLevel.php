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

use Synchra\Enum\TAccessLevel;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `ChannelUserAccessLevel` schema.
 */
final readonly class ChannelUserAccessLevel implements DataModel
{
    public function __construct(
        public string $id,
        public string $user_id,
        public string $channel_id,
        public TAccessLevel $access_level,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            id: $reader->requiredString('id'),
            user_id: $reader->requiredString('user_id'),
            channel_id: $reader->requiredString('channel_id'),
            access_level: $reader->requiredEnum('access_level', TAccessLevel::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'id' => [$this->id, true],
            'user_id' => [$this->user_id, true],
            'channel_id' => [$this->channel_id, true],
            'access_level' => [$this->access_level, true],
        ]);
    }
}
