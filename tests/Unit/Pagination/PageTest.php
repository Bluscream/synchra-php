<?php

declare(strict_types=1);

namespace Synchra\Tests\Unit\Pagination;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Synchra\Model\ChatMessage;
use Synchra\Model\UserPublic;
use Synchra\Pagination\Page;
use Synchra\Tests\Support\Fixture;

#[CoversClass(Page::class)]
final class PageTest extends TestCase
{
    public function testARecordedPageHydratesItsRecordsCursorAndTotal(): void
    {
        $page = Page::ofModel(Fixture::object('chat-messages-page.json'), ChatMessage::class);

        self::assertGreaterThan(0, $page->count());
        self::assertContainsOnlyInstancesOf(ChatMessage::class, $page->records);
        self::assertNotNull($page->first());
    }

    public function testHasMoreFollowsTheCursor(): void
    {
        self::assertTrue((new Page([], cursor: 'abc'))->hasMore());
        self::assertFalse((new Page([], cursor: null))->hasMore());
        // An empty-string cursor means the same thing as no cursor; treating it as a real one
        // would make the paginator ask for a page that does not exist.
        self::assertFalse((new Page([], cursor: ''))->hasMore());
    }

    public function testAPageIsCountableAndIterable(): void
    {
        $page = new Page([
            new UserPublic(id: 'a', username: 'a', display_name: 'A'),
            new UserPublic(id: 'b', username: 'b', display_name: 'B'),
        ]);

        self::assertCount(2, $page);

        $seen = [];

        foreach ($page as $record) {
            $seen[] = $record->id;
        }

        self::assertSame(['a', 'b'], $seen);
    }

    public function testAnEmptyPageIsValidAndReportsNoFirstRecord(): void
    {
        $page = Page::ofModel(Fixture::object('activities-page.json'), \Synchra\Model\Activity::class);

        self::assertCount(0, $page);
        self::assertNull($page->first());
        self::assertFalse($page->hasMore());
    }

    public function testLookupDataIsKeptForRecordsThatReferToIt(): void
    {
        $page = Page::ofModel([
            'records' => [['id' => 'a', 'username' => 'a', 'display_name' => 'A']],
            'lookup_data' => ['channels' => ['c1' => ['display_name' => 'Example']]],
            'cursor' => null,
            'total' => 1,
        ], UserPublic::class);

        self::assertSame(['channels' => ['c1' => ['display_name' => 'Example']]], $page->lookupData);
        self::assertSame(1, $page->total);
    }

    public function testAPageRoundTripsThroughJson(): void
    {
        $page = new Page(
            [new UserPublic(id: 'a', username: 'a', display_name: 'A')],
            cursor: 'next',
            total: 9,
        );

        self::assertSame([
            'records' => [[
                'id' => 'a',
                'username' => 'a',
                'display_name' => 'A',
                'default_channel_id' => null,
            ]],
            'lookup_data' => [],
            'cursor' => 'next',
            'total' => 9,
        ], $page->jsonSerialize());
    }
}
