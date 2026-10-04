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
 * The `Body_Raid_Channel_api_2_channels__channel_id__twitch__channel_provider_id__raid_post` schema.
 * Named `Body_Raid_Channel_api_2_channels__channel_id__twitch__channel_provider_id__raid_post` in the API description.
 */
final readonly class BodyRaidChannelApi2ChannelsChannelIdTwitchChannelProviderIdRaidPost implements DataModel
{
    public function __construct(
        public string $to_provider_channel_id,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            to_provider_channel_id: $reader->requiredString('to_provider_channel_id'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'to_provider_channel_id' => [$this->to_provider_channel_id, true],
        ]);
    }
}
