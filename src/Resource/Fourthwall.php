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
 * The `Fourthwall` endpoints.
 *
 * Reach this group with `$synchra->fourthwall()`.
 */
final class Fourthwall extends AbstractResource
{
    /**
     * Get Fourthwall Webhook Url.
     *
     * `GET /api/2/channels/{channel_id}/fourthwall/webhook-url`
     *
     * Requires the `channel_providers:write` scope.
     *
     * @param ?\Synchra\Query\FourthwallWebhookUrlQuery $query Optional filters.
     */
    public function getFourthwallWebhookUrl(string $channelId, ?\Synchra\Query\FourthwallWebhookUrlQuery $query = null): \Synchra\Model\ConnectUrl
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/fourthwall/webhook-url', ['channel_id' => $channelId]),
            query: [...($query?->toArray() ?? [])],
        );

        return \Synchra\Model\ConnectUrl::fromArray($this->client->send($request)->object());
    }

    /**
     * Register Fourthwall Channel Provider.
     *
     * `POST /api/2/channels/{channel_id}/register-provider/fourthwall`
     *
     * Requires the `channel_providers:write` scope.
     *
     * @param \Synchra\Model\BodyRegisterFourthwallChannelProviderApi2ChannelsChannelIdRegisterProviderFourthwallPost $payload The request body.
     */
    public function registerFourthwallChannelProvider(string $channelId, \Synchra\Model\BodyRegisterFourthwallChannelProviderApi2ChannelsChannelIdRegisterProviderFourthwallPost $payload): \Synchra\Model\ChannelProviderPublic
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/register-provider/fourthwall', ['channel_id' => $channelId]),
            body: $payload,
        );

        return \Synchra\Model\ChannelProviderPublic::fromArray($this->client->send($request)->object());
    }

    /**
     * Fourthwall Event.
     *
     * `POST /api/2/fourthwall/events/{channel_id}`
     *
     * @param ?\Synchra\Query\FourthwallEventQuery $query Optional filters.
     */
    public function fourthwallEvent(string $channelId, ?\Synchra\Query\FourthwallEventQuery $query = null): mixed
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/fourthwall/events/{channel_id}', ['channel_id' => $channelId]),
            query: [...($query?->toArray() ?? [])],
        );

        return $this->client->send($request)->data;
    }

    /**
     * Fourthwall Provider Event.
     *
     * `POST /api/2/fourthwall/events/{channel_id}/{provider_channel_id}`
     */
    public function fourthwallProviderEvent(string $channelId, string $providerChannelId): mixed
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/fourthwall/events/{channel_id}/{provider_channel_id}', ['channel_id' => $channelId, 'provider_channel_id' => $providerChannelId]),
        );

        return $this->client->send($request)->data;
    }
}
