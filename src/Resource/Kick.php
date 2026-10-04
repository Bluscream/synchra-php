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
 * The `Kick` endpoints.
 *
 * Reach this group with `$synchra->kick()`.
 */
final class Kick extends AbstractResource
{
    /**
     * Unban User.
     *
     * `DELETE /api/2/channels/{channel_id}/kick/{channel_provider_id}/ban`
     *
     * Requires the `chat:moderate` scope.
     */
    public function unbanUser(string $channelId, string $channelProviderId, string $providerViewerId): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'DELETE',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/kick/{channel_provider_id}/ban', ['channel_id' => $channelId, 'channel_provider_id' => $channelProviderId]),
            query: ['provider_viewer_id' => $providerViewerId],
        );

        $this->client->send($request);
    }

    /**
     * Ban User.
     *
     * `POST /api/2/channels/{channel_id}/kick/{channel_provider_id}/ban`
     *
     * Requires the `chat:moderate` scope.
     *
     * @param \Synchra\Model\BodyBanUserApi2ChannelsChannelIdKickChannelProviderIdBanPost $payload The request body.
     */
    public function banUser(string $channelId, string $channelProviderId, \Synchra\Model\BodyBanUserApi2ChannelsChannelIdKickChannelProviderIdBanPost $payload): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/kick/{channel_provider_id}/ban', ['channel_id' => $channelId, 'channel_provider_id' => $channelProviderId]),
            body: $payload,
        );

        $this->client->send($request);
    }
}
