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
 * The `Body_Ban_User_api_2_channels__channel_id__twitch__channel_provider_id__ban_post` schema.
 * Named `Body_Ban_User_api_2_channels__channel_id__twitch__channel_provider_id__ban_post` in the API description.
 */
final readonly class BodyBanUserApi2ChannelsChannelIdTwitchChannelProviderIdBanPost implements DataModel
{
    public function __construct(
        public string $provider_viewer_id,
        public ?int $duration_seconds = null,
        public ?string $reason = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            provider_viewer_id: $reader->requiredString('provider_viewer_id'),
            duration_seconds: $reader->optionalInt('duration_seconds'),
            reason: $reader->optionalString('reason'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'provider_viewer_id' => [$this->provider_viewer_id, true],
            'duration_seconds' => [$this->duration_seconds, true],
            'reason' => [$this->reason, true],
        ]);
    }
}
