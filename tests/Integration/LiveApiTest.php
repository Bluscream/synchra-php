<?php

declare(strict_types=1);

namespace Synchra\Tests\Integration;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Synchra\Exception\ApiException;
use Synchra\Exception\AuthenticationException;
use Synchra\Http\RetryPolicy;
use Synchra\Model\Channel;
use Synchra\Pagination\Page;
use Synchra\Synchra;

/**
 * Talks to the real API.
 *
 * Every call here is a read. Nothing in this suite creates, updates or deletes anything, because
 * the only credentials anyone will run it with belong to a live channel with real viewers.
 *
 * Run it with a token that has at least `channel:read` and `user:read`:
 *
 * ```sh
 * SYNCHRA_TOKEN=… vendor/bin/phpunit --testsuite live
 * ```
 *
 * Without `SYNCHRA_TOKEN` every test skips, which is the expected outcome on a machine that has
 * no credentials — including CI.
 */
#[Group('live')]
final class LiveApiTest extends TestCase
{
    private const PER_PAGE = 5;

    private function synchra(): Synchra
    {
        $token = \getenv('SYNCHRA_TOKEN');

        if (!\is_string($token) || \trim($token) === '') {
            self::markTestSkipped('Set SYNCHRA_TOKEN to run the live suite.');
        }

        $options = (new \Synchra\ClientOptions())->withRetry(new RetryPolicy(
            // The suite runs against someone's production channel, so it waits generously and
            // gives up quickly rather than hammering an API that is already struggling.
            maxAttempts: 2,
            baseDelayMs: 2_000,
        ));

        $base = \getenv('SYNCHRA_API_BASE_URI');

        if (\is_string($base) && \trim($base) !== '') {
            $options = $options->withApiBaseUri($base);
        }

        return Synchra::withToken($token, $options);
    }

    public function testTheTokenIdentifiesAUser(): void
    {
        $user = $this->synchra()->user()->userInfo();

        self::assertNotSame('', $user->id);
        self::assertNotSame('', $user->username);
    }

    public function testUserSettingsAreReadable(): void
    {
        $settings = $this->synchra()->user()->userSettings();

        // Round-tripping proves the reader and the writer agree about the live payload, which is
        // what an update built from a fetched settings object depends on.
        self::assertSame(
            $settings->jsonSerialize(),
            \Synchra\Model\UserSettings::fromArray($settings->jsonSerialize())->jsonSerialize(),
        );
    }

    public function testChannelsComeBackAsAPage(): void
    {
        $page = $this->synchra()->channel()->getChannels();

        self::assertInstanceOf(Page::class, $page);
        self::assertContainsOnlyInstancesOf(Channel::class, $page->records);
    }

    public function testActivityTypesAreReadableWithoutAChannel(): void
    {
        $types = $this->synchra()->channelActivity()->activityTypes();

        self::assertNotEmpty($types);
    }

    public function testAChannelsProvidersHydrate(): void
    {
        $synchra = $this->synchra();
        $channel = $synchra->channel()->getChannels()->first();

        if ($channel === null) {
            self::markTestSkipped('This token can see no channels.');
        }

        $providers = $synchra->channelProvider()->getChannelProviders($channel->id);

        // A channel with no linked platform is legitimate, so the assertion is about each entry
        // rather than about there being any.
        foreach ($providers as $provider) {
            self::assertNotSame('', $provider->id);
        }
    }

    public function testChatMessagesPaginate(): void
    {
        $synchra = $this->synchra();
        $channel = $synchra->channel()->getChannels()->first();

        if ($channel === null) {
            self::markTestSkipped('This token can see no channels.');
        }

        $page = $synchra->chat()->getChatMessages(
            $channel->id,
            new \Synchra\Query\ChatMessagesQuery(per_page: self::PER_PAGE),
        );

        self::assertLessThanOrEqual(self::PER_PAGE, $page->count());
    }

    public function testAnInvalidTokenIsReportedAsAnAuthenticationFailure(): void
    {
        // Confirms the real 401 envelope still maps the way the unit tests assume it does.
        $this->synchra();

        $this->expectException(AuthenticationException::class);

        Synchra::withToken('definitely-not-a-valid-token')->user()->userInfo();
    }

    public function testAMissingResourceIsReportedAsNotFound(): void
    {
        $synchra = $this->synchra();

        try {
            $synchra->channel()->getChannel('00000000-0000-7000-8000-000000000000');
            self::markTestSkipped('The API answered for a channel id that was expected to be absent.');
        } catch (ApiException $e) {
            self::assertContains($e->status, [403, 404], "Unexpected status {$e->status}.");
        }
    }
}
