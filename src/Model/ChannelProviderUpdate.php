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
 * The `ChannelProviderUpdate` schema.
 */
final readonly class ChannelProviderUpdate implements DataModel
{
    /**
     * @param array<string, mixed>|null $state
     */
    public function __construct(
        public ?string $provider_channel_id = null,
        public ?string $provider_channel_name = null,
        public ?string $provider_channel_display_name = null,
        public ?string $scope = null,
        public ?string $bot_provider_id = null,
        public ?array $state = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            provider_channel_id: $reader->optionalString('provider_channel_id'),
            provider_channel_name: $reader->optionalString('provider_channel_name'),
            provider_channel_display_name: $reader->optionalString('provider_channel_display_name'),
            scope: $reader->optionalString('scope'),
            bot_provider_id: $reader->optionalString('bot_provider_id'),
            state: $reader->optionalMap('state'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'provider_channel_id' => [$this->provider_channel_id, true],
            'provider_channel_name' => [$this->provider_channel_name, true],
            'provider_channel_display_name' => [$this->provider_channel_display_name, true],
            'scope' => [$this->scope, true],
            'bot_provider_id' => [$this->bot_provider_id, true],
            'state' => [$this->state, true],
        ]);
    }
}
