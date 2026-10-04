<?php

declare(strict_types=1);

/*
 * Render recent chat with its emotes, gifts, mentions and badges as real images — not just names.
 *
 *   php examples/04-render-chat.php [channel-id] > chat.html
 *
 * No token needed: chat is a public endpoint, so this uses Synchra::anonymous(). Synchra resolves
 * every emote to a CDN url server-side, so rendering is just walking MessageContent::segments() and
 * turning each segment into text, an <img> or an <a>. The same helper works for a donation's
 * message (an Activity also has message_parts).
 */

require __DIR__ . '/../vendor/autoload.php';

use Synchra\Presentation\Badge;
use Synchra\Presentation\MessageContent;
use Synchra\Presentation\Segment;
use Synchra\Query\ChatMessagesQuery;
use Synchra\Synchra;

$synchra = Synchra::anonymous();
$channelId = $argv[1] ?? '019d49d2-0891-70e5-b791-c94fd76ca590';

$page = $synchra->chat()->getChatMessages($channelId, new ChatMessagesQuery(per_page: 40));

/** Escape for HTML text and double-quoted attributes. */
$e = static fn(string $s): string => \htmlspecialchars($s, \ENT_QUOTES | \ENT_SUBSTITUTE, 'UTF-8');

/** One message part → HTML. */
$renderSegment = static function (Segment $segment) use ($e): string {
    return match ($segment->kind) {
        Segment::KIND_EMOTE, Segment::KIND_GIFT => $segment->imageUrl !== null
            // height:1.4em keeps an emote on the text's line; the name stays as alt and title.
            ? \sprintf(
                '<img src="%s" alt="%s" title="%s" style="height:1.4em;vertical-align:middle">',
                $e($segment->imageUrl),
                $e($segment->text),
                $e($segment->text),
            )
            : $e($segment->text),
        Segment::KIND_LINK => \sprintf(
            '<a href="%s" rel="noopener noreferrer">%s</a>',
            $e($segment->href ?? $segment->text),
            $e($segment->text),
        ),
        Segment::KIND_MENTION => '<strong>' . $e($segment->text) . '</strong>',
        default => $e($segment->text),
    };
};

echo "<!doctype html><meta charset=utf-8><title>Chat</title><body style=\"font-family:sans-serif\">\n";

foreach ($page as $message) {
    $badges = \implode('', \array_map(
        static fn(Badge $b): string => $b->imageUrl !== null
            ? \sprintf('<img src="%s" alt="%s" title="%s" style="height:1.1em;vertical-align:middle;margin-right:2px">', $e($b->imageUrl), $e($b->name), $e($b->name))
            : '',
        MessageContent::badges($message->badges),
    ));

    $body = \implode('', \array_map($renderSegment, MessageContent::segments($message->message_parts)));

    $colour = $message->viewer_color ?? 'inherit';

    \printf(
        "<p>%s<strong style=\"color:%s\">%s</strong>: %s</p>\n",
        $badges,
        $e($colour),
        $e($message->viewer_display_name),
        $body,
    );
}

echo "</body>\n";
