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
 * Values the API accepts for `TAccessLevel`.
 */
enum TAccessLevel: int
{
    case N0 = 0;
    case N1 = 1;
    case N2 = 2;
    case N7 = 7;
    case N8 = 8;
    case N100 = 100;
    case N200 = 200;
    case N500 = 500;
    case N1000 = 1000;
}
