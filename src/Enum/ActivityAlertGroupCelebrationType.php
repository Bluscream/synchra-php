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
 * Values the API accepts for ActivityAlertGroup.
 */
enum ActivityAlertGroupCelebrationType: string
{
    case Confetti = 'confetti';
    case Fireworks = 'fireworks';
    case Stars = 'stars';
    case Sparkles = 'sparkles';
    case Hearts = 'hearts';
    case Snow = 'snow';
    case Christmas = 'christmas';
    case Halloween = 'halloween';
    case Diwali = 'diwali';
    case LunarNewYear = 'lunarNewYear';
    case CherryBlossom = 'cherryBlossom';
    case StPatricks = 'stPatricks';
}
