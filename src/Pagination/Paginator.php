<?php

declare(strict_types=1);

namespace Synchra\Pagination;

use Synchra\Exception\SerializationException;
use Synchra\Serialization\DataModel;

/**
 * Walks a cursor-paginated endpoint.
 *
 * Pass a callback that fetches one page for a given cursor; the generator requests the next page
 * only when the consumer asks for an item past the end of the current one, so a `foreach` that
 * breaks early stops making requests.
 *
 * ```php
 * foreach (Paginator::items(fn (?string $cursor) => $synchra->channelActivity()
 *     ->getActivities($channelId, new ActivitiesQuery(perPage: 100, cursor: $cursor))) as $activity) {
 *     echo $activity->type, "\n";
 * }
 * ```
 */
final class Paginator
{
    /**
     * @template T of DataModel
     *
     * @param callable(?string): Page<T> $fetch
     *
     * @return \Generator<int, T>
     */
    public static function items(callable $fetch): \Generator
    {
        foreach (self::pages($fetch) as $page) {
            yield from $page->records;
        }
    }

    /**
     * @template T of DataModel
     *
     * @param callable(?string): Page<T> $fetch
     *
     * @return \Generator<int, Page<T>>
     */
    public static function pages(callable $fetch): \Generator
    {
        $cursor = null;
        $seen = [];

        do {
            $page = $fetch($cursor);

            yield $page;

            $cursor = $page->cursor;

            if ($cursor === null || $cursor === '') {
                return;
            }

            // A cursor that repeats means the server is not advancing; looping forever on it
            // would hammer the API, so stop and say what happened.
            if (isset($seen[$cursor])) {
                throw new SerializationException(\sprintf(
                    'Pagination stalled: the API returned cursor "%s" twice.',
                    $cursor,
                ));
            }

            $seen[$cursor] = true;
        } while (true);
    }
}
