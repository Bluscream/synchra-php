<?php

declare(strict_types=1);

namespace Synchra\Tests\Unit\Presentation;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Synchra\Model\ChatMessageBadge;
use Synchra\Model\ChatMessagePart;
use Synchra\Presentation\Badge;
use Synchra\Presentation\MessageContent;
use Synchra\Presentation\Segment;
use Synchra\Tests\Support\Messages;

#[CoversClass(MessageContent::class)]
#[CoversClass(Segment::class)]
#[CoversClass(Badge::class)]
final class MessageContentTest extends TestCase
{
    /**
     * The exact shape the live API returns for an emote — the case the whole feature exists for.
     */
    public function testEmoteResolvesToItsImageUrl(): void
    {
        $part = ChatMessagePart::fromArray([
            'type' => 'emote',
            'text' => 'KPOPvictory',
            'emote' => [
                'id' => '303975459',
                'name' => 'KPOPvictory',
                'animated' => false,
                'emote_provider' => 'twitch',
                'urls' => [
                    'sm' => 'https://static-cdn.jtvnw.net/emoticons/v2/303975459/default/dark/1.0',
                    'md' => 'https://static-cdn.jtvnw.net/emoticons/v2/303975459/default/dark/2.0',
                    'lg' => 'https://static-cdn.jtvnw.net/emoticons/v2/303975459/default/dark/3.0',
                ],
            ],
        ]);

        $segments = MessageContent::segments([$part]);

        self::assertCount(1, $segments);
        self::assertSame(Segment::KIND_EMOTE, $segments[0]->kind);
        self::assertSame('KPOPvictory', $segments[0]->text);
        self::assertSame(
            'https://static-cdn.jtvnw.net/emoticons/v2/303975459/default/dark/2.0',
            $segments[0]->imageUrl,
        );
    }

    public function testEmoteSizeIsSelectable(): void
    {
        $part = ChatMessagePart::fromArray([
            'type' => 'emote',
            'text' => 'x',
            'emote' => [
                'id' => '1', 'name' => 'x', 'animated' => true, 'emote_provider' => 'twitch',
                'urls' => ['sm' => 'a/1.0', 'md' => 'a/2.0', 'lg' => 'a/3.0'],
            ],
        ]);

        self::assertSame('a/1.0', MessageContent::segments([$part], 'sm')[0]->imageUrl);
        self::assertSame('a/3.0', MessageContent::segments([$part], 'lg')[0]->imageUrl);
        self::assertTrue(MessageContent::segments([$part])[0]->animated);
    }

    public function testTextMentionLinkAndGiftEachResolve(): void
    {
        $parts = [
            ChatMessagePart::fromArray(['type' => 'text', 'text' => 'hello ']),
            ChatMessagePart::fromArray([
                'type' => 'mention', 'text' => '@bob',
                'mention' => ['user_id' => '7', 'username' => 'bob', 'display_name' => 'Bob'],
            ]),
            ChatMessagePart::fromArray(['type' => 'link', 'text' => 'synchra.net', 'url' => 'https://synchra.net']),
            ChatMessagePart::fromArray([
                'type' => 'gift', 'text' => 'Rose',
                'gift' => [
                    'id' => 'g1', 'name' => 'Rose', 'type' => 'virtual', 'count' => 1,
                    'animated' => true, 'image_url' => 'https://cdn.example/rose.png',
                ],
            ]),
        ];

        $segments = MessageContent::segments($parts);

        self::assertSame(Segment::KIND_TEXT, $segments[0]->kind);
        self::assertSame('@Bob', $segments[1]->text);
        self::assertSame(Segment::KIND_MENTION, $segments[1]->kind);
        self::assertSame('https://synchra.net', $segments[2]->href);
        self::assertSame(Segment::KIND_GIFT, $segments[3]->kind);
        self::assertSame('https://cdn.example/rose.png', $segments[3]->imageUrl);
    }

    public function testPlainTextJoinsTheFallbacksAndSurvivesNull(): void
    {
        $parts = [
            ChatMessagePart::fromArray(['type' => 'text', 'text' => 'nice ']),
            ChatMessagePart::fromArray([
                'type' => 'emote', 'text' => 'KPOPvictory',
                'emote' => ['id' => '1', 'name' => 'KPOPvictory', 'animated' => false, 'emote_provider' => 'twitch'],
            ]),
        ];

        self::assertSame('nice KPOPvictory', MessageContent::plainText($parts));
        self::assertSame([], MessageContent::segments(null));
        self::assertSame('', MessageContent::plainText(null));
    }

