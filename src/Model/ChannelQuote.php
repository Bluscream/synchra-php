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
 * The `ChannelQuote` schema.
 */
final readonly class ChannelQuote implements DataModel
{
    public function __construct(
        public string $id,
        public string $channel_id,
        public int $number,
        public string $message,
        public Provider $provider,
        public string $created_by_provider_viewer_id,
        public string $created_by_display_name,
        public \DateTimeImmutable $created_at,
        public ?\DateTimeImmutable $updated_at = null,
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
            number: $reader->requiredInt('number'),
            message: $reader->requiredString('message'),
            provider: $reader->requiredEnum('provider', Provider::class),
            created_by_provider_viewer_id: $reader->requiredString('created_by_provider_viewer_id'),
            created_by_display_name: $reader->requiredString('created_by_display_name'),
            created_at: $reader->requiredDateTime('created_at'),
            updated_at: $reader->optionalDateTime('updated_at'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'id' => [$this->id, true],
            'channel_id' => [$this->channel_id, true],
            'number' => [$this->number, true],
            'message' => [$this->message, true],
            'provider' => [$this->provider, true],
            'created_by_provider_viewer_id' => [$this->created_by_provider_viewer_id, true],
            'created_by_display_name' => [$this->created_by_display_name, true],
            'created_at' => [$this->created_at, true],
            'updated_at' => [$this->updated_at, true],
        ]);
    }
}
