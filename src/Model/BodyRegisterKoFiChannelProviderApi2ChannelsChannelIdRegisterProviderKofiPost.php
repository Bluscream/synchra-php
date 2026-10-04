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
 * The `Body_Register_Ko_fi_Channel_Provider_api_2_channels__channel_id__register_provider_kofi_post` schema.
 * Named `Body_Register_Ko_fi_Channel_Provider_api_2_channels__channel_id__register_provider_kofi_post` in the API description.
 */
final readonly class BodyRegisterKoFiChannelProviderApi2ChannelsChannelIdRegisterProviderKofiPost implements DataModel
{
    public function __construct(
        public string $verification_token,
        public ?string $provider_channel_id = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            verification_token: $reader->requiredString('verification_token'),
            provider_channel_id: $reader->optionalString('provider_channel_id'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'verification_token' => [$this->verification_token, true],
            'provider_channel_id' => [$this->provider_channel_id, true],
        ]);
    }
}
