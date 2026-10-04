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
 * The `Body_Register_Rumble_Channel_Provider_api_2_channels__channel_id__register_provider_rumble_post` schema.
 * Named `Body_Register_Rumble_Channel_Provider_api_2_channels__channel_id__register_provider_rumble_post` in the API description.
 */
final readonly class BodyRegisterRumbleChannelProviderApi2ChannelsChannelIdRegisterProviderRumblePost implements DataModel
{
    public function __construct(
        public string $api_url,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            api_url: $reader->requiredString('api_url'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'api_url' => [$this->api_url, true],
        ]);
    }
}
