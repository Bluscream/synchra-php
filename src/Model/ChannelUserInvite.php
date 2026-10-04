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
 * The `ChannelUserInvite` schema.
 */
final readonly class ChannelUserInvite implements DataModel
{
    public function __construct(
        public string $id,
        public string $channel_id,
        public TAccessLevel $access_level,
        public \DateTimeImmutable $created_at,
        public \DateTimeImmutable $expires_at,
        public ?bool $is_expired = null,
        public ?string $invite_link = null,
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
            access_level: $reader->requiredEnum('access_level', TAccessLevel::class),
            created_at: $reader->requiredDateTime('created_at'),
            expires_at: $reader->requiredDateTime('expires_at'),
            is_expired: $reader->optionalBool('is_expired'),
            invite_link: $reader->optionalString('invite_link'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'id' => [$this->id, true],
            'channel_id' => [$this->channel_id, true],
            'access_level' => [$this->access_level, true],
            'created_at' => [$this->created_at, true],
            'expires_at' => [$this->expires_at, true],
            'is_expired' => [$this->is_expired, false],
            'invite_link' => [$this->invite_link, false],
        ]);
    }
}
