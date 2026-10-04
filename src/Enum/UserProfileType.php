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
 * Values the API accepts for `UserProfileType`.
 */
enum UserProfileType: string
{
    case Dashboard = 'dashboard';
    case Chat = 'chat';
    case ActivityFeed = 'activity-feed';
    case Controls = 'controls';
}
