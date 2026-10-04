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
 * The `Channel Point Settings` endpoints.
 *
 * Reach this group with `$synchra->channelPointSettings()`.
 */
final class ChannelPointSettings extends AbstractResource
{
    /**
     * Get Channel Point Settings.
     *
     * `GET /api/2/channels/{channel_id}/point-settings`
     *
     * Requires the `channel_point_settings:read` scope.
     */
    public function getChannelPointSettings(string $channelId): \Synchra\Model\ChannelPointSettings
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/point-settings', ['channel_id' => $channelId]),
        );

        return \Synchra\Model\ChannelPointSettings::fromArray($this->client->send($request)->object());
    }

    /**
     * Update Channel Point Settings.
     *
     * `PUT /api/2/channels/{channel_id}/point-settings`
     *
     * Requires the `channel_point_settings:write` scope.
     *
     * @param \Synchra\Model\ChannelPointSettingsUpdate $payload The request body.
     */
    public function updateChannelPointSettings(string $channelId, \Synchra\Model\ChannelPointSettingsUpdate $payload): \Synchra\Model\ChannelPointSettings
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'PUT',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/point-settings', ['channel_id' => $channelId]),
            body: $payload,
        );

        return \Synchra\Model\ChannelPointSettings::fromArray($this->client->send($request)->object());
    }
}
