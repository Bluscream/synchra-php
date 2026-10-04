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
 * Values the API accepts for `Status`.
 */
enum ChatEventStatus: string
{
    case Open = 'open';
    case Locked = 'locked';
    case Completed = 'completed';
    case Terminated = 'terminated';
    case Archived = 'archived';
    case Unknown = 'unknown';
}
