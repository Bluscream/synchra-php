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
 * The `Body_Register_Patreon_Channel_Provider_api_2_channels__channel_id__register_provider_patreon_post` schema.
 * Named `Body_Register_Patreon_Channel_Provider_api_2_channels__channel_id__register_provider_patreon_post` in the API description.
 */
final readonly class BodyRegisterPatreonChannelProviderApi2ChannelsChannelIdRegisterProviderPatreonPost implements DataModel
{
    public function __construct(
        public string $webhook_secret,
        public ?string $provider_channel_id = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            webhook_secret: $reader->requiredString('webhook_secret'),
            provider_channel_id: $reader->optionalString('provider_channel_id'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'webhook_secret' => [$this->webhook_secret, true],
            'provider_channel_id' => [$this->provider_channel_id, true],
        ]);
    }
}
