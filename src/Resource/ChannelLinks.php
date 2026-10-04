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
 * The `Channel Links` endpoints.
 *
 * Reach this group with `$synchra->channelLinks()`.
 */
final class ChannelLinks extends AbstractResource
{
    /**
     * Get Channel Links.
     *
     * `GET /api/2/channels/{channel_id}/links`
     *
     * Requires the `channel_link:read` scope.
     *
     * @param ?\Synchra\Query\ChannelLinksQuery $query Optional filters.
     * @return \Synchra\Pagination\Page<\Synchra\Model\ChannelLink>
     */
    public function getChannelLinks(string $channelId, ?\Synchra\Query\ChannelLinksQuery $query = null): \Synchra\Pagination\Page
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/links', ['channel_id' => $channelId]),
            query: [...($query?->toArray() ?? [])],
        );

        return \Synchra\Pagination\Page::ofModel($this->client->send($request)->object(), \Synchra\Model\ChannelLink::class);
    }

    /**
     * Create Channel Link.
     *
     * `POST /api/2/channels/{channel_id}/links`
     *
     * Requires the `channel_link:write` scope.
     *
     * @param \Synchra\Model\ChannelLinkCreate $payload The request body.
     */
    public function createChannelLink(string $channelId, \Synchra\Model\ChannelLinkCreate $payload): \Synchra\Model\ChannelLink
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/links', ['channel_id' => $channelId]),
            body: $payload,
        );

        return \Synchra\Model\ChannelLink::fromArray($this->client->send($request)->object());
    }

    /**
     * Delete Channel Link.
     *
     * `DELETE /api/2/channels/{channel_id}/links/{link_id}`
     *
     * Requires the `channel_link:write` scope.
     */
    public function deleteChannelLink(string $channelId, string $linkId): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'DELETE',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/links/{link_id}', ['channel_id' => $channelId, 'link_id' => $linkId]),
        );

        $this->client->send($request);
    }

    /**
     * Get Channel Link.
     *
     * `GET /api/2/channels/{channel_id}/links/{link_id}`
     *
     * Requires the `channel_link:read` scope.
     */
    public function getChannelLink(string $channelId, string $linkId): \Synchra\Model\ChannelLink
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/links/{link_id}', ['channel_id' => $channelId, 'link_id' => $linkId]),
        );

        return \Synchra\Model\ChannelLink::fromArray($this->client->send($request)->object());
    }

    /**
     * Update Channel Link.
     *
     * `PUT /api/2/channels/{channel_id}/links/{link_id}`
     *
     * Requires the `channel_link:write` scope.
     *
     * @param \Synchra\Model\ChannelLinkUpdate $payload The request body.
     */
    public function updateChannelLink(string $channelId, string $linkId, \Synchra\Model\ChannelLinkUpdate $payload): \Synchra\Model\ChannelLink
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'PUT',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/links/{link_id}', ['channel_id' => $channelId, 'link_id' => $linkId]),
            body: $payload,
        );

        return \Synchra\Model\ChannelLink::fromArray($this->client->send($request)->object());
    }

    /**
     * Get Channel Link Metrics.
     *
     * `GET /api/2/channels/{channel_id}/links/{link_id}/metrics`
     *
     * Requires the `channel_link:read` scope.
     *
     * @param ?\Synchra\Query\ChannelLinkMetricsQuery $query Optional filters.
     * @return list<\Synchra\Model\ChannelLinkStatsMetricItem>
     */
    public function getChannelLinkMetrics(string $channelId, string $linkId, \Synchra\Enum\ChannelLinkStatsMetric $type, ?\Synchra\Query\ChannelLinkMetricsQuery $query = null): array
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/links/{link_id}/metrics', ['channel_id' => $channelId, 'link_id' => $linkId]),
            query: [...($query?->toArray() ?? []), 'type' => $type],
        );

        return \array_map(\Synchra\Model\ChannelLinkStatsMetricItem::fromArray(...), $this->client->send($request)->objects());
    }

    /**
     * Get Channel Link Stats.
     *
     * `GET /api/2/channels/{channel_id}/links/{link_id}/stats`
     *
     * Requires the `channel_link:read` scope.
     *
     * @param ?\Synchra\Query\ChannelLinkStatsQuery $query Optional filters.
     */
    public function getChannelLinkStats(string $channelId, string $linkId, ?\Synchra\Query\ChannelLinkStatsQuery $query = null): \Synchra\Model\ChannelLinkStats
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/links/{link_id}/stats', ['channel_id' => $channelId, 'link_id' => $linkId]),
            query: [...($query?->toArray() ?? [])],
        );

        return \Synchra\Model\ChannelLinkStats::fromArray($this->client->send($request)->object());
    }

    /**
     * Get Channel Link Views.
     *
     * `GET /api/2/channels/{channel_id}/links/{link_id}/views`
     *
     * Requires the `channel_link:read` scope.
     *
     * @param ?\Synchra\Query\ChannelLinkViewsQuery $query Optional filters.
     */
    public function getChannelLinkViews(string $channelId, string $linkId, ?\Synchra\Query\ChannelLinkViewsQuery $query = null): \Synchra\Model\ChannelLinkViews
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/links/{link_id}/views', ['channel_id' => $channelId, 'link_id' => $linkId]),
            query: [...($query?->toArray() ?? [])],
        );

        return \Synchra\Model\ChannelLinkViews::fromArray($this->client->send($request)->object());
    }

    /**
     * Get Link Tracking Config.
     *
     * `GET /api/2/link-tracking/config`
     */
    public function getLinkTrackingConfig(): \Synchra\Model\ChannelLinkTrackingConfig
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: '/link-tracking/config',
        );

        return \Synchra\Model\ChannelLinkTrackingConfig::fromArray($this->client->send($request)->object());
    }
}
