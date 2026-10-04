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

namespace Synchra\Enum;

/**
 * Values the API accepts for `Command`.
 */
enum ObsRemoteNoDataCommandName: string
{
    case RefreshState = 'refresh_state';
    case StartStreaming = 'start_streaming';
    case StopStreaming = 'stop_streaming';
    case StartRecording = 'start_recording';
    case StopRecording = 'stop_recording';
    case PauseRecording = 'pause_recording';
    case UnpauseRecording = 'unpause_recording';
}
