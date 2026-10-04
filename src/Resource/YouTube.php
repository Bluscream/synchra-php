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
 * The `YouTube` endpoints.
 *
 * Reach this group with `$synchra->youTube()`.
 */
final class YouTube extends AbstractResource
{
    /**
     * Youtube Create Broadcast Route.
     *
     * `POST /api/2/channels/{channel_id}/providers/{channel_provider_id}/youtube/broadcast`
     *
     * Requires the `channel_providers:write` scope.
     *
     * @param \Synchra\Model\LiveBroadcastInsert $payload The request body.
     */
    public function youtubeCreateBroadcast(string $channelId, string $channelProviderId, \Synchra\Model\LiveBroadcastInsert $payload): \Synchra\Model\ChannelProviderPublic
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/providers/{channel_provider_id}/youtube/broadcast', ['channel_id' => $channelId, 'channel_provider_id' => $channelProviderId]),
            body: $payload,
        );

        return \Synchra\Model\ChannelProviderPublic::fromArray($this->client->send($request)->object());
    }

    /**
     * Unban User.
     *
     * `DELETE /api/2/channels/{channel_id}/youtube/{channel_provider_id}/ban`
     *
     * Requires the `chat:moderate` scope.
     */
    public function unbanUser(string $channelId, string $channelProviderId, string $providerViewerId): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'DELETE',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/youtube/{channel_provider_id}/ban', ['channel_id' => $channelId, 'channel_provider_id' => $channelProviderId]),
            query: ['provider_viewer_id' => $providerViewerId],
        );

        $this->client->send($request);
    }

    /**
     * Ban User.
     *
     * `POST /api/2/channels/{channel_id}/youtube/{channel_provider_id}/ban`
     *
     * Requires the `chat:moderate` scope.
     *
     * @param \Synchra\Model\BodyBanUserApi2ChannelsChannelIdYoutubeChannelProviderIdBanPost $payload The request body.
     */
    public function banUser(string $channelId, string $channelProviderId, \Synchra\Model\BodyBanUserApi2ChannelsChannelIdYoutubeChannelProviderIdBanPost $payload): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/youtube/{channel_provider_id}/ban', ['channel_id' => $channelId, 'channel_provider_id' => $channelProviderId]),
            body: $payload,
        );

        $this->client->send($request);
    }

    /**
     * Ban User.
     *
     * `DELETE /api/2/channels/{channel_id}/youtube/{channel_provider_id}/moderators`
     *
     * Requires the `chat:moderate` scope.
     *
     * @param \Synchra\Model\BodyBanUserApi2ChannelsChannelIdYoutubeChannelProviderIdModeratorsDelete $payload The request body.
     */
    public function removeModerator(string $channelId, string $channelProviderId, \Synchra\Model\BodyBanUserApi2ChannelsChannelIdYoutubeChannelProviderIdModeratorsDelete $payload): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'DELETE',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/youtube/{channel_provider_id}/moderators', ['channel_id' => $channelId, 'channel_provider_id' => $channelProviderId]),
            body: $payload,
        );

        $this->client->send($request);
    }

    /**
     * Get Moderators.
     *
     * `GET /api/2/channels/{channel_id}/youtube/{channel_provider_id}/moderators`
     *
     * Requires the `chat:moderate` scope.
     *
     * @return list<\Synchra\Model\ProviderViewer>
     */
    public function getModerators(string $channelId, string $channelProviderId): array
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/youtube/{channel_provider_id}/moderators', ['channel_id' => $channelId, 'channel_provider_id' => $channelProviderId]),
        );

        return \array_map(\Synchra\Model\ProviderViewer::fromArray(...), $this->client->send($request)->objects());
    }

    /**
     * Ban User.
     *
     * `POST /api/2/channels/{channel_id}/youtube/{channel_provider_id}/moderators`
     *
     * Requires the `chat:moderate` scope.
     *
     * @param \Synchra\Model\BodyBanUserApi2ChannelsChannelIdYoutubeChannelProviderIdModeratorsPost $payload The request body.
     */
    public function addModerator(string $channelId, string $channelProviderId, \Synchra\Model\BodyBanUserApi2ChannelsChannelIdYoutubeChannelProviderIdModeratorsPost $payload): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/youtube/{channel_provider_id}/moderators', ['channel_id' => $channelId, 'channel_provider_id' => $channelProviderId]),
            body: $payload,
        );

        $this->client->send($request);
    }
}
