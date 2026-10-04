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
 * Values the API accepts for ActivityFeedNotificationSoundTone.
 */
enum ActivityFeedNotificationSoundTone: string
{
    case Chime = 'chime';
    case Pop = 'pop';
    case Bell = 'bell';
    case Custom = 'custom';
}
