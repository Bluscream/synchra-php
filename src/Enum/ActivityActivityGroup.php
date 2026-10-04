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
enum ActivityActivityGroup: string
{
    case Subscription = 'subscription';
    case SubscriptionGift = 'subscription_gift';
    case Donation = 'donation';
    case VirtualCurrency = 'virtual_currency';
    case Follow = 'follow';
    case Raid = 'raid';
    case Redeem = 'redeem';
    case Like = 'like';
}
