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
 * The `UserPublic` schema.
 */
final readonly class UserPublic implements DataModel
{
    public function __construct(
        public string $id,
        public string $username,
        public string $display_name,
        public ?string $default_channel_id = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            id: $reader->requiredString('id'),
            username: $reader->requiredString('username'),
            display_name: $reader->requiredString('display_name'),
            default_channel_id: $reader->optionalString('default_channel_id'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'id' => [$this->id, true],
            'username' => [$this->username, true],
            'display_name' => [$this->display_name, true],
            'default_channel_id' => [$this->default_channel_id, true],
        ]);
    }
}
