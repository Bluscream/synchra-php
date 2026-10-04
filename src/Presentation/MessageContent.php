<?php

declare(strict_types=1);

namespace Synchra\Presentation;

use Synchra\Enum\ChatMessagePartType;
use Synchra\Model\ChatMessageBadge;
use Synchra\Model\ChatMessagePart;
use Synchra\Model\ImageUrls;

/**
 * Resolves the rich content of a chat message or activity into drawable {@see Segment}s and
 * {@see Badge}s.
 *
 * Synchra does the lookups server-side: a Twitch/YouTube/TikTok emote arrives already carrying its
 * CDN urls at three sizes, a gift carries an image url, a mention carries the resolved display name,
 * a link carries its url. None of that needs a second request. This collapses the typed parts into
 * one ordered list so a caller can render the images instead of the bare names — the difference
 * between showing `KPOPvictory` and showing the emote.
 *
 * It is deliberately framework-agnostic: it returns data, not HTML, so it is the same helper whether
 * the caller renders to a page, a terminal or a desktop app. `examples/04-render-chat.php` shows one
 * way to turn the output into HTML.
 */
final class MessageContent
{
    /**
     * The ordered, drawable segments of a message.
     *
     * @param list<ChatMessagePart>|null $parts    A message's `message_parts` (or an activity's).
     * @param 'sm'|'md'|'lg'             $emoteSize Which of the three emote sizes to resolve to.
     *
     * @return list<Segment>
     */
    public static function segments(?array $parts, string $emoteSize = 'md'): array
    {
        if ($parts === null) {
            return [];
        }

        $segments = [];

        foreach ($parts as $part) {
            $segments[] = self::segment($part, $emoteSize);
        }

        return $segments;
    }

    /**
     * A message's viewer badges, resolved to icons.
     *
     * @param list<ChatMessageBadge> $badges
     * @param 'sm'|'md'|'lg'         $size
     *
     * @return list<Badge>
     */
    public static function badges(array $badges, string $size = 'sm'): array
    {
        $out = [];

        foreach ($badges as $badge) {
            $out[] = new Badge($badge->name, $badge->type, self::pick($badge->urls, $size));
        }

        return $out;
    }

    /**
     * The plain text of a message, emotes included as the text they stand for.
     *
     * The same fallback the segments carry, joined — for a title attribute, a notification, a log
     * line, or any place that cannot show images. A message that is only an emote still reads as its
     * name rather than as an empty string.
     *
     * @param list<ChatMessagePart>|null $parts
     */
    public static function plainText(?array $parts): string
    {
        $text = '';

        foreach (self::segments($parts) as $segment) {
            $text .= $segment->text;
        }

        return \trim($text);
    }

    private static function segment(ChatMessagePart $part, string $emoteSize): Segment
    {
        // Each rich type carries a matching sub-object, but the two are typed independently, so a
        // part can in principle name a type whose sub-object is absent. Narrow on both before
        // trusting the sub-object; when it is missing the part still has its text, which is what the
        // final arm renders.
        $emote = $part->emote;

        if ($part->type === ChatMessagePartType::Emote && $emote !== null) {
            // The name reads better than the raw token as the alt/fallback.
            return new Segment(Segment::KIND_EMOTE, $emote->name, self::pick($emote->urls, $emoteSize), $emote->animated);
        }

        $gift = $part->gift;

        if ($part->type === ChatMessagePartType::Gift && $gift !== null) {
            return new Segment(Segment::KIND_GIFT, $part->text, $gift->image_url, $gift->animated ?? false);
        }

        $mention = $part->mention;

        if ($part->type === ChatMessagePartType::Mention && $mention !== null) {
            return new Segment(Segment::KIND_MENTION, '@' . $mention->display_name);
        }

        if ($part->type === ChatMessagePartType::Link) {
            $href = ($part->url ?? '') !== '' ? $part->url : $part->text;

            return new Segment(Segment::KIND_LINK, $part->text, href: $href);
        }

        // Text, date, and any rich type whose sub-object did not arrive: the part's own text.
        return new Segment(Segment::KIND_TEXT, $part->text);
    }

    private static function pick(?ImageUrls $urls, string $size): ?string
    {
        if ($urls === null) {
            return null;
        }

        return match ($size) {
            'sm' => $urls->sm,
            'lg' => $urls->lg,
            default => $urls->md,
        };
    }
}
