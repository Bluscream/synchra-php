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
 * The `User` schema.
 */
final readonly class User implements DataModel
{
    public function __construct(
        public string $id,
        public string $username,
        public ?string $email,
        public string $display_name,
        public \DateTimeImmutable $created_at,
        public bool $is_active,
        public ?\DateTimeImmutable $updated_at = null,
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
            email: $reader->optionalString('email'),
            display_name: $reader->requiredString('display_name'),
            created_at: $reader->requiredDateTime('created_at'),
            is_active: $reader->requiredBool('is_active'),
            updated_at: $reader->optionalDateTime('updated_at'),
            default_channel_id: $reader->optionalString('default_channel_id'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'id' => [$this->id, true],
            'username' => [$this->username, true],
            'email' => [$this->email, true],
            'display_name' => [$this->display_name, true],
            'created_at' => [$this->created_at, true],
            'is_active' => [$this->is_active, true],
            'updated_at' => [$this->updated_at, true],
            'default_channel_id' => [$this->default_channel_id, true],
        ]);
    }
}
