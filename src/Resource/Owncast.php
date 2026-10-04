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
 * The `Owncast` endpoints.
 *
 * Reach this group with `$synchra->owncast()`.
 */
final class Owncast extends AbstractResource
{
    /**
     * Get Owncast Webhook Url.
     *
     * `GET /api/2/channels/{channel_id}/owncast/webhook-url`
     *
     * Requires the `channel_providers:write` scope.
     */
    public function getOwncastWebhookUrl(string $channelId, string $host): \Synchra\Model\ConnectUrl
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/owncast/webhook-url', ['channel_id' => $channelId]),
            query: ['host' => $host],
        );

        return \Synchra\Model\ConnectUrl::fromArray($this->client->send($request)->object());
    }

    /**
     * Register Owncast Channel Provider.
     *
     * `POST /api/2/channels/{channel_id}/register-provider/owncast`
     *
     * Requires the `channel_providers:write` scope.
     *
     * @param \Synchra\Model\BodyRegisterOwncastChannelProviderApi2ChannelsChannelIdRegisterProviderOwncastPost $payload The request body.
     */
    public function registerOwncastChannelProvider(string $channelId, \Synchra\Model\BodyRegisterOwncastChannelProviderApi2ChannelsChannelIdRegisterProviderOwncastPost $payload): \Synchra\Model\ChannelProviderPublic
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/register-provider/owncast', ['channel_id' => $channelId]),
            body: $payload,
        );

        return \Synchra\Model\ChannelProviderPublic::fromArray($this->client->send($request)->object());
    }

    /**
     * Owncast Event.
     *
     * `POST /api/2/owncast/events/{channel_id}/{provider_channel_id}/{webhook_token}`
     */
    public function owncastEvent(string $channelId, string $providerChannelId, string $webhookToken): mixed
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/owncast/events/{channel_id}/{provider_channel_id}/{webhook_token}', ['channel_id' => $channelId, 'provider_channel_id' => $providerChannelId, 'webhook_token' => $webhookToken]),
        );

        return $this->client->send($request)->data;
    }
}
