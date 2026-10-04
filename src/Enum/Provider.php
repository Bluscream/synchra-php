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
 * Values the API accepts for `Provider`.
 */
enum Provider: string
{
    case Twitch = 'twitch';
    case Discord = 'discord';
    case Youtube = 'youtube';
    case Spotify = 'spotify';
    case Tiktok = 'tiktok';
    case X = 'x';
    case Rumble = 'rumble';
    case Kick = 'kick';
    case N7tv = '7tv';
    case Betterttv = 'betterttv';
    case Frankerfacez = 'frankerfacez';
    case Streamelements = 'streamelements';
    case Streamlabs = 'streamlabs';
    case Ttsmonster = 'ttsmonster';
    case Elevenlabs = 'elevenlabs';
    case AmazonPolly = 'amazon_polly';
    case ObsRemote = 'obs_remote';
    case Kofi = 'kofi';
    case Fourthwall = 'fourthwall';
    case Patreon = 'patreon';
    case Owncast = 'owncast';
}
