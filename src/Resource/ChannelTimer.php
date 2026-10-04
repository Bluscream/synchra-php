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
 * The `Channel Timer` endpoints.
 *
 * Reach this group with `$synchra->channelTimer()`.
 */
final class ChannelTimer extends AbstractResource
{
    /**
     * Get Channel Timers.
     *
     * `GET /api/2/channels/{channel_id}/timers`
     *
     * Requires the `channel_timer:read` scope.
     *
     * @param ?\Synchra\Query\ChannelTimersQuery $query Optional filters.
     * @return \Synchra\Pagination\Page<\Synchra\Model\Timer>
     */
    public function getChannelTimers(string $channelId, ?\Synchra\Query\ChannelTimersQuery $query = null): \Synchra\Pagination\Page
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/timers', ['channel_id' => $channelId]),
            query: [...($query?->toArray() ?? [])],
        );

        return \Synchra\Pagination\Page::ofModel($this->client->send($request)->object(), \Synchra\Model\Timer::class);
    }

    /**
     * Create Channel Timer.
     *
     * `POST /api/2/channels/{channel_id}/timers`
     *
     * Requires the `channel_timer:write` scope.
     *
     * @param \Synchra\Model\TimerCreate $payload The request body.
     */
    public function createChannelTimer(string $channelId, \Synchra\Model\TimerCreate $payload): \Synchra\Model\Timer
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/timers', ['channel_id' => $channelId]),
            body: $payload,
        );

        return \Synchra\Model\Timer::fromArray($this->client->send($request)->object());
    }

    /**
     * Delete Channel Timer.
     *
     * `DELETE /api/2/channels/{channel_id}/timers/{timer_id}`
     *
     * Requires the `channel_timer:write` scope.
     */
    public function deleteChannelTimer(string $channelId, string $timerId): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'DELETE',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/timers/{timer_id}', ['channel_id' => $channelId, 'timer_id' => $timerId]),
        );

        $this->client->send($request);
    }

    /**
     * Get Channel Timer.
     *
     * `GET /api/2/channels/{channel_id}/timers/{timer_id}`
     *
     * Requires the `channel_timer:read` scope.
     */
    public function getChannelTimer(string $channelId, string $timerId): \Synchra\Model\Timer
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/timers/{timer_id}', ['channel_id' => $channelId, 'timer_id' => $timerId]),
        );

        return \Synchra\Model\Timer::fromArray($this->client->send($request)->object());
    }

    /**
     * Update Channel Timer.
     *
     * `PUT /api/2/channels/{channel_id}/timers/{timer_id}`
     *
     * Requires the `channel_timer:write` scope.
     *
     * @param \Synchra\Model\TimerUpdate $payload The request body.
     */
    public function updateChannelTimer(string $channelId, string $timerId, \Synchra\Model\TimerUpdate $payload): \Synchra\Model\Timer
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'PUT',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/timers/{timer_id}', ['channel_id' => $channelId, 'timer_id' => $timerId]),
            body: $payload,
        );

        return \Synchra\Model\Timer::fromArray($this->client->send($request)->object());
    }
}
