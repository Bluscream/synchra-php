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
 * The `UserSendMessageCreate` schema.
 */
final readonly class UserSendMessageCreate implements DataModel
{
    public function __construct(
        public string $user_provider_id,
        public string $channel_provider_id,
        public string $message,
        public ?string $reply_provider_message_id = null,
        public ?string $outgoing_group_id = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            user_provider_id: $reader->requiredString('user_provider_id'),
            channel_provider_id: $reader->requiredString('channel_provider_id'),
            message: $reader->requiredString('message'),
            reply_provider_message_id: $reader->optionalString('reply_provider_message_id'),
            outgoing_group_id: $reader->optionalString('outgoing_group_id'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'user_provider_id' => [$this->user_provider_id, true],
            'channel_provider_id' => [$this->channel_provider_id, true],
            'message' => [$this->message, true],
            'reply_provider_message_id' => [$this->reply_provider_message_id, true],
            'outgoing_group_id' => [$this->outgoing_group_id, true],
        ]);
    }
}
