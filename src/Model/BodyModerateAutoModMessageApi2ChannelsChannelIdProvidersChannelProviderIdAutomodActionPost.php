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

use Synchra\Enum\ChatAutomodMessageAction;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `Body_Moderate_AutoMod_Message_api_2_channels__channel_id__providers__channel_provider_id__automod_action_post` schema.
 * Named `Body_Moderate_AutoMod_Message_api_2_channels__channel_id__providers__channel_provider_id__automod_action_post` in the API description.
 */
final readonly class BodyModerateAutoModMessageApi2ChannelsChannelIdProvidersChannelProviderIdAutomodActionPost implements DataModel
{
    public function __construct(
        public string $provider_message_id,
        public ChatAutomodMessageAction $action,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            provider_message_id: $reader->requiredString('provider_message_id'),
            action: $reader->requiredEnum('action', ChatAutomodMessageAction::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'provider_message_id' => [$this->provider_message_id, true],
            'action' => [$this->action, true],
        ]);
    }
}
