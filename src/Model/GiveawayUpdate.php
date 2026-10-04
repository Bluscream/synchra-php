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
 * The `GiveawayUpdate` schema.
 */
final readonly class GiveawayUpdate implements DataModel
{
    public function __construct(
        public ?string $title = null,
        public ?string $chat_command_id = null,
        public ?bool $active = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            title: $reader->optionalString('title'),
            chat_command_id: $reader->optionalString('chat_command_id'),
            active: $reader->optionalBool('active'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'title' => [$this->title, false],
            'chat_command_id' => [$this->chat_command_id, false],
            'active' => [$this->active, false],
        ]);
    }
}
