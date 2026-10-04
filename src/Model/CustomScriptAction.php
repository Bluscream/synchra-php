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

use Synchra\Enum\Provider;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `CustomScriptAction` schema.
 */
final readonly class CustomScriptAction implements DataModel
{
    public function __construct(
        public string $message,
        public string $type = 'chat.send',
        public ?Provider $provider = null,
        public ?string $reply_message_id = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            message: $reader->requiredString('message'),
            type: $reader->requiredString('type'),
            provider: $reader->optionalEnum('provider', Provider::class),
            reply_message_id: $reader->optionalString('reply_message_id'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'message' => [$this->message, true],
            'type' => [$this->type, true],
            'provider' => [$this->provider, false],
            'reply_message_id' => [$this->reply_message_id, false],
        ]);
    }
}
