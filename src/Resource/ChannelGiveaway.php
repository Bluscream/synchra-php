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
 * The `Channel Giveaway` endpoints.
 *
 * Reach this group with `$synchra->channelGiveaway()`.
 */
final class ChannelGiveaway extends AbstractResource
{
    /**
     * Delete Giveaway Entry.
     *
     * `DELETE /api/2/channels/{channel_id}/giveaway-entries/{giveaway_entry_id}`
     *
     * Requires the `channel_giveaway:write` scope.
     */
    public function deleteGiveawayEntry(string $channelId, string $giveawayEntryId): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'DELETE',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/giveaway-entries/{giveaway_entry_id}', ['channel_id' => $channelId, 'giveaway_entry_id' => $giveawayEntryId]),
        );

        $this->client->send($request);
    }

    /**
     * Get Giveaways.
     *
     * `GET /api/2/channels/{channel_id}/giveaways`
     *
     * Requires the `channel_giveaway:read` scope.
     *
     * @param ?\Synchra\Query\GiveawaysQuery $query Optional filters.
     * @return \Synchra\Pagination\Page<\Synchra\Model\Giveaway>
     */
    public function getGiveaways(string $channelId, ?\Synchra\Query\GiveawaysQuery $query = null): \Synchra\Pagination\Page
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/giveaways', ['channel_id' => $channelId]),
            query: [...($query?->toArray() ?? [])],
        );

        return \Synchra\Pagination\Page::ofModel($this->client->send($request)->object(), \Synchra\Model\Giveaway::class);
    }

    /**
     * Create Giveaway.
     *
     * `POST /api/2/channels/{channel_id}/giveaways`
     *
     * Requires the `channel_giveaway:write` scope.
     *
     * @param \Synchra\Model\GiveawayCreate $payload The request body.
     */
    public function createGiveaway(string $channelId, \Synchra\Model\GiveawayCreate $payload): \Synchra\Model\Giveaway
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/giveaways', ['channel_id' => $channelId]),
            body: $payload,
        );

        return \Synchra\Model\Giveaway::fromArray($this->client->send($request)->object());
    }

    /**
     * Delete Giveaway.
     *
     * `DELETE /api/2/channels/{channel_id}/giveaways/{giveaway_id}`
     *
     * Requires the `channel_giveaway:write` scope.
     */
    public function deleteGiveaway(string $channelId, string $giveawayId): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'DELETE',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/giveaways/{giveaway_id}', ['channel_id' => $channelId, 'giveaway_id' => $giveawayId]),
        );

        $this->client->send($request);
    }

    /**
     * Get Giveaway.
     *
     * `GET /api/2/channels/{channel_id}/giveaways/{giveaway_id}`
     *
     * Requires the `channel_giveaway:read` scope.
     */
    public function getGiveaway(string $channelId, string $giveawayId): \Synchra\Model\Giveaway
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/giveaways/{giveaway_id}', ['channel_id' => $channelId, 'giveaway_id' => $giveawayId]),
        );

        return \Synchra\Model\Giveaway::fromArray($this->client->send($request)->object());
    }

    /**
     * Update Giveaway.
     *
     * `PUT /api/2/channels/{channel_id}/giveaways/{giveaway_id}`
     *
     * Requires the `channel_giveaway:write` scope.
     *
     * @param \Synchra\Model\GiveawayUpdate $payload The request body.
     */
    public function updateGiveaway(string $channelId, string $giveawayId, \Synchra\Model\GiveawayUpdate $payload): \Synchra\Model\Giveaway
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'PUT',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/giveaways/{giveaway_id}', ['channel_id' => $channelId, 'giveaway_id' => $giveawayId]),
            body: $payload,
        );

        return \Synchra\Model\Giveaway::fromArray($this->client->send($request)->object());
    }

    /**
     * Get Giveaway Entries.
     *
     * `GET /api/2/channels/{channel_id}/giveaways/{giveaway_id}/entries`
     *
     * Requires the `channel_giveaway:read` scope.
     *
     * @param ?\Synchra\Query\GiveawayEntriesQuery $query Optional filters.
     * @return \Synchra\Pagination\Page<\Synchra\Model\GiveawayEntry>
     */
    public function getGiveawayEntries(string $channelId, string $giveawayId, ?\Synchra\Query\GiveawayEntriesQuery $query = null): \Synchra\Pagination\Page
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/giveaways/{giveaway_id}/entries', ['channel_id' => $channelId, 'giveaway_id' => $giveawayId]),
            query: [...($query?->toArray() ?? [])],
        );

        return \Synchra\Pagination\Page::ofModel($this->client->send($request)->object(), \Synchra\Model\GiveawayEntry::class);
    }

    /**
     * Pick Giveaway Winner.
     *
     * `POST /api/2/channels/{channel_id}/giveaways/{giveaway_id}/pick-winner`
     *
     * Requires the `channel_giveaway:write` scope.
     *
     * @param ?\Synchra\Model\GiveawayWinnerPick $payload The request body.
     */
    public function pickGiveawayWinner(string $channelId, string $giveawayId, ?\Synchra\Model\GiveawayWinnerPick $payload = null): \Synchra\Model\Giveaway
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/giveaways/{giveaway_id}/pick-winner', ['channel_id' => $channelId, 'giveaway_id' => $giveawayId]),
            body: $payload,
        );

        return \Synchra\Model\Giveaway::fromArray($this->client->send($request)->object());
    }
}
