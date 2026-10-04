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
 * The `MentionPartRequest` schema.
 */
final readonly class MentionPartRequest implements DataModel
{
    public function __construct(
        public string $user_id,
        public string $username,
        public string $display_name,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            user_id: $reader->requiredString('user_id'),
            username: $reader->requiredString('username'),
            display_name: $reader->requiredString('display_name'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'user_id' => [$this->user_id, true],
            'username' => [$this->username, true],
            'display_name' => [$this->display_name, true],
        ]);
    }
}
