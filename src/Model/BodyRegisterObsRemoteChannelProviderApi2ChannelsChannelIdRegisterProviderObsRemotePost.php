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
 * The `Body_Register_OBS_Remote_Channel_Provider_api_2_channels__channel_id__register_provider_obs_remote_post` schema.
 * Named `Body_Register_OBS_Remote_Channel_Provider_api_2_channels__channel_id__register_provider_obs_remote_post` in the API description.
 */
final readonly class BodyRegisterObsRemoteChannelProviderApi2ChannelsChannelIdRegisterProviderObsRemotePost implements DataModel
{
    public function __construct(
        public string $name,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            name: $reader->requiredString('name'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'name' => [$this->name, true],
        ]);
    }
}
