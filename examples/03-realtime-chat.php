<?php

declare(strict_types=1);

/*
 * Follow a channel's chat and activity feed in realtime.
 *
 *   SYNCHRA_TOKEN=… php examples/03-realtime-chat.php [channel-id] [seconds]
 *
 * Ctrl-C to stop, or let it return after `seconds` (default 60).
 */

require __DIR__ . '/../vendor/autoload.php';

use Synchra\Exception\SynchraException;
use Synchra\Synchra;
use Synchra\WebSocket\Event;
use Synchra\WebSocket\EventType;

$synchra = Synchra::fromEnvironment();
$channelId = $argv[1] ?? null;
$seconds = (float) ($argv[2] ?? 60);

try {
    if ($channelId === null) {
        $channel = $synchra->channel()->getChannels()->first();

        if ($channel === null) {
            \fwrite(\STDERR, "This token can see no channels; pass a channel id.\n");

            exit(1);
        }

        $channelId = $channel->id;
    }

    $events = $synchra->events();

    $events->onConnect(static function (): void {
        echo "[gateway] connected\n";
    });

    $events->onDisconnect(static function (): void {
        echo "[gateway] disconnected\n";
    });

    $events->on(EventType::ChatMessage, static function (Event $event): void {
        $message = $event->model();

        if (!$message instanceof \Synchra\Model\ChatMessage) {
            return;
        }

        $text = '';

        foreach ($message->message_parts as $part) {
            $text .= $part->text;
        }

        \printf("[%s] %s: %s\n", $message->provider->value, $message->viewer_display_name, $text);
    });

    $events->on(EventType::Activity, static function (Event $event): void {
        // An activity event carries the Activity schema, so the typed model is the easy route;
        // dataObject() is there for an event type this package does not model yet.
        $activity = $event->model();

        if (!$activity instanceof \Synchra\Model\Activity) {
            return;
        }

        \printf("[activity] %s by %s\n", $activity->type, $activity->viewer_display_name);
    });

    $events->onError(static function (Event $event): void {
        $error = $event->error();

        \fwrite(\STDERR, '[gateway error] ' . ($error === null ? 'unknown' : $error->message) . "\n");
    });

    $events->subscribeChatMessage($channelId);
    $events->subscribeActivity($channelId);

    \printf("Listening to %s for %.0fs…\n", $channelId, $seconds);

    $events->run($seconds);
    $events->close();
} catch (SynchraException $e) {
    \fwrite(\STDERR, 'Synchra said no: ' . $e->getMessage() . "\n");

    exit(1);
}
