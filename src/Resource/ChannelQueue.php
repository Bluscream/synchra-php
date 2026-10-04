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
 * The `Channel Queue` endpoints.
 *
 * Reach this group with `$synchra->channelQueue()`.
 */
final class ChannelQueue extends AbstractResource
{
    /**
     * Get Queues.
     *
     * `GET /api/2/channels/{channel_id}/queues`
     *
     * Requires the `channel_viewer_queue:read` scope.
     *
     * @param ?\Synchra\Query\QueuesQuery $query Optional filters.
     * @return \Synchra\Pagination\Page<\Synchra\Model\Queue>
     */
    public function getQueues(string $channelId, ?\Synchra\Query\QueuesQuery $query = null): \Synchra\Pagination\Page
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/queues', ['channel_id' => $channelId]),
            query: [...($query?->toArray() ?? [])],
        );

        return \Synchra\Pagination\Page::ofModel($this->client->send($request)->object(), \Synchra\Model\Queue::class);
    }

    /**
     * Create Queue.
     *
     * `POST /api/2/channels/{channel_id}/queues`
     *
     * Requires the `channel_viewer_queue:write` scope.
     *
     * @param \Synchra\Model\QueueCreate $payload The request body.
     */
    public function createQueue(string $channelId, \Synchra\Model\QueueCreate $payload): \Synchra\Model\Queue
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/queues', ['channel_id' => $channelId]),
            body: $payload,
        );

        return \Synchra\Model\Queue::fromArray($this->client->send($request)->object());
    }

    /**
     * Delete Queue.
     *
     * `DELETE /api/2/channels/{channel_id}/queues/{channel_queue_id}`
     *
     * Requires the `channel_viewer_queue:write` scope.
     */
    public function deleteQueue(string $channelId, string $channelQueueId): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'DELETE',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/queues/{channel_queue_id}', ['channel_id' => $channelId, 'channel_queue_id' => $channelQueueId]),
        );

        $this->client->send($request);
    }

    /**
     * Get Queue.
     *
     * `GET /api/2/channels/{channel_id}/queues/{channel_queue_id}`
     *
     * Requires the `channel_viewer_queue:read` scope.
     */
    public function getQueue(string $channelId, string $channelQueueId): \Synchra\Model\Queue
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/queues/{channel_queue_id}', ['channel_id' => $channelId, 'channel_queue_id' => $channelQueueId]),
        );

        return \Synchra\Model\Queue::fromArray($this->client->send($request)->object());
    }

    /**
     * Update Queue.
     *
     * `PUT /api/2/channels/{channel_id}/queues/{channel_queue_id}`
     *
     * Requires the `channel_viewer_queue:write` scope.
     *
     * @param \Synchra\Model\QueueUpdate $payload The request body.
     */
    public function updateQueue(string $channelId, string $channelQueueId, \Synchra\Model\QueueUpdate $payload): \Synchra\Model\Queue
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'PUT',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/queues/{channel_queue_id}', ['channel_id' => $channelId, 'channel_queue_id' => $channelQueueId]),
            body: $payload,
        );

        return \Synchra\Model\Queue::fromArray($this->client->send($request)->object());
    }

    /**
     * Move Viewer To Top Of Queue.
     *
     * `PUT /api/2/channels/{channel_id}/queues/{channel_queue_id}/move-to-top`
     *
     * Requires the `channel_viewer_queue:write` scope.
     *
     * @param \Synchra\Model\BodyMoveViewerToTopOfQueueApi2ChannelsChannelIdQueuesChannelQueueIdMoveToTopPut $payload The request body.
     */
    public function moveViewerToTopOfQueue(string $channelId, string $channelQueueId, \Synchra\Model\BodyMoveViewerToTopOfQueueApi2ChannelsChannelIdQueuesChannelQueueIdMoveToTopPut $payload): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'PUT',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/queues/{channel_queue_id}/move-to-top', ['channel_id' => $channelId, 'channel_queue_id' => $channelQueueId]),
            body: $payload,
        );

        $this->client->send($request);
    }

    /**
     * Clear Viewer Queue.
     *
     * `DELETE /api/2/channels/{channel_id}/queues/{channel_queue_id}/viewers`
     *
     * Requires the `channel_viewer_queue:write` scope.
     */
    public function clearViewerQueue(string $channelId, string $channelQueueId): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'DELETE',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/queues/{channel_queue_id}/viewers', ['channel_id' => $channelId, 'channel_queue_id' => $channelQueueId]),
        );

        $this->client->send($request);
    }

    /**
     * Get Queue Viewers.
     *
     * `GET /api/2/channels/{channel_id}/queues/{channel_queue_id}/viewers`
     *
     * Requires the `channel_viewer_queue:read` scope.
     *
     * @param ?\Synchra\Query\QueueViewersQuery $query Optional filters.
     * @return \Synchra\Pagination\Page<\Synchra\Model\QueueViewer>
     */
    public function getQueueViewers(string $channelId, string $channelQueueId, ?\Synchra\Query\QueueViewersQuery $query = null): \Synchra\Pagination\Page
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/queues/{channel_queue_id}/viewers', ['channel_id' => $channelId, 'channel_queue_id' => $channelQueueId]),
            query: [...($query?->toArray() ?? [])],
        );

        return \Synchra\Pagination\Page::ofModel($this->client->send($request)->object(), \Synchra\Model\QueueViewer::class);
    }

    /**
     * Add Viewer To Channel Queue.
     *
     * `POST /api/2/channels/{channel_id}/queues/{channel_queue_id}/viewers`
     *
     * Requires the `channel_viewer_queue:write` scope.
     *
     * @param \Synchra\Model\QueueViewerCreate $payload The request body.
     */
    public function addViewerToChannelQueue(string $channelId, string $channelQueueId, \Synchra\Model\QueueViewerCreate $payload): \Synchra\Model\QueueViewer
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/queues/{channel_queue_id}/viewers', ['channel_id' => $channelId, 'channel_queue_id' => $channelQueueId]),
            body: $payload,
        );

        return \Synchra\Model\QueueViewer::fromArray($this->client->send($request)->object());
    }

    /**
     * Remove Viewer From Channel Queue.
     *
     * `DELETE /api/2/channels/{channel_id}/queues/{channel_queue_id}/viewers/{channel_queue_viewer_id}`
     *
     * Requires the `channel_viewer_queue:write` scope.
     */
    public function removeViewerFromChannelQueue(string $channelId, string $channelQueueId, string $channelQueueViewerId): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'DELETE',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/queues/{channel_queue_id}/viewers/{channel_queue_viewer_id}', ['channel_id' => $channelId, 'channel_queue_id' => $channelQueueId, 'channel_queue_viewer_id' => $channelQueueViewerId]),
        );

        $this->client->send($request);
    }
}
