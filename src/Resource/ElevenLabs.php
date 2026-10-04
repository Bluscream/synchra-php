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
 * The `ElevenLabs` endpoints.
 *
 * Reach this group with `$synchra->elevenLabs()`.
 */
final class ElevenLabs extends AbstractResource
{
    /**
     * Register Elevenlabs Channel Provider.
     *
     * `POST /api/2/channels/{channel_id}/register-provider/elevenlabs`
     *
     * Requires the `channel_providers:write` scope.
     *
     * @param \Synchra\Model\BodyRegisterElevenLabsChannelProviderApi2ChannelsChannelIdRegisterProviderElevenlabsPost $payload The request body.
     */
    public function registerElevenlabsChannelProvider(string $channelId, \Synchra\Model\BodyRegisterElevenLabsChannelProviderApi2ChannelsChannelIdRegisterProviderElevenlabsPost $payload): \Synchra\Model\ChannelProviderPublic
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/register-provider/elevenlabs', ['channel_id' => $channelId]),
            body: $payload,
        );

        return \Synchra\Model\ChannelProviderPublic::fromArray($this->client->send($request)->object());
    }
}
