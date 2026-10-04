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

namespace Synchra\Resource;

/**
 * The `StreamElements` endpoints.
 *
 * Reach this group with `$synchra->streamElements()`.
 */
final class StreamElements extends AbstractResource
{
    /**
     * Se Alerts Action Route.
     *
     * `PUT /api/2/channels/{channel_id}/providers/{channel_provider_id}/streamelements/alerts-action`
     *
     * Requires the `channel_providers:write` scope.
     *
     * @param \Synchra\Model\BodySeAlertsActionRouteApi2ChannelsChannelIdProvidersChannelProviderIdStreamelementsAlertsActionPut $payload The request body.
     */
    public function seAlertsAction(string $channelId, string $channelProviderId, \Synchra\Model\BodySeAlertsActionRouteApi2ChannelsChannelIdProvidersChannelProviderIdStreamelementsAlertsActionPut $payload): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'PUT',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/providers/{channel_provider_id}/streamelements/alerts-action', ['channel_id' => $channelId, 'channel_provider_id' => $channelProviderId]),
            body: $payload,
        );

        $this->client->send($request);
    }

    /**
     * Replay Streamelements Alert.
     *
     * `POST /api/2/channels/{channel_id}/providers/{channel_provider_id}/streamelements/alerts-replay/{activity_id}`
     *
     * Requires the `channel_providers:write` scope.
     */
    public function replayStreamelementsAlert(string $channelId, string $channelProviderId, string $activityId): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/providers/{channel_provider_id}/streamelements/alerts-replay/{activity_id}', ['channel_id' => $channelId, 'channel_provider_id' => $channelProviderId, 'activity_id' => $activityId]),
        );

        $this->client->send($request);
    }
}
