<?php

declare(strict_types=1);

namespace Synchra\Tests\Unit\Presentation;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Synchra\Enum\Provider;
use Synchra\Presentation\ProfileUrl;
use Synchra\Tests\Support\Messages;

#[CoversClass(ProfileUrl::class)]
final class ProfileUrlTest extends TestCase
{
    public function testHandleBasedProviders(): void
    {
        self::assertSame('https://www.twitch.tv/mark_teufel01', ProfileUrl::for(Provider::Twitch, 'mark_teufel01'));
        self::assertSame('https://www.tiktok.com/@bleichiloveless', ProfileUrl::for(Provider::Tiktok, 'bleichiloveless'));
        self::assertSame('https://kick.com/someone', ProfileUrl::for(Provider::Kick, 'someone'));
    }

    /** YouTube is the odd one out: its canonical profile url is the channel id, not the handle. */
    public function testYoutubeUsesTheChannelIdRatherThanTheHandle(): void
    {
        self::assertSame(
            'https://www.youtube.com/channel/UChEyxtmrh1vGIfBPEyOls7Q',
            ProfileUrl::for(Provider::Youtube, 'bleichiloveless', 'UChEyxtmrh1vGIfBPEyOls7Q'),
        );
    }

    public function testYoutubeWithoutAChannelIdHasNoUrl(): void
    {
        self::assertNull(ProfileUrl::for(Provider::Youtube, 'bleichiloveless'));
        self::assertNull(ProfileUrl::for(Provider::Youtube, 'bleichiloveless', ''));
    }

    /** An emote host or a TTS service is not somewhere people have profiles. */
    public function testAProviderWithNoProfilePagesAnswersNull(): void
    {
        self::assertNull(ProfileUrl::for(Provider::N7tv, 'someone'));
        self::assertNull(ProfileUrl::for(Provider::Elevenlabs, 'someone'));
    }

    public function testAnEmptyHandleHasNoUrl(): void
    {
        self::assertNull(ProfileUrl::for(Provider::Twitch, ''));
    }

    public function testAHandleIsEncodedRatherThanPastedIntoTheUrl(): void
    {
        self::assertSame('https://www.twitch.tv/a%2Fb%3Fc', ProfileUrl::for(Provider::Twitch, 'a/b?c'));
    }

    public function testForMessageReadsTheProviderAndHandleOffTheMessage(): void
    {
        $message = Messages::chat([
            'provider' => 'tiktok',
            'viewer_name' => 'keksesindtollll',
            'provider_viewer_id' => '6992291432863663110',
        ]);

        self::assertSame('https://www.tiktok.com/@keksesindtollll', ProfileUrl::forMessage($message));
    }
}
