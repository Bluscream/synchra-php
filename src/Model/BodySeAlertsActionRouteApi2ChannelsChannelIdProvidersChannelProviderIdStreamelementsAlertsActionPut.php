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

use Synchra\Enum\BodySeAlertsActionRouteApi2ChannelsChannelIdProvidersChannelProviderIdStreamelementsAlertsActionPutAction;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `Body_se_alerts_action_route_api_2_channels__channel_id__providers__channel_provider_id__streamelements_alerts_action_put` schema.
 * Named `Body_se_alerts_action_route_api_2_channels__channel_id__providers__channel_provider_id__streamelements_alerts_action_put` in the API description.
 */
final readonly class BodySeAlertsActionRouteApi2ChannelsChannelIdProvidersChannelProviderIdStreamelementsAlertsActionPut implements DataModel
{
    public function __construct(
        public BodySeAlertsActionRouteApi2ChannelsChannelIdProvidersChannelProviderIdStreamelementsAlertsActionPutAction $action,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            action: $reader->requiredEnum('action', BodySeAlertsActionRouteApi2ChannelsChannelIdProvidersChannelProviderIdStreamelementsAlertsActionPutAction::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'action' => [$this->action, true],
        ]);
    }
}
