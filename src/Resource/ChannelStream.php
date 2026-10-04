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
 * The `Channel Stream` endpoints.
 *
 * Reach this group with `$synchra->channelStream()`.
 */
final class ChannelStream extends AbstractResource
{
    /**
     * Get Channel Streams.
     *
     * `GET /api/2/channels/{channel_id}/streams`
     *
     * Requires the `channel_stream:read` scope.
     *
     * @param ?\Synchra\Query\ChannelStreamsQuery $query Optional filters.
     * @return \Synchra\Pagination\Page<\Synchra\Model\ChannelStream>
     */
    public function getChannelStreams(string $channelId, ?\Synchra\Query\ChannelStreamsQuery $query = null): \Synchra\Pagination\Page
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/streams', ['channel_id' => $channelId]),
            query: [...($query?->toArray() ?? [])],
        );

        return \Synchra\Pagination\Page::ofModel($this->client->send($request)->object(), \Synchra\Model\ChannelStream::class);
    }

    /**
     * Get Channel Streams Stats.
     *
     * `GET /api/2/channels/{channel_id}/streams-stats`
     *
     * Requires the `channel_stream:read` scope.
     *
     * @param ?\Synchra\Query\ChannelStreamsStatsQuery $query Optional filters.
     * @return list<\Synchra\Model\StreamStatsPeriod>
     */
    public function getChannelStreamsStats(string $channelId, \DateTimeImmutable $fromDate, ?\Synchra\Query\ChannelStreamsStatsQuery $query = null): array
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/streams-stats', ['channel_id' => $channelId]),
            query: [...($query?->toArray() ?? []), 'from_date' => $fromDate],
        );

        return \array_map(\Synchra\Model\StreamStatsPeriod::fromArray(...), $this->client->send($request)->objects());
    }
}
