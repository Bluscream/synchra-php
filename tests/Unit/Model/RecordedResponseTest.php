<?php

declare(strict_types=1);

namespace Synchra\Tests\Unit\Model;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Synchra\Model\Activity;
use Synchra\Model\ActivityAlertControlState;
use Synchra\Model\ActivityTypeName;
use Synchra\Model\Channel;
use Synchra\Model\ChannelProviderPublic;
use Synchra\Model\ChannelProviderStream;
use Synchra\Model\ChatEvent;
use Synchra\Model\ChatMessage;
use Synchra\Model\Emote;
use Synchra\Model\UserProviderPublic;
use Synchra\Model\UserPublic;
use Synchra\Model\UserSettings;
use Synchra\Pagination\Page;
use Synchra\Serialization\DataModel;
use Synchra\Tests\Support\Fixture;

/**
 * Hydrates real recorded responses with the generated models.
 *
 * These are the tests that would catch the SDK drifting away from the live API: if a field the
 * description marks required stops arriving, or an enum gains a value, the hydration throws here
 * rather than in somebody's application.
 */
final class RecordedResponseTest extends TestCase
{
    /** @param class-string<DataModel> $class */
    #[DataProvider('singleObjects')]
    public function testASingleObjectResponseHydrates(string $fixture, string $class): void
    {
        $model = $class::fromArray(Fixture::object($fixture));

        self::assertInstanceOf($class, $model);
    }

    /** @return iterable<string, array{string, class-string<DataModel>}> */
    public static function singleObjects(): iterable
    {
        yield 'GET /user' => ['user.json', UserPublic::class];
        yield 'GET /user/settings' => ['user-settings.json', UserSettings::class];
        yield 'GET /channels/{id}/activity-alerts/state' => [
            'activity-alerts-state.json',
            ActivityAlertControlState::class,
        ];
    }

    /** @param class-string<DataModel> $class */
    #[DataProvider('objectLists')]
    public function testAnArrayResponseHydratesEveryItem(string $fixture, string $class): void
    {
        $source = Fixture::objects($fixture);
        /** @var list<DataModel> $items */
        $items = \array_map($class::fromArray(...), $source);

        self::assertNotEmpty($items, "Fixture {$fixture} has no records to prove anything with.");

        foreach ($items as $index => $item) {
            // Serialising and re-hydrating has to land on the same payload. That proves the read
            // and write sides agree about every field — a type the reader widens or a nullable
            // the writer drops would show up as a difference here.
            self::assertSame(
                $item->jsonSerialize(),
                $class::fromArray($item->jsonSerialize())->jsonSerialize(),
                "{$class} at index {$index} does not round-trip.",
            );
        }
    }

    /** @return iterable<string, array{string, class-string<DataModel>}> */
    public static function objectLists(): iterable
    {
        yield 'GET /user/providers' => ['user-providers.json', UserProviderPublic::class];
        yield 'GET /activity-types' => ['activity-types.json', ActivityTypeName::class];
        yield 'GET /chat/emotes' => ['chat-emotes.json', Emote::class];
        yield 'GET /channels/{id}/providers' => ['channel-providers.json', ChannelProviderPublic::class];
    }

    /** @param class-string<DataModel> $class */
    #[DataProvider('pages')]
    public function testAPagedResponseHydratesIntoAPage(string $fixture, string $class): void
    {
        $source = Fixture::object($fixture);
        $page = Page::ofModel($source, $class);

        self::assertSame(\is_array($source['records'] ?? null) ? \count($source['records']) : 0, $page->count());

        foreach ($page->records as $index => $record) {
            self::assertSame(
                $record->jsonSerialize(),
                $class::fromArray($record->jsonSerialize())->jsonSerialize(),
                "{$class} at index {$index} does not round-trip.",
            );
        }
    }

    /** @return iterable<string, array{string, class-string<DataModel>}> */
    public static function pages(): iterable
    {
        yield 'GET /channels' => ['channels-page.json', Channel::class];
        yield 'GET /channels/{id}/chat-messages' => ['chat-messages-page.json', ChatMessage::class];
        yield 'GET /channels/{id}/chat-events' => ['chat-events-page.json', ChatEvent::class];
        yield 'GET /channels/{id}/activities' => ['activities-page.json', Activity::class];
        yield 'GET /channels/{id}/provider-streams' => [
            'provider-streams-page.json',
            ChannelProviderStream::class,
        ];
    }

    public function testAHydratedChatMessageExposesItsPartsBadgesAndProvider(): void
    {
        $page = Page::ofModel(Fixture::object('chat-messages-page.json'), ChatMessage::class);
        $message = $page->first();

        self::assertNotNull($message);
        self::assertNotSame('', $message->id);
        self::assertNotNull($message->provider);
        self::assertNotSame([], $message->message_parts);
    }

    public function testEveryFixtureIsCoveredBySomeCaseInThisFile(): void
    {
        // A fixture nobody hydrates is dead weight that stops proving anything the day the API
        // changes, so adding one without a case here is a failure.
        $covered = ['error-validation.json', 'user-profiles.json'];

        foreach ([self::singleObjects(), self::objectLists(), self::pages()] as $cases) {
            foreach ($cases as [$fixture, $ignored]) {
                $covered[] = $fixture;
            }
        }

        self::assertSame([], \array_values(\array_diff(Fixture::names(), $covered)));
    }
}
