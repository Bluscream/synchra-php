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
 * The `Channel Gambling` endpoints.
 *
 * Reach this group with `$synchra->channelGambling()`.
 */
final class ChannelGambling extends AbstractResource
{
    /**
     * Get Roulette Settings.
     *
     * `GET /api/2/channels/{channel_id}/roulette-settings`
     *
     * Requires the `channel_point_settings:read` scope.
     */
    public function getRouletteSettings(string $channelId): \Synchra\Model\RouletteSettings
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/roulette-settings', ['channel_id' => $channelId]),
        );

        return \Synchra\Model\RouletteSettings::fromArray($this->client->send($request)->object());
    }

    /**
     * Update Roulette Settings.
     *
     * `PUT /api/2/channels/{channel_id}/roulette-settings`
     *
     * Requires the `channel_point_settings:write` scope.
     *
     * @param \Synchra\Model\RouletteSettingsUpdate $payload The request body.
     */
    public function updateRouletteSettings(string $channelId, \Synchra\Model\RouletteSettingsUpdate $payload): \Synchra\Model\RouletteSettings
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'PUT',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/roulette-settings', ['channel_id' => $channelId]),
            body: $payload,
        );

        return \Synchra\Model\RouletteSettings::fromArray($this->client->send($request)->object());
    }

    /**
     * Get Slots Settings.
     *
     * `GET /api/2/channels/{channel_id}/slots-settings`
     *
     * Requires the `channel_point_settings:read` scope.
     */
    public function getSlotsSettings(string $channelId): \Synchra\Model\SlotsSettings
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/slots-settings', ['channel_id' => $channelId]),
        );

        return \Synchra\Model\SlotsSettings::fromArray($this->client->send($request)->object());
    }

    /**
     * Update Slots Settings.
     *
     * `PUT /api/2/channels/{channel_id}/slots-settings`
     *
     * Requires the `channel_point_settings:write` scope.
     *
     * @param \Synchra\Model\SlotsSettingsUpdate $payload The request body.
     */
    public function updateSlotsSettings(string $channelId, \Synchra\Model\SlotsSettingsUpdate $payload): \Synchra\Model\SlotsSettings
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'PUT',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/slots-settings', ['channel_id' => $channelId]),
            body: $payload,
        );

        return \Synchra\Model\SlotsSettings::fromArray($this->client->send($request)->object());
    }
}
