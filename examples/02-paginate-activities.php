<?php

declare(strict_types=1);

/*
 * Walk a channel's activity feed, page by page, lazily.
 *
 *   SYNCHRA_TOKEN=… php examples/02-paginate-activities.php [channel-id] [limit]
 *
 * Without a channel id it uses the first channel the token can see.
 */

require __DIR__ . '/../vendor/autoload.php';

use Synchra\Exception\SynchraException;
use Synchra\Pagination\Paginator;
use Synchra\Query\ActivitiesQuery;
use Synchra\Synchra;

$synchra = Synchra::fromEnvironment();
$channelId = $argv[1] ?? null;
$limit = (int) ($argv[2] ?? 25);

try {
    if ($channelId === null) {
        $channel = $synchra->channel()->getChannels()->first();

        if ($channel === null) {
            \fwrite(\STDERR, "This token can see no channels; pass a channel id.\n");

            exit(1);
        }

        $channelId = $channel->id;
        \printf("Using channel %s (%s)\n\n", $channelId, $channel->display_name);
    }

    $seen = 0;

    // The paginator asks for the next page only when this loop needs one, so breaking out early
    // stops making requests.
    foreach (Paginator::items(fn(?string $cursor) => $synchra->channelActivity()->getActivities(
        $channelId,
        new ActivitiesQuery(per_page: 50, cursor: $cursor),
    )) as $activity) {
        \printf(
            "%-24s %-20s %s\n",
            $activity->created_at->format('Y-m-d H:i:s'),
            $activity->type,
            $activity->viewer_display_name,
        );

        if (++$seen >= $limit) {
            break;
        }
    }

    \printf("\n%d activities.\n", $seen);
} catch (SynchraException $e) {
    \fwrite(\STDERR, 'Synchra said no: ' . $e->getMessage() . "\n");

    exit(1);
}
