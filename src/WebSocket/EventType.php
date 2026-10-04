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

namespace Synchra\WebSocket;

/**
 * Event types the realtime gateway can push.
 *
 * The `ok` acknowledgement and `error` frames are not listed here — they are answers to a
 * command rather than subscribable events; see Event::isAcknowledgement() and
 * Event::isError().
 */
enum EventType: string
{
    /**
     * Activity events. Subscribe with `channel_id`.
     */
    case Activity = 'activity';

    /**
     * Activity alert test events. Subscribe with `widget_id`.
     */
    case ActivityAlertTest = 'activity_alert_test';

    /**
     * Channel giveaway events. Subscribe with `giveaway_id`.
     */
    case ChannelGiveaway = 'channel_giveaway';

    /**
     * Channel giveaway entries events. Subscribe with `giveaway_id`.
     */
    case ChannelGiveawayEntries = 'channel_giveaway_entries';

    /**
     * Channel giveaways events. Subscribe with `channel_id`.
     */
    case ChannelGiveaways = 'channel_giveaways';

    /**
     * Channel provider events. Subscribe with `channel_id`.
     */
    case ChannelProvider = 'channel_provider';

    /**
     * Channel provider stream events. Subscribe with `channel_id`.
     */
    case ChannelProviderStream = 'channel_provider_stream';

    /**
     * Channel queue events. Subscribe with `channel_queue_id`.
     */
    case ChannelQueue = 'channel_queue';

    /**
     * Chat event events. Subscribe with `channel_id`.
     */
    case ChatEvent = 'chat_event';

    /**
     * Chat message events. Subscribe with `channel_id`.
     */
    case ChatMessage = 'chat_message';

    /**
     * Obs remote command events. Subscribe with `obs_remote_id`.
     */
    case ObsRemoteCommand = 'obs_remote_command';

    /**
     * Widget events. Subscribe with `widget_id`.
     */
    case Widget = 'widget';

    /**
     * Widget value events. Subscribe with `widget_id`, `channel_id`, `key`.
     */
    case WidgetValue = 'widget_value';
}
