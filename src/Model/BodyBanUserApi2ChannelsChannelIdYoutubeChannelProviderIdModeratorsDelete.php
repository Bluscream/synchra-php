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
 * The `Body_Ban_User_api_2_channels__channel_id__youtube__channel_provider_id__moderators_delete` schema.
 * Named `Body_Ban_User_api_2_channels__channel_id__youtube__channel_provider_id__moderators_delete` in the API description.
 */
final readonly class BodyBanUserApi2ChannelsChannelIdYoutubeChannelProviderIdModeratorsDelete implements DataModel
{
    public function __construct(
        public string $provider_viewer_id,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            provider_viewer_id: $reader->requiredString('provider_viewer_id'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'provider_viewer_id' => [$this->provider_viewer_id, true],
        ]);
    }
}
