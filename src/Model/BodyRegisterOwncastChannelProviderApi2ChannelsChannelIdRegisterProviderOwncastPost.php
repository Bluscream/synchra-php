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
 * The `Body_Register_Owncast_Channel_Provider_api_2_channels__channel_id__register_provider_owncast_post` schema.
 * Named `Body_Register_Owncast_Channel_Provider_api_2_channels__channel_id__register_provider_owncast_post` in the API description.
 */
final readonly class BodyRegisterOwncastChannelProviderApi2ChannelsChannelIdRegisterProviderOwncastPost implements DataModel
{
    public function __construct(
        public string $host,
        public string $access_token,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            host: $reader->requiredString('host'),
            access_token: $reader->requiredString('access_token'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'host' => [$this->host, true],
            'access_token' => [$this->access_token, true],
        ]);
    }
}
