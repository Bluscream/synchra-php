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

use Synchra\Enum\ChatMessagePartType;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `ChatMessagePartRequest` schema.
 */
final readonly class ChatMessagePartRequest implements DataModel
{
    public function __construct(
        public ChatMessagePartType $type,
        public string $text,
        public ?GiftPartRequest $gift = null,
        public ?EmotePartRequest $emote = null,
        public ?MentionPartRequest $mention = null,
        public ?\DateTimeImmutable $date = null,
        public ?string $url = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            type: $reader->requiredEnum('type', ChatMessagePartType::class),
            text: $reader->requiredString('text'),
            gift: $reader->optionalModel('gift', GiftPartRequest::class),
            emote: $reader->optionalModel('emote', EmotePartRequest::class),
            mention: $reader->optionalModel('mention', MentionPartRequest::class),
            date: $reader->optionalDateTime('date'),
            url: $reader->optionalString('url'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'type' => [$this->type, true],
            'text' => [$this->text, true],
            'gift' => [$this->gift, true],
            'emote' => [$this->emote, true],
            'mention' => [$this->mention, true],
            'date' => [$this->date, true],
            'url' => [$this->url, true],
        ]);
    }
}
