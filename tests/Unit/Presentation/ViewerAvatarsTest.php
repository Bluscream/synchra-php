<?php

declare(strict_types=1);

namespace Synchra\Tests\Unit\Presentation;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Synchra\Enum\Provider;
use Synchra\Model\ChatMessage;
use Synchra\Presentation\AvatarSource;
use Synchra\Presentation\HttpAvatarSource;
use Synchra\Presentation\InMemoryAvatarStore;
use Synchra\Presentation\ViewerAvatars;
use Synchra\Tests\Support\FakeTransport;
use Synchra\Tests\Support\Messages;

#[CoversClass(ViewerAvatars::class)]
#[CoversClass(InMemoryAvatarStore::class)]
#[CoversClass(HttpAvatarSource::class)]
final class ViewerAvatarsTest extends TestCase
{
    public function testAMessageThatAlreadyCarriesAnAvatarIsNotLookedUp(): void
    {
        $source = new RecordingAvatarSource(['*' => 'https://example.test/looked-up.png']);
        $avatars = new ViewerAvatars([$source]);

        $result = $avatars->forMessages([
            self::message('m1', Provider::Tiktok, '111', 'someone', 'https://cdn.test/carried.webp'),
        ]);

        self::assertSame(['m1' => 'https://cdn.test/carried.webp'], $result);
        self::assertSame([], $source->asked);
    }

    /** The case the whole class exists for: Twitch messages arrive with a null picture. */
    public function testAMessageWithoutAnAvatarIsLookedUp(): void
    {
        $source = new RecordingAvatarSource([
            'twitch:707216832' => 'https://static-cdn.jtvnw.net/jtv_user_pictures/adc84592-profile_image-300x300.jpeg',
        ]);

        $result = (new ViewerAvatars([$source]))->forMessages([
            self::message('m1', Provider::Twitch, '707216832', 'mark_teufel01', null),
        ]);

        self::assertSame(
            ['m1' => 'https://static-cdn.jtvnw.net/jtv_user_pictures/adc84592-profile_image-300x300.jpeg'],
            $result,
        );
        self::assertSame(['twitch:707216832'], $source->asked);
    }

    public function testTheSameViewerIsLookedUpOnceHoweverMuchTheyTalk(): void
    {
        $source = new RecordingAvatarSource(['twitch:1' => 'https://cdn.test/a.png']);

        $result = (new ViewerAvatars([$source]))->forMessages([
            self::message('m1', Provider::Twitch, '1', 'a', null),
            self::message('m2', Provider::Twitch, '1', 'a', null),
            self::message('m3', Provider::Twitch, '1', 'a', null),
        ]);

        self::assertSame(
            ['m1' => 'https://cdn.test/a.png', 'm2' => 'https://cdn.test/a.png', 'm3' => 'https://cdn.test/a.png'],
            $result,
        );
        self::assertSame(['twitch:1'], $source->asked);
    }

    public function testAViewerWithNoAvatarIsNotAskedAboutAgain(): void
    {
        $source = new RecordingAvatarSource([]);
        $avatars = new ViewerAvatars([$source], new InMemoryAvatarStore());

        $first = $avatars->forMessages([self::message('m1', Provider::Twitch, '1', 'a', null)]);
        $second = $avatars->forMessages([self::message('m2', Provider::Twitch, '1', 'a', null)]);

        self::assertSame([], $first);
        self::assertSame([], $second);
        self::assertSame(['twitch:1'], $source->asked, 'the miss should have been remembered');
    }

    public function testOnlySoManyUnknownViewersAreLookedUpPerBatch(): void
    {
        $source = new RecordingAvatarSource([
            'twitch:1' => 'https://cdn.test/1.png',
            'twitch:2' => 'https://cdn.test/2.png',
            'twitch:3' => 'https://cdn.test/3.png',
        ]);

        $avatars = new ViewerAvatars([$source], new InMemoryAvatarStore(), lookupsPerBatch: 2);

        $first = $avatars->forMessages([
            self::message('m1', Provider::Twitch, '1', 'a', null),
            self::message('m2', Provider::Twitch, '2', 'b', null),
            self::message('m3', Provider::Twitch, '3', 'c', null),
        ]);

        self::assertSame(['m1' => 'https://cdn.test/1.png', 'm2' => 'https://cdn.test/2.png'], $first);

        // The third viewer is picked up by the next call rather than being lost.
        $second = $avatars->forMessages([self::message('m3', Provider::Twitch, '3', 'c', null)]);

        self::assertSame(['m3' => 'https://cdn.test/3.png'], $second);
    }

    public function testSourcesAreAskedInOrderAndTheFirstAnswerWins(): void
    {
        $first = new RecordingAvatarSource([]);
        $second = new RecordingAvatarSource(['twitch:1' => 'https://cdn.test/second.png']);
        $third = new RecordingAvatarSource(['twitch:1' => 'https://cdn.test/third.png']);

        $result = (new ViewerAvatars([$first, $second, $third]))
            ->forMessages([self::message('m1', Provider::Twitch, '1', 'a', null)]);

        self::assertSame(['m1' => 'https://cdn.test/second.png'], $result);
        self::assertSame([], $third->asked, 'a later source should not be asked once one has answered');
    }

    public function testWithNoSourcesNothingIsInvented(): void
    {
        $result = (new ViewerAvatars([]))->forMessages([
            self::message('m1', Provider::Twitch, '1', 'a', null),
            self::message('m2', Provider::Tiktok, '2', 'b', 'https://cdn.test/carried.png'),
        ]);

        self::assertSame(['m2' => 'https://cdn.test/carried.png'], $result);
    }

