<?php

declare(strict_types=1);

namespace Synchra\Tests\Unit\Pagination;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Synchra\Exception\SerializationException;
use Synchra\Model\UserPublic;
use Synchra\Pagination\Page;
use Synchra\Pagination\Paginator;

#[CoversClass(Paginator::class)]
final class PaginatorTest extends TestCase
{
    /** @return Page<UserPublic> */
    private function page(string $id, ?string $cursor): Page
    {
        return new Page([new UserPublic(id: $id, username: $id, display_name: $id)], cursor: $cursor);
    }

    public function testItWalksEveryPageUntilTheCursorRunsOut(): void
    {
        $cursors = [];
        $pages = [
            '' => $this->page('a', 'c1'),
            'c1' => $this->page('b', 'c2'),
            'c2' => $this->page('c', null),
        ];

        $items = Paginator::items(function (?string $cursor) use (&$cursors, $pages): Page {
            $cursors[] = $cursor;

            return $pages[$cursor ?? ''];
        });

        $ids = [];

        foreach ($items as $item) {
            $ids[] = $item->id;
        }

        self::assertSame(['a', 'b', 'c'], $ids);
        self::assertSame([null, 'c1', 'c2'], $cursors);
    }

    public function testBreakingOutEarlyStopsFetching(): void
    {
        // A `foreach` that only wants the first record must not pull the whole collection.
        $calls = 0;

        foreach (Paginator::items(function (?string $cursor) use (&$calls): Page {
            ++$calls;

            return $this->page('page' . $calls, 'more');
        }) as $item) {
            self::assertSame('page1', $item->id);

            break;
        }

        self::assertSame(1, $calls);
    }

    public function testARepeatedCursorStopsInsteadOfLoopingForever(): void
    {
        // A server that keeps handing back the same cursor would otherwise be hammered until the
        // process is killed, so this is a deliberate hard stop.
        $this->expectException(SerializationException::class);
        $this->expectExceptionMessage('Pagination stalled');

        foreach (Paginator::items(fn(?string $cursor): Page => $this->page('x', 'stuck')) as $ignored) {
            // Keep draining until the paginator refuses.
        }
    }

    public function testASinglePageCollectionMakesOneRequest(): void
    {
        $calls = 0;
        $ids = [];

        foreach (Paginator::items(function (?string $cursor) use (&$calls): Page {
            ++$calls;

            return $this->page('only', null);
        }) as $item) {
            $ids[] = $item->id;
        }

        self::assertSame(['only'], $ids);
        self::assertSame(1, $calls);
    }

    public function testPagesYieldsThePageObjectsThemselves(): void
    {
        $pages = [];

        foreach (Paginator::pages(fn(?string $cursor): Page => $this->page('a', null)) as $page) {
            $pages[] = $page;
        }

        self::assertCount(1, $pages);
        self::assertInstanceOf(Page::class, $pages[0]);
    }

    public function testAnEmptyFirstPageEndsTheWalkWithoutItems(): void
    {
        $items = [];

        foreach (Paginator::items(fn(?string $cursor): Page => new Page([])) as $item) {
            $items[] = $item;
        }

        self::assertSame([], $items);
    }
}
