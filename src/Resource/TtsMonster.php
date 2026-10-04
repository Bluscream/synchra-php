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
 * The `TTSMonster` endpoints.
 *
 * Reach this group with `$synchra->ttsMonster()`.
 */
final class TtsMonster extends AbstractResource
{
    /**
     * Register Ttsmonster Channel Provider.
     *
     * `POST /api/2/channels/{channel_id}/register-provider/ttsmonster`
     *
     * Requires the `channel_providers:write` scope.
     *
     * @param \Synchra\Model\BodyRegisterTTSMonsterChannelProviderApi2ChannelsChannelIdRegisterProviderTtsmonsterPost $payload The request body.
     */
    public function registerTtsmonsterChannelProvider(string $channelId, \Synchra\Model\BodyRegisterTTSMonsterChannelProviderApi2ChannelsChannelIdRegisterProviderTtsmonsterPost $payload): \Synchra\Model\ChannelProviderPublic
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/register-provider/ttsmonster', ['channel_id' => $channelId]),
            body: $payload,
        );

        return \Synchra\Model\ChannelProviderPublic::fromArray($this->client->send($request)->object());
    }
}
