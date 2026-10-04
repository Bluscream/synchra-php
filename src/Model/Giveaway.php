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
 * The `Giveaway` schema.
 */
final readonly class Giveaway implements DataModel
{
    public function __construct(
        public string $id,
        public \DateTimeImmutable $created_at,
        public \DateTimeImmutable $updated_at,
        public string $channel_id,
        public string $title,
        public ?string $chat_command_id,
        public bool $active,
        public ?string $winner_provider,
        public ?string $winner_provider_viewer_id,
        public ?string $winner_name,
        public ?string $winner_display_name,
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
            updated_at: $reader->requiredDateTime('updated_at'),
            channel_id: $reader->requiredString('channel_id'),
            title: $reader->requiredString('title'),
            chat_command_id: $reader->optionalString('chat_command_id'),
            active: $reader->requiredBool('active'),
            winner_provider: $reader->optionalString('winner_provider'),
            winner_provider_viewer_id: $reader->optionalString('winner_provider_viewer_id'),
            winner_name: $reader->optionalString('winner_name'),
            winner_display_name: $reader->optionalString('winner_display_name'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'id' => [$this->id, true],
            'created_at' => [$this->created_at, true],
            'updated_at' => [$this->updated_at, true],
            'channel_id' => [$this->channel_id, true],
            'title' => [$this->title, true],
            'chat_command_id' => [$this->chat_command_id, true],
            'active' => [$this->active, true],
            'winner_provider' => [$this->winner_provider, true],
            'winner_provider_viewer_id' => [$this->winner_provider_viewer_id, true],
            'winner_name' => [$this->winner_name, true],
            'winner_display_name' => [$this->winner_display_name, true],
        ]);
    }
}
