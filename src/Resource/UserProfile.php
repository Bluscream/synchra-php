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
 * The `User Profile` endpoints.
 *
 * Reach this group with `$synchra->userProfile()`.
 */
final class UserProfile extends AbstractResource
{
    /**
     * Get User Profiles.
     *
     * `GET /api/2/user/profiles`
     *
     * Requires the `user_profile:read` scope.
     */
    public function getUserProfiles(\Synchra\Enum\UserProfileType $profileType): \Synchra\Model\UserProfileList
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: '/user/profiles',
            query: ['profile_type' => $profileType],
        );

        return \Synchra\Model\UserProfileList::fromArray($this->client->send($request)->object());
    }

    /**
     * Create User Profile.
     *
     * `POST /api/2/user/profiles`
     *
     * Requires the `user_profile:write` scope.
     *
     * @param \Synchra\Model\DashboardUserProfileCreate|\Synchra\Model\ChatUserProfileCreate|\Synchra\Model\ActivityFeedUserProfileCreate|\Synchra\Model\ControlsUserProfileCreate $payload The request body.
     */
    public function createUserProfile(\Synchra\Model\DashboardUserProfileCreate|\Synchra\Model\ChatUserProfileCreate|\Synchra\Model\ActivityFeedUserProfileCreate|\Synchra\Model\ControlsUserProfileCreate $payload): \Synchra\Model\DashboardUserProfile|\Synchra\Model\ChatUserProfile|\Synchra\Model\ActivityFeedUserProfile|\Synchra\Model\ControlsUserProfile
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: '/user/profiles',
            body: $payload,
        );

        return \Synchra\Model\Union\UserProfileUnion2::fromArray($this->client->send($request)->object());
    }

    /**
     * Delete User Profile.
     *
     * `DELETE /api/2/user/profiles/{profile_id}`
     *
     * Requires the `user_profile:write` scope.
     */
    public function deleteUserProfile(string $profileId): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'DELETE',
            path: \Synchra\Http\Path::expand('/user/profiles/{profile_id}', ['profile_id' => $profileId]),
        );

        $this->client->send($request);
    }

    /**
     * Patch User Profile.
     *
     * `PATCH /api/2/user/profiles/{profile_id}`
     *
     * Requires the `user_profile:write` scope.
     *
     * @param \Synchra\Model\DashboardUserProfileUpdate|\Synchra\Model\ChatUserProfileUpdate|\Synchra\Model\ActivityFeedUserProfileUpdate|\Synchra\Model\ControlsUserProfileUpdate $payload The request body.
     */
    public function patchUserProfile(string $profileId, \Synchra\Model\DashboardUserProfileUpdate|\Synchra\Model\ChatUserProfileUpdate|\Synchra\Model\ActivityFeedUserProfileUpdate|\Synchra\Model\ControlsUserProfileUpdate $payload): \Synchra\Model\DashboardUserProfile|\Synchra\Model\ChatUserProfile|\Synchra\Model\ActivityFeedUserProfile|\Synchra\Model\ControlsUserProfile
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'PATCH',
            path: \Synchra\Http\Path::expand('/user/profiles/{profile_id}', ['profile_id' => $profileId]),
            body: $payload,
        );

        return \Synchra\Model\Union\UserProfileUnion2::fromArray($this->client->send($request)->object());
    }

    /**
     * Put User Profile.
     *
     * `PUT /api/2/user/profiles/{profile_id}`
     *
     * Requires the `user_profile:write` scope.
     *
     * @param \Synchra\Model\DashboardUserProfileUpdate|\Synchra\Model\ChatUserProfileUpdate|\Synchra\Model\ActivityFeedUserProfileUpdate|\Synchra\Model\ControlsUserProfileUpdate $payload The request body.
     */
    public function putUserProfile(string $profileId, \Synchra\Model\DashboardUserProfileUpdate|\Synchra\Model\ChatUserProfileUpdate|\Synchra\Model\ActivityFeedUserProfileUpdate|\Synchra\Model\ControlsUserProfileUpdate $payload): \Synchra\Model\DashboardUserProfile|\Synchra\Model\ChatUserProfile|\Synchra\Model\ActivityFeedUserProfile|\Synchra\Model\ControlsUserProfile
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'PUT',
            path: \Synchra\Http\Path::expand('/user/profiles/{profile_id}', ['profile_id' => $profileId]),
            body: $payload,
        );

        return \Synchra\Model\Union\UserProfileUnion2::fromArray($this->client->send($request)->object());
    }

    /**
     * Get User Profiles Deprecated.
     *
     * `GET /api/2/user/profiles/{profile_type}`
     *
     * Requires the `user_profile:read` scope.
     */
    public function getUserProfilesDeprecated(\Synchra\Enum\UserProfileType $profileType): \Synchra\Model\UserProfileList
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/user/profiles/{profile_type}', ['profile_type' => $profileType]),
        );

        return \Synchra\Model\UserProfileList::fromArray($this->client->send($request)->object());
    }

    /**
     * Create User Profile Deprecated.
     *
     * `POST /api/2/user/profiles/{profile_type}`
     *
     * Requires the `user_profile:write` scope.
     *
     * @param \Synchra\Model\DashboardUserProfileCreate|\Synchra\Model\ChatUserProfileCreate|\Synchra\Model\ActivityFeedUserProfileCreate|\Synchra\Model\ControlsUserProfileCreate $payload The request body.
     */
    public function createUserProfileDeprecated(\Synchra\Enum\UserProfileType $profileType, \Synchra\Model\DashboardUserProfileCreate|\Synchra\Model\ChatUserProfileCreate|\Synchra\Model\ActivityFeedUserProfileCreate|\Synchra\Model\ControlsUserProfileCreate $payload): \Synchra\Model\DashboardUserProfile|\Synchra\Model\ChatUserProfile|\Synchra\Model\ActivityFeedUserProfile|\Synchra\Model\ControlsUserProfile
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/user/profiles/{profile_type}', ['profile_type' => $profileType]),
            body: $payload,
        );

        return \Synchra\Model\Union\UserProfileUnion2::fromArray($this->client->send($request)->object());
    }

    /**
     * Patch User Profile Deprecated.
     *
     * `PATCH /api/2/user/profiles/{profile_type}/{profile_id}`
     *
     * Requires the `user_profile:write` scope.
     *
     * @param \Synchra\Model\DashboardUserProfileUpdate|\Synchra\Model\ChatUserProfileUpdate|\Synchra\Model\ActivityFeedUserProfileUpdate|\Synchra\Model\ControlsUserProfileUpdate $payload The request body.
     */
    public function patchUserProfileDeprecated(\Synchra\Enum\UserProfileType $profileType, string $profileId, \Synchra\Model\DashboardUserProfileUpdate|\Synchra\Model\ChatUserProfileUpdate|\Synchra\Model\ActivityFeedUserProfileUpdate|\Synchra\Model\ControlsUserProfileUpdate $payload): \Synchra\Model\DashboardUserProfile|\Synchra\Model\ChatUserProfile|\Synchra\Model\ActivityFeedUserProfile|\Synchra\Model\ControlsUserProfile
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'PATCH',
            path: \Synchra\Http\Path::expand('/user/profiles/{profile_type}/{profile_id}', ['profile_type' => $profileType, 'profile_id' => $profileId]),
            body: $payload,
        );

        return \Synchra\Model\Union\UserProfileUnion2::fromArray($this->client->send($request)->object());
    }

    /**
     * Put User Profile Deprecated.
     *
     * `PUT /api/2/user/profiles/{profile_type}/{profile_id}`
     *
     * Requires the `user_profile:write` scope.
     *
     * @param \Synchra\Model\DashboardUserProfileUpdate|\Synchra\Model\ChatUserProfileUpdate|\Synchra\Model\ActivityFeedUserProfileUpdate|\Synchra\Model\ControlsUserProfileUpdate $payload The request body.
     */
    public function putUserProfileDeprecated(\Synchra\Enum\UserProfileType $profileType, string $profileId, \Synchra\Model\DashboardUserProfileUpdate|\Synchra\Model\ChatUserProfileUpdate|\Synchra\Model\ActivityFeedUserProfileUpdate|\Synchra\Model\ControlsUserProfileUpdate $payload): \Synchra\Model\DashboardUserProfile|\Synchra\Model\ChatUserProfile|\Synchra\Model\ActivityFeedUserProfile|\Synchra\Model\ControlsUserProfile
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'PUT',
            path: \Synchra\Http\Path::expand('/user/profiles/{profile_type}/{profile_id}', ['profile_type' => $profileType, 'profile_id' => $profileId]),
            body: $payload,
        );

        return \Synchra\Model\Union\UserProfileUnion2::fromArray($this->client->send($request)->object());
    }
}
