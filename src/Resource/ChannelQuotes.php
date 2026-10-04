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
 * The `Channel Quotes` endpoints.
 *
 * Reach this group with `$synchra->channelQuotes()`.
 */
final class ChannelQuotes extends AbstractResource
{
    /**
     * Get Channel Quotes.
     *
     * `GET /api/2/channels/{channel_id}/quotes`
     *
     * Requires the `channel_quote:read` scope.
     *
     * @param ?\Synchra\Query\ChannelQuotesQuery $query Optional filters.
     * @return \Synchra\Pagination\Page<\Synchra\Model\ChannelQuote>
     */
    public function getChannelQuotes(string $channelId, ?\Synchra\Query\ChannelQuotesQuery $query = null): \Synchra\Pagination\Page
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/quotes', ['channel_id' => $channelId]),
            query: [...($query?->toArray() ?? [])],
        );

        return \Synchra\Pagination\Page::ofModel($this->client->send($request)->object(), \Synchra\Model\ChannelQuote::class);
    }

    /**
     * Create Channel Quote.
     *
     * `POST /api/2/channels/{channel_id}/quotes`
     *
     * Requires the `channel_quote:write` scope.
     *
     * @param \Synchra\Model\ChannelQuoteCreate $payload The request body.
     */
    public function createChannelQuote(string $channelId, \Synchra\Model\ChannelQuoteCreate $payload): \Synchra\Model\ChannelQuote
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/quotes', ['channel_id' => $channelId]),
            body: $payload,
        );

        return \Synchra\Model\ChannelQuote::fromArray($this->client->send($request)->object());
    }

    /**
     * Get Channel Quote By Number.
     *
     * `GET /api/2/channels/{channel_id}/quotes/number/{number}`
     *
     * Requires the `channel_quote:read` scope.
     */
    public function getChannelQuoteByNumber(string $channelId, int $number): \Synchra\Model\ChannelQuote
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/quotes/number/{number}', ['channel_id' => $channelId, 'number' => $number]),
        );

        return \Synchra\Model\ChannelQuote::fromArray($this->client->send($request)->object());
    }

    /**
     * Delete Channel Quote.
     *
     * `DELETE /api/2/channels/{channel_id}/quotes/{quote_id}`
     *
     * Requires the `channel_quote:write` scope.
     */
    public function deleteChannelQuote(string $channelId, string $quoteId): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'DELETE',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/quotes/{quote_id}', ['channel_id' => $channelId, 'quote_id' => $quoteId]),
        );

        $this->client->send($request);
    }

    /**
     * Get Channel Quote.
     *
     * `GET /api/2/channels/{channel_id}/quotes/{quote_id}`
     *
     * Requires the `channel_quote:read` scope.
     */
    public function getChannelQuote(string $channelId, string $quoteId): \Synchra\Model\ChannelQuote
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/quotes/{quote_id}', ['channel_id' => $channelId, 'quote_id' => $quoteId]),
        );

        return \Synchra\Model\ChannelQuote::fromArray($this->client->send($request)->object());
    }

    /**
     * Update Channel Quote.
     *
     * `PUT /api/2/channels/{channel_id}/quotes/{quote_id}`
     *
     * Requires the `channel_quote:write` scope.
     *
     * @param \Synchra\Model\ChannelQuoteUpdate $payload The request body.
     */
    public function updateChannelQuote(string $channelId, string $quoteId, \Synchra\Model\ChannelQuoteUpdate $payload): \Synchra\Model\ChannelQuote
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'PUT',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/quotes/{quote_id}', ['channel_id' => $channelId, 'quote_id' => $quoteId]),
            body: $payload,
        );

        return \Synchra\Model\ChannelQuote::fromArray($this->client->send($request)->object());
    }
}
