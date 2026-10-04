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
 * The `OBS Remote` endpoints.
 *
 * Reach this group with `$synchra->obsRemote()`.
 */
final class ObsRemote extends AbstractResource
{
    /**
     * Create Obs Remote Command Route.
     *
     * `POST /api/2/channels/{channel_id}/obs-remotes/{obs_remote_id}/commands`
     *
     * @param \Synchra\Model\ObsRemoteNoDataCommandCreate|\Synchra\Model\ObsRemoteNamedCommandCreate|\Synchra\Model\ObsRemoteSetInputMuteCommandCreate|\Synchra\Model\ObsRemoteSetInputVolumeCommandCreate|\Synchra\Model\ObsRemoteSetSceneItemEnabledCommandCreate $payload The request body.
     */
    public function createObsRemoteCommand(string $channelId, string $obsRemoteId, \Synchra\Model\ObsRemoteNoDataCommandCreate|\Synchra\Model\ObsRemoteNamedCommandCreate|\Synchra\Model\ObsRemoteSetInputMuteCommandCreate|\Synchra\Model\ObsRemoteSetInputVolumeCommandCreate|\Synchra\Model\ObsRemoteSetSceneItemEnabledCommandCreate $payload): \Synchra\Model\ObsRemoteCommand
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/obs-remotes/{obs_remote_id}/commands', ['channel_id' => $channelId, 'obs_remote_id' => $obsRemoteId]),
            body: $payload,
        );

        return \Synchra\Model\ObsRemoteCommand::fromArray($this->client->send($request)->object());
    }

    /**
     * Register Obs Remote Channel Provider.
     *
     * `POST /api/2/channels/{channel_id}/register-provider/obs_remote`
     *
     * Requires the `channel_providers:write` scope.
     *
     * @param \Synchra\Model\BodyRegisterObsRemoteChannelProviderApi2ChannelsChannelIdRegisterProviderObsRemotePost $payload The request body.
     */
    public function registerObsRemoteChannelProvider(string $channelId, \Synchra\Model\BodyRegisterObsRemoteChannelProviderApi2ChannelsChannelIdRegisterProviderObsRemotePost $payload): \Synchra\Model\ChannelProviderPublic
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/register-provider/obs_remote', ['channel_id' => $channelId]),
            body: $payload,
        );

        return \Synchra\Model\ChannelProviderPublic::fromArray($this->client->send($request)->object());
    }

    /**
     * Update Obs Remote State Route.
     *
     * `POST /api/2/obs-remotes/{obs_remote_id}/state`
     *
     * @param \Synchra\Model\ObsRemoteStateUpdate $payload The request body.
     */
    public function updateObsRemoteState(string $obsRemoteId, \Synchra\Model\ObsRemoteStateUpdate $payload): \Synchra\Model\ChannelProviderPublic
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/obs-remotes/{obs_remote_id}/state', ['obs_remote_id' => $obsRemoteId]),
            body: $payload,
        );

        return \Synchra\Model\ChannelProviderPublic::fromArray($this->client->send($request)->object());
    }

    /**
     * Update Obs Remote Heartbeat Route.
     *
     * `PATCH /api/2/obs-remotes/{obs_remote_id}/state/heartbeat`
     */
    public function updateObsRemoteHeartbeat(string $obsRemoteId): \Synchra\Model\ChannelProviderPublic
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'PATCH',
            path: \Synchra\Http\Path::expand('/obs-remotes/{obs_remote_id}/state/heartbeat', ['obs_remote_id' => $obsRemoteId]),
        );

        return \Synchra\Model\ChannelProviderPublic::fromArray($this->client->send($request)->object());
    }
}
