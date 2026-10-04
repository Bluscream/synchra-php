<?php

/*
 * This file is generated — do not edit it by hand.
 *
 * Source:    spec/openapi.json (and spec/websocket.md for the gateway)
 * Generator: tools/generate.php
 *
 * To pick up an API change: ./tools/fetch-spec.sh && composer generate
 */

declare(strict_types=1);

namespace Synchra\Model\Union;

use Synchra\Model\ActivityAlertWidgetUpdate;
use Synchra\Model\ChatWidgetUpdate;
use Synchra\Model\CustomWidgetUpdate;
use Synchra\Model\GiveawayWidgetUpdate;
use Synchra\Model\GoalWidgetUpdate;
use Synchra\Model\LeaderboardWidgetUpdate;
use Synchra\Model\StreamathonWidgetUpdate;
use Synchra\Model\ValueWidgetUpdate;
use Synchra\Model\VersusWidgetUpdate;
use Synchra\Model\ViewerCountWidgetUpdate;
use Synchra\Serialization\Union;

/**
 * Resolves a `WidgetUpdateUnion` object to the variant named by its `type` field.
 */
final class WidgetUpdateUnion
{
    public const DISCRIMINATOR = 'type';

    /** @var list<string> */
    public const TAGS = ['chat_widget', 'custom_widget', 'activity_alert_widget', 'goal_widget', 'giveaway_widget', 'leaderboard_widget', 'streamathon_widget', 'versus_widget', 'viewer_count_widget', 'value_widget'];

    /**
     * @param array<string, mixed> $data
     *
     * @throws \Synchra\Exception\SerializationException When the tag is missing or unknown.
     */
    public static function fromArray(array $data): ChatWidgetUpdate|CustomWidgetUpdate|ActivityAlertWidgetUpdate|GoalWidgetUpdate|GiveawayWidgetUpdate|LeaderboardWidgetUpdate|StreamathonWidgetUpdate|VersusWidgetUpdate|ViewerCountWidgetUpdate|ValueWidgetUpdate
    {
        $tag = Union::tag($data, self::DISCRIMINATOR, self::class);

        return match ($tag) {
            'chat_widget' => ChatWidgetUpdate::fromArray($data),
            'custom_widget' => CustomWidgetUpdate::fromArray($data),
            'activity_alert_widget' => ActivityAlertWidgetUpdate::fromArray($data),
            'goal_widget' => GoalWidgetUpdate::fromArray($data),
            'giveaway_widget' => GiveawayWidgetUpdate::fromArray($data),
            'leaderboard_widget' => LeaderboardWidgetUpdate::fromArray($data),
            'streamathon_widget' => StreamathonWidgetUpdate::fromArray($data),
            'versus_widget' => VersusWidgetUpdate::fromArray($data),
            'viewer_count_widget' => ViewerCountWidgetUpdate::fromArray($data),
            'value_widget' => ValueWidgetUpdate::fromArray($data),
            default => throw Union::unknownTag($tag, self::DISCRIMINATOR, self::TAGS, self::class),
        };
    }
}