    public function testForViewerAnswersASingleLookup(): void
    {
        $avatars = new ViewerAvatars([new RecordingAvatarSource(['youtube:UC1' => 'https://cdn.test/y.png'])]);

        self::assertSame('https://cdn.test/y.png', $avatars->forViewer(Provider::Youtube, 'UC1', 'someone'));
    }

    public function testKeyIsPerViewerNotPerMessage(): void
    {
        self::assertSame('twitch:707216832', ViewerAvatars::key(Provider::Twitch, '707216832'));
    }

    public function testInMemoryStoreEvictsTheOldestEntriesPastItsCap(): void
    {
        $store = new InMemoryAvatarStore(maxEntries: 2);
        $store->set('a', 'https://cdn.test/a.png');
        $store->set('b', 'https://cdn.test/b.png');
        $store->set('c', 'https://cdn.test/c.png');

        self::assertNull($store->get('a'));
        self::assertSame('https://cdn.test/b.png', $store->get('b'));
        self::assertSame('https://cdn.test/c.png', $store->get('c'));
    }

    // --- HttpAvatarSource --------------------------------------------------

    public function testHttpSourceTakesThePlainBodyAsTheUrl(): void
    {
        $transport = (new FakeTransport())
            ->queue(200, "https://static-cdn.jtvnw.net/jtv_user_pictures/adc84592-profile_image-300x300.jpeg\n");

        $source = new HttpAvatarSource(
            templates: ['twitch' => 'https://decapi.test/twitch/avatar/{name}'],
            transport: $transport,
        );

        self::assertSame(
            'https://static-cdn.jtvnw.net/jtv_user_pictures/adc84592-profile_image-300x300.jpeg',
            $source->lookup(Provider::Twitch, '707216832', 'mark_teufel01'),
        );
        self::assertSame('https://decapi.test/twitch/avatar/mark_teufel01', $transport->sent[0]['uri']);
    }

    public function testHttpSourceSubstitutesTheIdAndEncodesIt(): void
    {
        $transport = (new FakeTransport())->queue(200, 'https://cdn.test/a.png');

        (new HttpAvatarSource(templates: ['youtube' => 'https://x.test/{id}/{name}'], transport: $transport))
            ->lookup(Provider::Youtube, 'UC a/b', 'n a');

        self::assertSame('https://x.test/UC%20a%2Fb/n%20a', $transport->sent[0]['uri']);
    }

    public function testHttpSourcePullsTheUrlOutWithAPattern(): void
    {
        $transport = (new FakeTransport())->queue(
            200,
            '<html>…"avatar":{"thumbnails":[{"url":"https://yt3.test/abc=s900","width":900}]}…</html>',
        );

        $source = new HttpAvatarSource(
            templates: ['youtube' => 'https://www.youtube.test/channel/{id}'],
            patterns: ['youtube' => '#"avatar":\{"thumbnails":\[\{"url":"([^"]+)"#'],
            transport: $transport,
        );

        self::assertSame('https://yt3.test/abc=s900', $source->lookup(Provider::Youtube, 'UC1', 'n'));
    }

    public function testHttpSourceIgnoresAProviderItHasNoTemplateFor(): void
    {
        $transport = new FakeTransport();

        $source = new HttpAvatarSource(templates: ['twitch' => 'https://x.test/{name}'], transport: $transport);

        self::assertNull($source->lookup(Provider::Youtube, 'UC1', 'n'));
        self::assertSame([], $transport->sent, 'no request should be made for an unconfigured provider');
    }

    /** A "user not found" sentence answered with 200 must not end up in an <img src>. */
    public function testHttpSourceRefusesABodyThatIsNotAnHttpsUrl(): void
    {
        $transport = (new FakeTransport())->queue(200, 'User not found.');

        $source = new HttpAvatarSource(templates: ['twitch' => 'https://x.test/{name}'], transport: $transport);

        self::assertNull($source->lookup(Provider::Twitch, '1', 'nobody'));
    }

    public function testHttpSourceIgnoresAnErrorResponse(): void
    {
        $transport = (new FakeTransport())->queue(404, 'https://cdn.test/a.png');

        $source = new HttpAvatarSource(templates: ['twitch' => 'https://x.test/{name}'], transport: $transport);

        self::assertNull($source->lookup(Provider::Twitch, '1', 'nobody'));
    }

    private static function message(
        string $id,
        Provider $provider,
        string $viewerId,
        string $viewerName,
        ?string $avatar,
    ): ChatMessage {
        return Messages::chat([
            'id' => $id,
            'provider' => $provider->value,
            'provider_viewer_id' => $viewerId,
            'viewer_name' => $viewerName,
            'viewer_display_name' => $viewerName,
            'viewer_profile_picture_url' => $avatar,
        ]);
    }
}

/**
 * A source that answers from a fixed map and records every viewer it was asked about, so a test can
 * assert on how many lookups happened as well as on the result.
 */
final class RecordingAvatarSource implements AvatarSource
{
    /** @var list<string> */
    public array $asked = [];

    /** @param array<string, string> $answers Keyed by `provider:id`, or `*` to answer anything. */
    public function __construct(private readonly array $answers) {}

    public function lookup(Provider $provider, string $viewerId, string $viewerName): ?string
    {
        $key = ViewerAvatars::key($provider, $viewerId);
        $this->asked[] = $key;

        return $this->answers[$key] ?? $this->answers['*'] ?? null;
    }
}
