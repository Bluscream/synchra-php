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
 * The `Channel Chat Filters` endpoints.
 *
 * Reach this group with `$synchra->channelChatFilters()`.
 */
final class ChannelChatFilters extends AbstractResource
{
    /**
     * Get Channel Filters.
     *
     * `GET /api/2/channels/{channel_id}/chat-filters`
     *
     * Requires the `chat_filter:read` scope.
     *
     * @param ?\Synchra\Query\ChannelFiltersQuery $query Optional filters.
     * @return \Synchra\Pagination\Page<\Synchra\Model\ChatFilterBase>
     */
    public function getChannelFilters(string $channelId, ?\Synchra\Query\ChannelFiltersQuery $query = null): \Synchra\Pagination\Page
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/chat-filters', ['channel_id' => $channelId]),
            query: [...($query?->toArray() ?? [])],
        );

        return \Synchra\Pagination\Page::ofModel($this->client->send($request)->object(), \Synchra\Model\ChatFilterBase::class);
    }

    /**
     * Create Channel Filter.
     *
     * `POST /api/2/channels/{channel_id}/chat-filters`
     *
     * Requires the `chat_filter:write` scope.
     *
     * @param \Synchra\Model\ChatFilterBannedTermsCreate|\Synchra\Model\ChatFilterCapsCreate|\Synchra\Model\ChatFilterEmoteCreate|\Synchra\Model\ChatFilterLinkCreate|\Synchra\Model\ChatFilterNonLatinCreate|\Synchra\Model\ChatFilterParagraphCreate|\Synchra\Model\ChatFilterSymbolCreate $payload The request body.
     */
    public function createChannelFilter(string $channelId, \Synchra\Model\ChatFilterBannedTermsCreate|\Synchra\Model\ChatFilterCapsCreate|\Synchra\Model\ChatFilterEmoteCreate|\Synchra\Model\ChatFilterLinkCreate|\Synchra\Model\ChatFilterNonLatinCreate|\Synchra\Model\ChatFilterParagraphCreate|\Synchra\Model\ChatFilterSymbolCreate $payload): \Synchra\Model\ChatFilterBannedTerms|\Synchra\Model\ChatFilterCaps|\Synchra\Model\ChatFilterEmote|\Synchra\Model\ChatFilterLink|\Synchra\Model\ChatFilterNonLatin|\Synchra\Model\ChatFilterParagraph|\Synchra\Model\ChatFilterSymbol
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/chat-filters', ['channel_id' => $channelId]),
            body: $payload,
        );

        return \Synchra\Model\Union\ChatFUnion::fromArray($this->client->send($request)->object());
    }

    /**
     * Delete Channel Filter.
     *
     * `DELETE /api/2/channels/{channel_id}/chat-filters/{filter_id}`
     *
     * Requires the `chat_filter:write` scope.
     */
    public function deleteChannelFilter(string $channelId, string $filterId): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'DELETE',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/chat-filters/{filter_id}', ['channel_id' => $channelId, 'filter_id' => $filterId]),
        );

        $this->client->send($request);
    }

    /**
     * Get Channel Filter.
     *
     * `GET /api/2/channels/{channel_id}/chat-filters/{filter_id}`
     *
     * Requires the `chat_filter:read` scope.
     */
    public function getChannelFilter(string $channelId, string $filterId): \Synchra\Model\ChatFilterBannedTerms|\Synchra\Model\ChatFilterCaps|\Synchra\Model\ChatFilterEmote|\Synchra\Model\ChatFilterLink|\Synchra\Model\ChatFilterNonLatin|\Synchra\Model\ChatFilterParagraph|\Synchra\Model\ChatFilterSymbol
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/chat-filters/{filter_id}', ['channel_id' => $channelId, 'filter_id' => $filterId]),
        );

        return \Synchra\Model\Union\ChatFUnion::fromArray($this->client->send($request)->object());
    }

    /**
     * Update Channel Filter.
     *
     * `PUT /api/2/channels/{channel_id}/chat-filters/{filter_id}`
     *
     * Requires the `chat_filter:write` scope.
     *
     * @param \Synchra\Model\ChatFilterBannedTermsUpdate|\Synchra\Model\ChatFilterCapsUpdate|\Synchra\Model\ChatFilterEmoteUpdate|\Synchra\Model\ChatFilterLinkUpdate|\Synchra\Model\ChatFilterNonLatinUpdate|\Synchra\Model\ChatFilterParagraphUpdate|\Synchra\Model\ChatFilterSymbolUpdate $payload The request body.
     */
    public function updateChannelFilter(string $channelId, string $filterId, \Synchra\Model\ChatFilterBannedTermsUpdate|\Synchra\Model\ChatFilterCapsUpdate|\Synchra\Model\ChatFilterEmoteUpdate|\Synchra\Model\ChatFilterLinkUpdate|\Synchra\Model\ChatFilterNonLatinUpdate|\Synchra\Model\ChatFilterParagraphUpdate|\Synchra\Model\ChatFilterSymbolUpdate $payload): \Synchra\Model\ChatFilterBannedTerms|\Synchra\Model\ChatFilterCaps|\Synchra\Model\ChatFilterEmote|\Synchra\Model\ChatFilterLink|\Synchra\Model\ChatFilterNonLatin|\Synchra\Model\ChatFilterParagraph|\Synchra\Model\ChatFilterSymbol
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'PUT',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/chat-filters/{filter_id}', ['channel_id' => $channelId, 'filter_id' => $filterId]),
            body: $payload,
        );

        return \Synchra\Model\Union\ChatFUnion::fromArray($this->client->send($request)->object());
    }

    /**
     * Test Banned Terms.
     *
     * `POST /api/2/channels/{channel_id}/chat-filters/{filter_id}/banned-terms/test`
     *
     * Requires the `chat_filter:write` scope.
     *
     * @param \Synchra\Model\BannedTermsTest $payload The request body.
     */
    public function testBannedTerms(string $channelId, string $filterId, \Synchra\Model\BannedTermsTest $payload): \Synchra\Model\FilterMatchResult
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/chat-filters/{filter_id}/banned-terms/test', ['channel_id' => $channelId, 'filter_id' => $filterId]),
            body: $payload,
        );

        return \Synchra\Model\FilterMatchResult::fromArray($this->client->send($request)->object());
    }
}
