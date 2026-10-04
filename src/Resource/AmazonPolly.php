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
 * The `Amazon Polly` endpoints.
 *
 * Reach this group with `$synchra->amazonPolly()`.
 */
final class AmazonPolly extends AbstractResource
{
    /**
     * Register Amazon Polly Channel Provider.
     *
     * `POST /api/2/channels/{channel_id}/register-provider/amazon_polly`
     *
     * Requires the `channel_providers:write` scope.
     *
     * @param \Synchra\Model\BodyRegisterAmazonPollyChannelProviderApi2ChannelsChannelIdRegisterProviderAmazonPollyPost $payload The request body.
     */
    public function registerAmazonPollyChannelProvider(string $channelId, \Synchra\Model\BodyRegisterAmazonPollyChannelProviderApi2ChannelsChannelIdRegisterProviderAmazonPollyPost $payload): \Synchra\Model\ChannelProviderPublic
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/register-provider/amazon_polly', ['channel_id' => $channelId]),
            body: $payload,
        );

        return \Synchra\Model\ChannelProviderPublic::fromArray($this->client->send($request)->object());
    }
}
