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
 * The `Channel User Invite` endpoints.
 *
 * Reach this group with `$synchra->channelUserInvite()`.
 */
final class ChannelUserInvite extends AbstractResource
{
    /**
     * Add Admin Channel User Access.
     *
     * `POST /api/2/admin/channels/{channel_id}/users-access`
     *
     * @param \Synchra\Model\BodyAddAdminChannelUserAccessApi2AdminChannelsChannelIdUsersAccessPost $payload The request body.
     */
    public function addAdminChannelUserAccess(string $channelId, \Synchra\Model\BodyAddAdminChannelUserAccessApi2AdminChannelsChannelIdUsersAccessPost $payload): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/admin/channels/{channel_id}/users-access', ['channel_id' => $channelId]),
            body: $payload,
        );

        $this->client->send($request);
    }

    /**
     * Channel User Invite Accept.
     *
     * `POST /api/2/channel-user-invites/{channel_user_invite_id}/accept`
     */
    public function channelUserInviteAccept(string $channelUserInviteId): \Synchra\Model\Channel
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/channel-user-invites/{channel_user_invite_id}/accept', ['channel_user_invite_id' => $channelUserInviteId]),
        );

        return \Synchra\Model\Channel::fromArray($this->client->send($request)->object());
    }

    /**
     * Get Channel Access Level Route.
     *
     * `GET /api/2/channels/{channel_id}/access-level`
     */
    public function getChannelAccessLevel(string $channelId): ?\Synchra\Model\ChannelUserAccessLevel
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/access-level', ['channel_id' => $channelId]),
        );

        return ($body = $this->client->send($request)->objectOrNull()) === null ? null : \Synchra\Model\ChannelUserAccessLevel::fromArray($body);
    }

    /**
     * Channel User Invites.
     *
     * `GET /api/2/channels/{channel_id}/user-invites`
     *
     * Requires the `channel_user_access:write` scope.
     *
     * @param ?\Synchra\Query\ChannelUserInvitesQuery $query Optional filters.
     * @return \Synchra\Pagination\Page<\Synchra\Model\ChannelUserInvite>
     */
    public function channelUserInvites(string $channelId, ?\Synchra\Query\ChannelUserInvitesQuery $query = null): \Synchra\Pagination\Page
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/user-invites', ['channel_id' => $channelId]),
            query: [...($query?->toArray() ?? [])],
        );

        return \Synchra\Pagination\Page::ofModel($this->client->send($request)->object(), \Synchra\Model\ChannelUserInvite::class);
    }

    /**
     * Channel User Invite.
     *
     * `POST /api/2/channels/{channel_id}/user-invites`
     *
     * Requires the `channel_user_access:write` scope.
     *
     * @param \Synchra\Model\ChannelUserInviteCreate $payload The request body.
     */
    public function channelUserInvite(string $channelId, \Synchra\Model\ChannelUserInviteCreate $payload): \Synchra\Model\ChannelUserInvite
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/user-invites', ['channel_id' => $channelId]),
            body: $payload,
        );

        return \Synchra\Model\ChannelUserInvite::fromArray($this->client->send($request)->object());
    }

    /**
     * Channel User Invite Delete.
     *
     * `DELETE /api/2/channels/{channel_id}/user-invites/{channel_user_invite_id}`
     *
     * Requires the `channel_user_access:write` scope.
     */
    public function channelUserInviteDelete(string $channelId, string $channelUserInviteId): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'DELETE',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/user-invites/{channel_user_invite_id}', ['channel_id' => $channelId, 'channel_user_invite_id' => $channelUserInviteId]),
        );

        $this->client->send($request);
    }

    /**
     * Channel User Invite Update.
     *
     * `PUT /api/2/channels/{channel_id}/user-invites/{channel_user_invite_id}`
     *
     * Requires the `channel_user_access:write` scope.
     *
     * @param \Synchra\Model\ChannelUserInviteUpdate $payload The request body.
     */
    public function channelUserInviteUpdate(string $channelId, string $channelUserInviteId, \Synchra\Model\ChannelUserInviteUpdate $payload): \Synchra\Model\ChannelUserInvite
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'PUT',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/user-invites/{channel_user_invite_id}', ['channel_id' => $channelId, 'channel_user_invite_id' => $channelUserInviteId]),
            body: $payload,
        );

        return \Synchra\Model\ChannelUserInvite::fromArray($this->client->send($request)->object());
    }

    /**
     * Get Channel Users Access.
     *
     * `GET /api/2/channels/{channel_id}/users-access`
     *
     * Requires the `channel_user_access:read` scope.
     *
     * @param ?\Synchra\Query\ChannelUsersAccessQuery $query Optional filters.
     * @return \Synchra\Pagination\Page<\Synchra\Model\ChannelUserAccessLevelWithUser>
     */
    public function getChannelUsersAccess(string $channelId, ?\Synchra\Query\ChannelUsersAccessQuery $query = null): \Synchra\Pagination\Page
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/users-access', ['channel_id' => $channelId]),
            query: [...($query?->toArray() ?? [])],
        );

        return \Synchra\Pagination\Page::ofModel($this->client->send($request)->object(), \Synchra\Model\ChannelUserAccessLevelWithUser::class);
    }

    /**
     * Delete Channel User Access.
     *
     * `DELETE /api/2/channels/{channel_id}/users-access/{channel_user_access_id}`
     *
     * Requires the `channel_user_access:write` scope.
     */
    public function deleteChannelUserAccess(string $channelId, string $channelUserAccessId): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'DELETE',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/users-access/{channel_user_access_id}', ['channel_id' => $channelId, 'channel_user_access_id' => $channelUserAccessId]),
        );

        $this->client->send($request);
    }

    /**
     * Update Channel User Access Level.
     *
     * `PUT /api/2/channels/{channel_id}/users-access/{channel_user_access_id}`
     *
     * Requires the `channel_user_access:write` scope.
     *
     * @param \Synchra\Model\BodyUpdateChannelUserAccessLevelApi2ChannelsChannelIdUsersAccessChannelUserAccessIdPut $payload The request body.
     */
    public function updateChannelUserAccessLevel(string $channelId, string $channelUserAccessId, \Synchra\Model\BodyUpdateChannelUserAccessLevelApi2ChannelsChannelIdUsersAccessChannelUserAccessIdPut $payload): mixed
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'PUT',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/users-access/{channel_user_access_id}', ['channel_id' => $channelId, 'channel_user_access_id' => $channelUserAccessId]),
            body: $payload,
        );

        return $this->client->send($request)->data;
    }
}
