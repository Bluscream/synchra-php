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
 * The `Patreon` endpoints.
 *
 * Reach this group with `$synchra->patreon()`.
 */
final class Patreon extends AbstractResource
{
    /**
     * Get Patreon Webhook Url.
     *
     * `GET /api/2/channels/{channel_id}/patreon/webhook-url`
     *
     * Requires the `channel_providers:write` scope.
     *
     * @param ?\Synchra\Query\PatreonWebhookUrlQuery $query Optional filters.
     */
    public function getPatreonWebhookUrl(string $channelId, ?\Synchra\Query\PatreonWebhookUrlQuery $query = null): \Synchra\Model\ConnectUrl
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/patreon/webhook-url', ['channel_id' => $channelId]),
            query: [...($query?->toArray() ?? [])],
        );

        return \Synchra\Model\ConnectUrl::fromArray($this->client->send($request)->object());
    }

    /**
     * Register Patreon Channel Provider.
     *
     * `POST /api/2/channels/{channel_id}/register-provider/patreon`
     *
     * Requires the `channel_providers:write` scope.
     *
     * @param \Synchra\Model\BodyRegisterPatreonChannelProviderApi2ChannelsChannelIdRegisterProviderPatreonPost $payload The request body.
     */
    public function registerPatreonChannelProvider(string $channelId, \Synchra\Model\BodyRegisterPatreonChannelProviderApi2ChannelsChannelIdRegisterProviderPatreonPost $payload): \Synchra\Model\ChannelProviderPublic
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/register-provider/patreon', ['channel_id' => $channelId]),
            body: $payload,
        );

        return \Synchra\Model\ChannelProviderPublic::fromArray($this->client->send($request)->object());
    }

    /**
     * Patreon Event.
     *
     * `POST /api/2/patreon/events/{channel_id}`
     *
     * @param ?\Synchra\Query\PatreonEventQuery $query Optional filters.
     */
    public function patreonEvent(string $channelId, ?\Synchra\Query\PatreonEventQuery $query = null): mixed
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/patreon/events/{channel_id}', ['channel_id' => $channelId]),
            query: [...($query?->toArray() ?? [])],
        );

        return $this->client->send($request)->data;
    }

    /**
     * Patreon Provider Event.
     *
     * `POST /api/2/patreon/events/{channel_id}/{provider_channel_id}`
     */
    public function patreonProviderEvent(string $channelId, string $providerChannelId): mixed
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/patreon/events/{channel_id}/{provider_channel_id}', ['channel_id' => $channelId, 'provider_channel_id' => $providerChannelId]),
        );

        return $this->client->send($request)->data;
    }
}