    public function testLinkWithoutAnExplicitUrlFallsBackToItsText(): void
    {
        $part = ChatMessagePart::fromArray(['type' => 'link', 'text' => 'https://bare.example']);

        self::assertSame('https://bare.example', MessageContent::segments([$part])[0]->href);
    }

    public function testBadgesResolveToIconsAndJsonOmitsAMissingIcon(): void
    {
        $withIcon = ChatMessageBadge::fromArray([
            'id' => 'sub-12', 'type' => 'subscriber', 'name' => 'Subscriber',
            'urls' => ['sm' => 'b/1.0', 'md' => 'b/2.0', 'lg' => 'b/3.0'],
        ]);
        $noIcon = ChatMessageBadge::fromArray(['id' => 'm', 'type' => 'moderator', 'name' => 'Mod']);

        $badges = MessageContent::badges([$withIcon, $noIcon]);

        self::assertSame('b/1.0', $badges[0]->imageUrl);
        self::assertNull($badges[1]->imageUrl);
        self::assertArrayNotHasKey('imageUrl', $badges[1]->jsonSerialize());
    }

    public function testSegmentJsonCarriesOnlyTheKeysItUses(): void
    {
        $emote = new Segment(Segment::KIND_EMOTE, 'x', 'u', true);
        $text = new Segment(Segment::KIND_TEXT, 'hi');

        self::assertSame(['kind' => 'emote', 'text' => 'x', 'imageUrl' => 'u', 'animated' => true], $emote->jsonSerialize());
        self::assertSame(['kind' => 'text', 'text' => 'hi'], $text->jsonSerialize());
    }

    // --- notices -----------------------------------------------------------

    /**
     * The live shape of a TikTok gift: a notice whose message_parts are empty and whose content is
     * entirely in notice_message_parts. Reading only message_parts draws these as blank rows.
     */
    public function testANoticeCarriesItsContentInTheNoticeParts(): void
    {
        $message = Messages::chat([
            'type' => 'notice',
            'sub_type' => 'tiktok_gift',
            'provider' => 'tiktok',
            'message_parts' => [],
            'notice_message_parts' => [[
                'type' => 'gift',
                'text' => '1 diamond',
                'gift' => [
                    'id' => '13651', 'name' => 'Popular Vote', 'type' => 'diamond', 'count' => 1,
                    'count_display_name' => 'diamond', 'animated' => false,
                    'image_url' => 'https://p16-webcast.tiktokcdn.com/img/b342e28d.png',
                ],
            ]],
        ]);

        self::assertTrue(MessageContent::isNotice($message));

        $segments = MessageContent::segments(MessageContent::contentParts($message));

        self::assertCount(1, $segments);
        self::assertSame(Segment::KIND_GIFT, $segments[0]->kind);
        self::assertSame('https://p16-webcast.tiktokcdn.com/img/b342e28d.png', $segments[0]->imageUrl);
        // The gift's name, not the part's "1 diamond": this is the alt text for that image.
        self::assertSame('Popular Vote', $segments[0]->text);
    }

    public function testAnOrdinaryMessageKeepsUsingItsMessageParts(): void
    {
        $message = Messages::chat([
            'message_parts' => [['type' => 'text', 'text' => 'hello']],
            'notice_message_parts' => [['type' => 'text', 'text' => 'should not be used']],
        ]);

        self::assertFalse(MessageContent::isNotice($message));
        self::assertSame('hello', MessageContent::plainText(MessageContent::contentParts($message)));
    }

    public function testAMessageWithNeitherKindOfPartHasNoSegments(): void
    {
        self::assertSame([], MessageContent::contentParts(Messages::chat()));
        self::assertSame('', MessageContent::plainText(MessageContent::contentParts(Messages::chat())));
    }

    public function testAGiftWithoutANameFallsBackToThePartText(): void
    {
        $part = ChatMessagePart::fromArray([
            'type' => 'gift', 'text' => '1 diamond',
            'gift' => ['id' => 'g', 'name' => '', 'type' => 'diamond', 'count' => 1, 'image_url' => 'https://c/x.png'],
        ]);

        self::assertSame('1 diamond', MessageContent::segments([$part])[0]->text);
    }
}
