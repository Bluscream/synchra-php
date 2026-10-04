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
 * Values the API accepts for `LimitKey`.
 */
enum LimitKey: string
{
    case ChannelLinks = 'channel_links';
    case ChannelWidgets = 'channel_widgets';
    case ChannelTimers = 'channel_timers';
    case ChannelFilters = 'channel_filters';
    case ChannelCommands = 'channel_commands';
    case ObsRemotes = 'obs_remotes';
    case FileStorageBytes = 'file_storage_bytes';
    case KvStorageBytes = 'kv_storage_bytes';
    case ChannelLiveNotifications = 'channel_live_notifications';
}
