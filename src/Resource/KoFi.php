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
 * The `Ko-fi` endpoints.
 *
 * Reach this group with `$synchra->koFi()`.
 */
final class KoFi extends AbstractResource
{
    /**
     * Get Ko-Fi Webhook Url.
     *
     * `GET /api/2/channels/{channel_id}/kofi/webhook-url`
     *
     * Requires the `channel_providers:write` scope.
     *
     * @param ?\Synchra\Query\KoFiWebhookUrlQuery $query Optional filters.
     */
    public function getKoFiWebhookUrl(string $channelId, ?\Synchra\Query\KoFiWebhookUrlQuery $query = null): \Synchra\Model\ConnectUrl
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/kofi/webhook-url', ['channel_id' => $channelId]),
            query: [...($query?->toArray() ?? [])],
        );

        return \Synchra\Model\ConnectUrl::fromArray($this->client->send($request)->object());
    }

    /**
     * Register Ko-Fi Channel Provider.
     *
     * `POST /api/2/channels/{channel_id}/register-provider/kofi`
     *
     * Requires the `channel_providers:write` scope.
     *
     * @param \Synchra\Model\BodyRegisterKoFiChannelProviderApi2ChannelsChannelIdRegisterProviderKofiPost $payload The request body.
     */
    public function registerKoFiChannelProvider(string $channelId, \Synchra\Model\BodyRegisterKoFiChannelProviderApi2ChannelsChannelIdRegisterProviderKofiPost $payload): \Synchra\Model\ChannelProviderPublic
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/register-provider/kofi', ['channel_id' => $channelId]),
            body: $payload,
        );

        return \Synchra\Model\ChannelProviderPublic::fromArray($this->client->send($request)->object());
    }

    /**
     * Ko-Fi Event.
     *
     * `POST /api/2/kofi/events/{channel_id}`
     *
     * @param ?\Synchra\Query\KoFiEventQuery $query Optional filters.
     */
    public function koFiEvent(string $channelId, ?\Synchra\Query\KoFiEventQuery $query = null): mixed
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/kofi/events/{channel_id}', ['channel_id' => $channelId]),
            query: [...($query?->toArray() ?? [])],
        );

        return $this->client->send($request)->data;
    }

    /**
     * Ko-Fi Provider Event.
     *
     * `POST /api/2/kofi/events/{channel_id}/{provider_channel_id}`
     */
    public function koFiProviderEvent(string $channelId, string $providerChannelId): mixed
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/kofi/events/{channel_id}/{provider_channel_id}', ['channel_id' => $channelId, 'provider_channel_id' => $providerChannelId]),
        );

        return $this->client->send($request)->data;
    }
}
