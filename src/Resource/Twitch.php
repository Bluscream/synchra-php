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
 * The `Twitch` endpoints.
 *
 * Reach this group with `$synchra->twitch()`.
 */
final class Twitch extends AbstractResource
{
    /**
     * Unban User.
     *
     * `DELETE /api/2/channels/{channel_id}/twitch/{channel_provider_id}/ban`
     *
     * Requires the `chat:moderate` scope.
     */
    public function unbanUser(string $channelId, string $channelProviderId, string $providerViewerId): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'DELETE',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/twitch/{channel_provider_id}/ban', ['channel_id' => $channelId, 'channel_provider_id' => $channelProviderId]),
            query: ['provider_viewer_id' => $providerViewerId],
        );

        $this->client->send($request);
    }

    /**
     * Ban User.
     *
     * `POST /api/2/channels/{channel_id}/twitch/{channel_provider_id}/ban`
     *
     * Requires the `chat:moderate` scope.
     *
     * @param \Synchra\Model\BodyBanUserApi2ChannelsChannelIdTwitchChannelProviderIdBanPost $payload The request body.
     */
    public function banUser(string $channelId, string $channelProviderId, \Synchra\Model\BodyBanUserApi2ChannelsChannelIdTwitchChannelProviderIdBanPost $payload): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/twitch/{channel_provider_id}/ban', ['channel_id' => $channelId, 'channel_provider_id' => $channelProviderId]),
            body: $payload,
        );

        $this->client->send($request);
    }

    /**
     * Ban User.
     *
     * `DELETE /api/2/channels/{channel_id}/twitch/{channel_provider_id}/moderators`
     *
     * Requires the `chat:moderate` scope.
     *
     * @param \Synchra\Model\BodyBanUserApi2ChannelsChannelIdTwitchChannelProviderIdModeratorsDelete $payload The request body.
     */
    public function removeModerator(string $channelId, string $channelProviderId, \Synchra\Model\BodyBanUserApi2ChannelsChannelIdTwitchChannelProviderIdModeratorsDelete $payload): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'DELETE',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/twitch/{channel_provider_id}/moderators', ['channel_id' => $channelId, 'channel_provider_id' => $channelProviderId]),
            body: $payload,
        );

        $this->client->send($request);
    }

    /**
     * Get Moderators.
     *
     * `GET /api/2/channels/{channel_id}/twitch/{channel_provider_id}/moderators`
     *
     * Requires the `chat:moderate` scope.
     *
     * @return list<\Synchra\Model\ProviderViewer>
     */
    public function getModerators(string $channelId, string $channelProviderId): array
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/twitch/{channel_provider_id}/moderators', ['channel_id' => $channelId, 'channel_provider_id' => $channelProviderId]),
        );

        return \array_map(\Synchra\Model\ProviderViewer::fromArray(...), $this->client->send($request)->objects());
    }

    /**
     * Ban User.
     *
     * `POST /api/2/channels/{channel_id}/twitch/{channel_provider_id}/moderators`
     *
     * Requires the `chat:moderate` scope.
     *
     * @param \Synchra\Model\BodyBanUserApi2ChannelsChannelIdTwitchChannelProviderIdModeratorsPost $payload The request body.
     */
    public function addModerator(string $channelId, string $channelProviderId, \Synchra\Model\BodyBanUserApi2ChannelsChannelIdTwitchChannelProviderIdModeratorsPost $payload): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/twitch/{channel_provider_id}/moderators', ['channel_id' => $channelId, 'channel_provider_id' => $channelProviderId]),
            body: $payload,
        );

        $this->client->send($request);
    }

    /**
     * Delete Raid.
     *
     * `DELETE /api/2/channels/{channel_id}/twitch/{channel_provider_id}/raid`
     *
     * Requires the `chat:moderate` scope.
     */
    public function deleteRaid(string $channelId, string $channelProviderId): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'DELETE',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/twitch/{channel_provider_id}/raid', ['channel_id' => $channelId, 'channel_provider_id' => $channelProviderId]),
        );

        $this->client->send($request);
    }

    /**
     * Raid Channel.
     *
     * `POST /api/2/channels/{channel_id}/twitch/{channel_provider_id}/raid`
     *
     * Requires the `chat:moderate` scope.
     *
     * @param \Synchra\Model\BodyRaidChannelApi2ChannelsChannelIdTwitchChannelProviderIdRaidPost $payload The request body.
     */
    public function raidChannel(string $channelId, string $channelProviderId, \Synchra\Model\BodyRaidChannelApi2ChannelsChannelIdTwitchChannelProviderIdRaidPost $payload): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/twitch/{channel_provider_id}/raid', ['channel_id' => $channelId, 'channel_provider_id' => $channelProviderId]),
            body: $payload,
        );

        $this->client->send($request);
    }

    /**
     * Shoutout User.
     *
     * `POST /api/2/channels/{channel_id}/twitch/{channel_provider_id}/shoutout`
     *
     * Requires the `chat:moderate` scope.
     *
     * @param \Synchra\Model\BodyShoutoutUserApi2ChannelsChannelIdTwitchChannelProviderIdShoutoutPost $payload The request body.
     */
    public function shoutoutUser(string $channelId, string $channelProviderId, \Synchra\Model\BodyShoutoutUserApi2ChannelsChannelIdTwitchChannelProviderIdShoutoutPost $payload): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/twitch/{channel_provider_id}/shoutout', ['channel_id' => $channelId, 'channel_provider_id' => $channelProviderId]),
            body: $payload,
        );

        $this->client->send($request);
    }

    /**
     * Remove Vip User.
     *
     * `DELETE /api/2/channels/{channel_id}/twitch/{channel_provider_id}/vips`
     *
     * Requires the `chat:moderate` scope.
     *
     * @param \Synchra\Model\BodyRemoveVipUserApi2ChannelsChannelIdTwitchChannelProviderIdVipsDelete $payload The request body.
     */
    public function removeVipUser(string $channelId, string $channelProviderId, \Synchra\Model\BodyRemoveVipUserApi2ChannelsChannelIdTwitchChannelProviderIdVipsDelete $payload): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'DELETE',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/twitch/{channel_provider_id}/vips', ['channel_id' => $channelId, 'channel_provider_id' => $channelProviderId]),
            body: $payload,
        );

        $this->client->send($request);
    }

    /**
     * Get Vip Users.
     *
     * `GET /api/2/channels/{channel_id}/twitch/{channel_provider_id}/vips`
     *
     * Requires the `chat:moderate` scope.
     *
     * @return list<\Synchra\Model\ProviderViewer>
     */
    public function getVipUsers(string $channelId, string $channelProviderId): array
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/twitch/{channel_provider_id}/vips', ['channel_id' => $channelId, 'channel_provider_id' => $channelProviderId]),
        );

        return \array_map(\Synchra\Model\ProviderViewer::fromArray(...), $this->client->send($request)->objects());
    }

    /**
     * Add Vip User.
     *
     * `POST /api/2/channels/{channel_id}/twitch/{channel_provider_id}/vips`
     *
     * Requires the `chat:moderate` scope.
     *
     * @param \Synchra\Model\BodyAddVipUserApi2ChannelsChannelIdTwitchChannelProviderIdVipsPost $payload The request body.
     */
    public function addVipUser(string $channelId, string $channelProviderId, \Synchra\Model\BodyAddVipUserApi2ChannelsChannelIdTwitchChannelProviderIdVipsPost $payload): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/twitch/{channel_provider_id}/vips', ['channel_id' => $channelId, 'channel_provider_id' => $channelProviderId]),
            body: $payload,
        );

        $this->client->send($request);
    }
}
