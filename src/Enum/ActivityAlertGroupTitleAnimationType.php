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
 * Values the API accepts for `Entry Animation Type` / `Exit Animation Type`.
 */
enum ActivityAlertGroupTitleAnimationType: string
{
    case None = 'none';
    case Fade = 'fade';
    case SlideUp = 'slide_up';
    case SlideDown = 'slide_down';
    case SlideLeft = 'slide_left';
    case SlideRight = 'slide_right';
    case Pop = 'pop';
    case Bounce = 'bounce';
    case Flip = 'flip';
    case Zoom = 'zoom';
    case Spin = 'spin';
    case Drop = 'drop';
    case Swing = 'swing';
    case Blur = 'blur';
    case Glitch = 'glitch';
}
