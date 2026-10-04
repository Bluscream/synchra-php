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
 * The `Channel Provider` endpoints.
 *
 * Reach this group with `$synchra->channelProvider()`.
 */
final class ChannelProvider extends AbstractResource
{
    /**
     * Get Channel Provider Streams Route.
     *
     * `GET /api/2/channels/{channel_id}/provider-streams`
     *
     * @param ?\Synchra\Query\ChannelProviderStreamsQuery $query Optional filters.
     * @return \Synchra\Pagination\Page<\Synchra\Model\ChannelProviderStream>
     */
    public function getChannelProviderStreams(string $channelId, ?\Synchra\Query\ChannelProviderStreamsQuery $query = null): \Synchra\Pagination\Page
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/provider-streams', ['channel_id' => $channelId]),
            query: [...($query?->toArray() ?? [])],
        );

        return \Synchra\Pagination\Page::ofModel($this->client->send($request)->object(), \Synchra\Model\ChannelProviderStream::class);
    }

    /**
     * Get Channel Providers.
     *
     * `GET /api/2/channels/{channel_id}/providers`
     *
     * @return list<\Synchra\Model\ChannelProviderPublic>
     */
    public function getChannelProviders(string $channelId): array
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/providers', ['channel_id' => $channelId]),
        );

        return \array_map(\Synchra\Model\ChannelProviderPublic::fromArray(...), $this->client->send($request)->objects());
    }

    /**
     * Delete Channel Provider.
     *
     * `DELETE /api/2/channels/{channel_id}/providers/{channel_provider_id}`
     *
     * Requires the `channel_providers:write` scope.
     */
    public function deleteChannelProvider(string $channelId, string $channelProviderId): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'DELETE',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/providers/{channel_provider_id}', ['channel_id' => $channelId, 'channel_provider_id' => $channelProviderId]),
        );

        $this->client->send($request);
    }

    /**
     * Get Channel Provider Route.
     *
     * `GET /api/2/channels/{channel_id}/providers/{channel_provider_id}`
     *
     * Requires the `channel_providers:read` scope.
     */
    public function getChannelProvider(string $channelId, string $channelProviderId): \Synchra\Model\ChannelProviderPublic
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/providers/{channel_provider_id}', ['channel_id' => $channelId, 'channel_provider_id' => $channelProviderId]),
        );

        return \Synchra\Model\ChannelProviderPublic::fromArray($this->client->send($request)->object());
    }

    /**
     * Update Channel Provider.
     *
     * `PATCH /api/2/channels/{channel_id}/providers/{channel_provider_id}`
     *
     * Requires the `channel_providers:write` scope.
     *
     * @param \Synchra\Model\ChannelProviderUpdate $payload The request body.
     */
    public function updateChannelProvider(string $channelId, string $channelProviderId, \Synchra\Model\ChannelProviderUpdate $payload): \Synchra\Model\ChannelProviderPublic
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'PATCH',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/providers/{channel_provider_id}', ['channel_id' => $channelId, 'channel_provider_id' => $channelProviderId]),
            body: $payload,
        );

        return \Synchra\Model\ChannelProviderPublic::fromArray($this->client->send($request)->object());
    }

    /**
     * Disconnect Channel Provider Bot.
     *
     * `DELETE /api/2/channels/{channel_id}/providers/{channel_provider_id}/bot`
     *
     * Requires the `channel_providers:write` scope.
     */
    public function disconnectChannelProviderBot(string $channelId, string $channelProviderId): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'DELETE',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/providers/{channel_provider_id}/bot', ['channel_id' => $channelId, 'channel_provider_id' => $channelProviderId]),
        );

        $this->client->send($request);
    }

    /**
     * Check Channel Provider Live Status.
     *
     * `POST /api/2/channels/{channel_id}/providers/{channel_provider_id}/check-live`
     *
     * Requires the `channel_providers:write` scope.
     */
    public function checkChannelProviderLiveStatus(string $channelId, string $channelProviderId): mixed
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/providers/{channel_provider_id}/check-live', ['channel_id' => $channelId, 'channel_provider_id' => $channelProviderId]),
        );

        return $this->client->send($request)->data;
    }

    /**
     * Start Commercial.
     *
     * `POST /api/2/channels/{channel_id}/providers/{channel_provider_id}/run-commercial`
     *
     * Requires the `channel_providers:write` scope.
     *
     * @param ?\Synchra\Model\BodyStartCommercialApi2ChannelsChannelIdProvidersChannelProviderIdRunCommercialPost $payload The request body.
     */
    public function startCommercial(string $channelId, string $channelProviderId, ?\Synchra\Model\BodyStartCommercialApi2ChannelsChannelIdProvidersChannelProviderIdRunCommercialPost $payload = null): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/providers/{channel_provider_id}/run-commercial', ['channel_id' => $channelId, 'channel_provider_id' => $channelProviderId]),
            body: $payload,
        );

        $this->client->send($request);
    }

    /**
     * Update Channel Provider.
     *
     * `PUT /api/2/channels/{channel_id}/providers/{channel_provider_id}/stream`
     *
     * Requires the `channel_providers:write` scope.
     *
     * @param \Synchra\Model\ChannelProviderStreamMetadataUpdate $payload The request body.
     */
    public function updateStream(string $channelId, string $channelProviderId, \Synchra\Model\ChannelProviderStreamMetadataUpdate $payload): \Synchra\Model\ChannelProviderPublic
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'PUT',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/providers/{channel_provider_id}/stream', ['channel_id' => $channelId, 'channel_provider_id' => $channelProviderId]),
            body: $payload,
        );

        return \Synchra\Model\ChannelProviderPublic::fromArray($this->client->send($request)->object());
    }

    /**
     * Get Stream Categories.
     *
     * `GET /api/2/stream-categories`
     *
     * @param ?\Synchra\Query\StreamCategoriesQuery $filters Optional filters.
     * @return \Synchra\Pagination\Page<\Synchra\Model\StreamCategory>
     */
    public function getStreamCategories(\Synchra\Enum\Provider $provider, string $query, ?\Synchra\Query\StreamCategoriesQuery $filters = null): \Synchra\Pagination\Page
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: '/stream-categories',
            query: [...($filters?->toArray() ?? []), 'provider' => $provider, 'query' => $query],
        );

        return \Synchra\Pagination\Page::ofModel($this->client->send($request)->object(), \Synchra\Model\StreamCategory::class);
    }
}
