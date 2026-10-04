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
 * The `User` endpoints.
 *
 * Reach this group with `$synchra->user()`.
 */
final class User extends AbstractResource
{
    /**
     * Get Users As Admin.
     *
     * `GET /api/2/admin/users`
     *
     * @param ?\Synchra\Query\UsersAsAdminQuery $query Optional filters.
     * @return \Synchra\Pagination\Page<\Synchra\Model\UserSummary>
     */
    public function getUsersAsAdmin(?\Synchra\Query\UsersAsAdminQuery $query = null): \Synchra\Pagination\Page
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: '/admin/users',
            query: [...($query?->toArray() ?? [])],
        );

        return \Synchra\Pagination\Page::ofModel($this->client->send($request)->object(), \Synchra\Model\UserSummary::class);
    }

    /**
     * Delete User As Admin.
     *
     * `DELETE /api/2/admin/users/{user_id}`
     */
    public function deleteUserAsAdmin(string $userId): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'DELETE',
            path: \Synchra\Http\Path::expand('/admin/users/{user_id}', ['user_id' => $userId]),
        );

        $this->client->send($request);
    }

    /**
     * Get User Channels As Admin.
     *
     * `GET /api/2/admin/users/{user_id}/channels`
     *
     * @param ?\Synchra\Query\UserChannelsAsAdminQuery $query Optional filters.
     * @return \Synchra\Pagination\Page<\Synchra\Model\UserChannelSummary>
     */
    public function getUserChannelsAsAdmin(string $userId, ?\Synchra\Query\UserChannelsAsAdminQuery $query = null): \Synchra\Pagination\Page
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/admin/users/{user_id}/channels', ['user_id' => $userId]),
            query: [...($query?->toArray() ?? [])],
        );

        return \Synchra\Pagination\Page::ofModel($this->client->send($request)->object(), \Synchra\Model\UserChannelSummary::class);
    }

    /**
     * Disconnect User Provider As Admin.
     *
     * `DELETE /api/2/admin/users/{user_id}/providers/{user_provider_id}`
     */
    public function disconnectUserProviderAsAdmin(string $userId, string $userProviderId): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'DELETE',
            path: \Synchra\Http\Path::expand('/admin/users/{user_id}/providers/{user_provider_id}', ['user_id' => $userId, 'user_provider_id' => $userProviderId]),
        );

        $this->client->send($request);
    }

    /**
     * Delete User.
     *
     * `DELETE /api/2/user`
     */
    public function deleteUser(string $username): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'DELETE',
            path: '/user',
            query: ['username' => $username],
        );

        $this->client->send($request);
    }

    /**
     * User Info.
     *
     * `GET /api/2/user`
     */
    public function userInfo(): \Synchra\Model\UserPublic
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: '/user',
        );

        return \Synchra\Model\UserPublic::fromArray($this->client->send($request)->object());
    }

    /**
     * User Global Admin Status.
     *
     * `GET /api/2/user/global-admin`
     */
    public function userGlobalAdminStatus(): \Synchra\Model\UserGlobalAdminStatus
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: '/user/global-admin',
        );

        return \Synchra\Model\UserGlobalAdminStatus::fromArray($this->client->send($request)->object());
    }

    /**
     * Get User Providers Route.
     *
     * `GET /api/2/user/providers`
     *
     * Requires the `user:provider:read` scope.
     *
     * @return list<\Synchra\Model\UserProviderPublic>
     */
    public function getUserProviders(): array
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: '/user/providers',
        );

        return \array_map(\Synchra\Model\UserProviderPublic::fromArray(...), $this->client->send($request)->objects());
    }

    /**
     * Delete User Provider Route.
     *
     * `DELETE /api/2/user/providers/{user_provider_id}`
     *
     * Requires the `user:provider:write` scope.
     */
    public function deleteUserProvider(string $userProviderId): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'DELETE',
            path: \Synchra\Http\Path::expand('/user/providers/{user_provider_id}', ['user_provider_id' => $userProviderId]),
        );

        $this->client->send($request);
    }

    /**
     * Get User Provider Route.
     *
     * `GET /api/2/user/providers/{user_provider_id}`
     *
     * Requires the `user:provider:read` scope.
     */
    public function getUserProvider(string $userProviderId): \Synchra\Model\UserProviderPublic
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/user/providers/{user_provider_id}', ['user_provider_id' => $userProviderId]),
        );

        return \Synchra\Model\UserProviderPublic::fromArray($this->client->send($request)->object());
    }

    /**
     * User Settings.
     *
     * `GET /api/2/user/settings`
     */
    public function userSettings(): \Synchra\Model\UserSettings
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: '/user/settings',
        );

        return \Synchra\Model\UserSettings::fromArray($this->client->send($request)->object());
    }

    /**
     * Update User Settings.
     *
     * `PUT /api/2/user/settings`
     *
     * @param \Synchra\Model\UserSettingsUpdate $payload The request body.
     */
    public function updateUserSettings(\Synchra\Model\UserSettingsUpdate $payload): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'PUT',
            path: '/user/settings',
            body: $payload,
        );

        $this->client->send($request);
    }
}
