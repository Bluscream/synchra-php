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
 * The `Channel Activity` endpoints.
 *
 * Reach this group with `$synchra->channelActivity()`.
 */
final class ChannelActivity extends AbstractResource
{
    /**
     * Activity Types.
     *
     * `GET /api/2/activity-types`
     *
     * @param ?\Synchra\Query\ActivityTypesQuery $query Optional filters.
     * @return list<\Synchra\Model\ActivityTypeName>
     */
    public function activityTypes(?\Synchra\Query\ActivityTypesQuery $query = null): array
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: '/activity-types',
            query: [...($query?->toArray() ?? [])],
        );

        return \array_map(\Synchra\Model\ActivityTypeName::fromArray(...), $this->client->send($request)->objects());
    }

    /**
     * Get Activities.
     *
     * `GET /api/2/channels/{channel_id}/activities`
     *
     * Requires the `channel_activity:read` scope.
     *
     * @param ?\Synchra\Query\ActivitiesQuery $query Optional filters.
     * @return \Synchra\Pagination\Page<\Synchra\Model\Activity>
     */
    public function getActivities(string $channelId, ?\Synchra\Query\ActivitiesQuery $query = null): \Synchra\Pagination\Page
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/activities', ['channel_id' => $channelId]),
            query: [...($query?->toArray() ?? [])],
        );

        return \Synchra\Pagination\Page::ofModel($this->client->send($request)->object(), \Synchra\Model\Activity::class);
    }

    /**
     * Delete Activity.
     *
     * `DELETE /api/2/channels/{channel_id}/activities/{activity_id}`
     *
     * Requires the `channel_activity:read` scope.
     */
    public function deleteActivity(string $channelId, string $activityId): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'DELETE',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/activities/{activity_id}', ['channel_id' => $channelId, 'activity_id' => $activityId]),
        );

        $this->client->send($request);
    }

    /**
     * Get Activity.
     *
     * `GET /api/2/channels/{channel_id}/activities/{activity_id}`
     *
     * Requires the `channel_activity:read` scope.
     */
    public function getActivity(string $channelId, string $activityId): \Synchra\Model\Activity
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/activities/{activity_id}', ['channel_id' => $channelId, 'activity_id' => $activityId]),
        );

        return \Synchra\Model\Activity::fromArray($this->client->send($request)->object());
    }

    /**
     * Update Activity.
     *
     * `PUT /api/2/channels/{channel_id}/activities/{activity_id}`
     *
     * Requires the `channel_activity:read` scope.
     *
     * @param \Synchra\Model\ActivityUpdate $payload The request body.
     */
    public function updateActivity(string $channelId, string $activityId, \Synchra\Model\ActivityUpdate $payload): \Synchra\Model\Activity
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'PUT',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/activities/{activity_id}', ['channel_id' => $channelId, 'activity_id' => $activityId]),
            body: $payload,
        );

        return \Synchra\Model\Activity::fromArray($this->client->send($request)->object());
    }
}
