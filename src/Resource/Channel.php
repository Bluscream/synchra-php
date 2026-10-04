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
 * The `Channel` endpoints.
 *
 * Reach this group with `$synchra->channel()`.
 */
final class Channel extends AbstractResource
{
    /**
     * Get Channels.
     *
     * `GET /api/2/channels`
     *
     * Requires the `channel:read` scope.
     *
     * @param ?\Synchra\Query\ChannelsQuery $query Optional filters.
     * @return \Synchra\Pagination\Page<\Synchra\Model\Channel>
     */
    public function getChannels(?\Synchra\Query\ChannelsQuery $query = null): \Synchra\Pagination\Page
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: '/channels',
            query: [...($query?->toArray() ?? [])],
        );

        return \Synchra\Pagination\Page::ofModel($this->client->send($request)->object(), \Synchra\Model\Channel::class);
    }

    /**
     * Create Channel.
     *
     * `POST /api/2/channels`
     *
     * Requires the `channel:write` scope.
     *
     * @param \Synchra\Model\ChannelCreate $payload The request body.
     */
    public function createChannel(\Synchra\Model\ChannelCreate $payload): \Synchra\Model\Channel
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: '/channels',
            body: $payload,
        );

        return \Synchra\Model\Channel::fromArray($this->client->send($request)->object());
    }

    /**
     * Delete Channel.
     *
     * `DELETE /api/2/channels/{channel_id}`
     *
     * Requires the `channel:delete` scope.
     */
    public function deleteChannel(string $channelId, string $channelName): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'DELETE',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}', ['channel_id' => $channelId]),
            query: ['channel_name' => $channelName],
        );

        $this->client->send($request);
    }

    /**
     * Get Channel.
     *
     * `GET /api/2/channels/{channel_id}`
     *
     * Requires the `channel:read` scope.
     */
    public function getChannel(string $channelId): \Synchra\Model\Channel
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}', ['channel_id' => $channelId]),
        );

        return \Synchra\Model\Channel::fromArray($this->client->send($request)->object());
    }

    /**
     * Update Channel.
     *
     * `PUT /api/2/channels/{channel_id}`
     *
     * Requires the `channel:write` scope.
     *
     * @param \Synchra\Model\ChannelUpdate $payload The request body.
     */
    public function updateChannel(string $channelId, \Synchra\Model\ChannelUpdate $payload): \Synchra\Model\Channel
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'PUT',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}', ['channel_id' => $channelId]),
            body: $payload,
        );

        return \Synchra\Model\Channel::fromArray($this->client->send($request)->object());
    }
}
