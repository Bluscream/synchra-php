<?php

declare(strict_types=1);

/*
 * Who am I, and what channels can this token see?
 *
 *   SYNCHRA_TOKEN=… php examples/01-list-channels.php
 */

require __DIR__ . '/../vendor/autoload.php';

use Synchra\Exception\SynchraException;
use Synchra\Synchra;

$synchra = Synchra::fromEnvironment();

try {
    $me = $synchra->user()->userInfo();

    \printf("Signed in as %s (%s)\n\n", $me->display_name, $me->username);

    $channels = $synchra->channel()->getChannels();

    if (\count($channels) === 0) {
        echo "This token can see no channels.\n";

        exit(0);
    }

    foreach ($channels as $channel) {
        \printf("%-38s %s\n", $channel->id, $channel->display_name);

        foreach ($synchra->channelProvider()->getChannelProviders($channel->id) as $provider) {
            \printf("    %-10s %s\n", $provider->provider->value, $provider->provider_channel_name ?? '—');
        }
    }
} catch (SynchraException $e) {
    \fwrite(\STDERR, 'Synchra said no: ' . $e->getMessage() . "\n");

    exit(1);
}
