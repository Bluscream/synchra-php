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
 * The `ChannelProviderPublic` schema.
 */
final readonly class ChannelProviderPublic implements DataModel
{
    /**
     * @param array<string, mixed>|null $state
     */
    public function __construct(
        public string $id,
        public string $channel_id,
        public Provider $provider,
        public ?string $provider_channel_id,
        public ?string $provider_channel_name,
        public ?string $provider_channel_display_name,
        public ?array $state,
        public bool $scope_needed,
        public ?BotProviderPublic $bot_provider = null,
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
            provider_channel_id: $reader->optionalString('provider_channel_id'),
            provider_channel_name: $reader->optionalString('provider_channel_name'),
            provider_channel_display_name: $reader->optionalString('provider_channel_display_name'),
            state: $reader->optionalMap('state'),
            scope_needed: $reader->requiredBool('scope_needed'),
            bot_provider: $reader->optionalModel('bot_provider', BotProviderPublic::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'id' => [$this->id, true],
            'channel_id' => [$this->channel_id, true],
            'provider' => [$this->provider, true],
            'provider_channel_id' => [$this->provider_channel_id, true],
            'provider_channel_name' => [$this->provider_channel_name, true],
            'provider_channel_display_name' => [$this->provider_channel_display_name, true],
            'state' => [$this->state, true],
            'scope_needed' => [$this->scope_needed, true],
            'bot_provider' => [$this->bot_provider, true],
        ]);
    }
}
