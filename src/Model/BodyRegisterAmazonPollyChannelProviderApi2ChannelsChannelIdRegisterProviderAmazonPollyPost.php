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
 * The `Body_Register_Amazon_Polly_Channel_Provider_api_2_channels__channel_id__register_provider_amazon_polly_post` schema.
 * Named `Body_Register_Amazon_Polly_Channel_Provider_api_2_channels__channel_id__register_provider_amazon_polly_post` in the API description.
 */
final readonly class BodyRegisterAmazonPollyChannelProviderApi2ChannelsChannelIdRegisterProviderAmazonPollyPost implements DataModel
{
    public function __construct(
        public string $access_key_id,
        public string $secret_access_key,
        public ?string $region = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            access_key_id: $reader->requiredString('access_key_id'),
            secret_access_key: $reader->requiredString('secret_access_key'),
            region: $reader->optionalString('region'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'access_key_id' => [$this->access_key_id, true],
            'secret_access_key' => [$this->secret_access_key, true],
            'region' => [$this->region, false],
        ]);
    }
}
