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
 * Values the API accepts for `Feature`.
 */
enum Feature: string
{
    case ChannelViewerChatLogs = 'channel_viewer_chat_logs';
    case ChannelViewerExtraStats = 'channel_viewer_extra_stats';
    case CustomBotName = 'custom_bot_name';
    case Ingest = 'ingest';
}
