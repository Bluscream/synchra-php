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
 * Values the API accepts for Activity.
 */
enum ActivityContributionGroup: string
{
    case CurrencyAmount = 'currency_amount';
    case Follows = 'follows';
    case KickSubs = 'kick_subs';
    case Redeems = 'redeems';
    case RumbleSubs = 'rumble_subs';
    case TiktokSuperfans = 'tiktok_superfans';
    case TwitchSubs = 'twitch_subs';
    case VirtualCurrency = 'virtual_currency';
    case YoutubeMemberships = 'youtube_memberships';
}
