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
 * The `Body_Register_TTSMonster_Channel_Provider_api_2_channels__channel_id__register_provider_ttsmonster_post` schema.
 * Named `Body_Register_TTSMonster_Channel_Provider_api_2_channels__channel_id__register_provider_ttsmonster_post` in the API description.
 */
final readonly class BodyRegisterTTSMonsterChannelProviderApi2ChannelsChannelIdRegisterProviderTtsmonsterPost implements DataModel
{
    public function __construct(
        public string $api_key,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            api_key: $reader->requiredString('api_key'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'api_key' => [$this->api_key, true],
        ]);
    }
}
