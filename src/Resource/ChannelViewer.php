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
 * The `Channel Viewer` endpoints.
 *
 * Reach this group with `$synchra->channelViewer()`.
 */
final class ChannelViewer extends AbstractResource
{
    /**
     * Viewer Info.
     *
     * `GET /api/2/channels/{channel_id}/viewers/{provider}/{provider_viewer_id}`
     *
     * Requires the `channel_viewer:read` scope.
     */
    public function viewerInfo(string $channelId, \Synchra\Enum\Provider $provider, string $providerViewerId): \Synchra\Model\ChannelViewer
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/viewers/{provider}/{provider_viewer_id}', ['channel_id' => $channelId, 'provider' => $provider, 'provider_viewer_id' => $providerViewerId]),
        );

        return \Synchra\Model\ChannelViewer::fromArray($this->client->send($request)->object());
    }

    /**
     * Provider Viewer Info.
     *
     * `GET /api/2/channels/{channel_id}/viewers/{provider}/{provider_viewer_id}/info`
     *
     * Requires the `channel_viewer:read` scope.
     */
    public function providerViewerInfo(string $channelId, \Synchra\Enum\Provider $provider, string $providerViewerId): \Synchra\Model\ProviderViewer
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/viewers/{provider}/{provider_viewer_id}/info', ['channel_id' => $channelId, 'provider' => $provider, 'provider_viewer_id' => $providerViewerId]),
        );

        return \Synchra\Model\ProviderViewer::fromArray($this->client->send($request)->object());
    }

    /**
     * Viewer Watched Streams.
     *
     * `GET /api/2/channels/{channel_id}/viewers/{provider}/{provider_viewer_id}/streams`
     *
     * Requires the `channel_viewer:read` scope.
     *
     * @param ?\Synchra\Query\ViewerWatchedStreamsQuery $query Optional filters.
     * @return \Synchra\Pagination\Page<\Synchra\Model\ViewerStream>
     */
    public function viewerWatchedStreams(string $channelId, \Synchra\Enum\Provider $provider, string $providerViewerId, ?\Synchra\Query\ViewerWatchedStreamsQuery $query = null): \Synchra\Pagination\Page
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/viewers/{provider}/{provider_viewer_id}/streams', ['channel_id' => $channelId, 'provider' => $provider, 'provider_viewer_id' => $providerViewerId]),
            query: [...($query?->toArray() ?? [])],
        );

        return \Synchra\Pagination\Page::ofModel($this->client->send($request)->object(), \Synchra\Model\ViewerStream::class);
    }

    /**
     * Viewer Search.
     *
     * `GET /api/2/viewer-search`
     *
     * Requires the `channel_viewer:read` scope.
     *
     * @param ?\Synchra\Query\ViewerSearchQuery $filters Optional filters.
     * @return list<\Synchra\Model\ProviderViewer>
     */
    public function viewerSearch(string $query, ?\Synchra\Query\ViewerSearchQuery $filters = null): array
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: '/viewer-search',
            query: [...($filters?->toArray() ?? []), 'query' => $query],
        );

        return \array_map(\Synchra\Model\ProviderViewer::fromArray(...), $this->client->send($request)->objects());
    }
}
