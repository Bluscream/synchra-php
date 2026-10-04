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

use Synchra\Enum\ChatEventStatus;
use Synchra\Enum\ChatEventType;
use Synchra\Enum\Provider;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `ChatEvent` schema.
 */
final readonly class ChatEvent implements DataModel
{
    /**
     * @param list<PollChoice>|null $poll_choices
     */
    public function __construct(
        public string $id,
        public string $channel_id,
        public Provider $provider,
        public string $provider_channel_id,
        public string $provider_event_id,
        public string $name,
        public ChatEventType $type,
        public ChatEventStatus $status,
        public \DateTimeImmutable $created_at,
        public \DateTimeImmutable $updated_at,
        public ?string $subtype = null,
        public ?array $poll_choices = null,
        public ?int $progress_percent = null,
        public ?\DateTimeImmutable $expires_at = null,
        public ?bool $expired = null,
        public ?\DateTimeImmutable $locks_at = null,
        public ?string $provider_message_id = null,
        public ?ChatMessage $chat_message = null,
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
            provider: $reader->requiredEnum('provider', Provider::class),
            provider_channel_id: $reader->requiredString('provider_channel_id'),
            provider_event_id: $reader->requiredString('provider_event_id'),
            name: $reader->requiredString('name'),
            type: $reader->requiredEnum('type', ChatEventType::class),
            status: $reader->requiredEnum('status', ChatEventStatus::class),
            created_at: $reader->requiredDateTime('created_at'),
            updated_at: $reader->requiredDateTime('updated_at'),
            subtype: $reader->optionalString('subtype'),
            poll_choices: $reader->optionalModelList('poll_choices', PollChoice::class),
            progress_percent: $reader->optionalInt('progress_percent'),
            expires_at: $reader->optionalDateTime('expires_at'),
            expired: $reader->optionalBool('expired'),
            locks_at: $reader->optionalDateTime('locks_at'),
            provider_message_id: $reader->optionalString('provider_message_id'),
            chat_message: $reader->optionalModel('chat_message', ChatMessage::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'id' => [$this->id, true],
            'channel_id' => [$this->channel_id, true],
            'provider' => [$this->provider, true],
            'provider_channel_id' => [$this->provider_channel_id, true],
            'provider_event_id' => [$this->provider_event_id, true],
            'name' => [$this->name, true],
            'type' => [$this->type, true],
            'status' => [$this->status, true],
            'created_at' => [$this->created_at, true],
            'updated_at' => [$this->updated_at, true],
            'subtype' => [$this->subtype, true],
            'poll_choices' => [$this->poll_choices, true],
            'progress_percent' => [$this->progress_percent, true],
            'expires_at' => [$this->expires_at, true],
            'expired' => [$this->expired, false],
            'locks_at' => [$this->locks_at, true],
            'provider_message_id' => [$this->provider_message_id, true],
            'chat_message' => [$this->chat_message, true],
        ]);
    }
}
