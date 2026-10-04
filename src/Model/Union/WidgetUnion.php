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

use Synchra\Model\ActivityAlertWidget;
use Synchra\Model\ChatWidget;
use Synchra\Model\CustomWidget;
use Synchra\Model\GiveawayWidget;
use Synchra\Model\GoalWidget;
use Synchra\Model\LeaderboardWidget;
use Synchra\Model\StreamathonWidget;
use Synchra\Model\ValueWidget;
use Synchra\Model\VersusWidget;
use Synchra\Model\ViewerCountWidget;
use Synchra\Serialization\Union;

/**
 * Resolves a `WidgetUnion` object to the variant named by its `type` field.
 */
final class WidgetUnion
{
    public const DISCRIMINATOR = 'type';

    /** @var list<string> */
    public const TAGS = ['chat_widget', 'custom_widget', 'activity_alert_widget', 'goal_widget', 'giveaway_widget', 'leaderboard_widget', 'streamathon_widget', 'versus_widget', 'viewer_count_widget', 'value_widget'];

    /**
     * @param array<string, mixed> $data
     *
     * @throws \Synchra\Exception\SerializationException When the tag is missing or unknown.
     */
    public static function fromArray(array $data): ChatWidget|CustomWidget|ActivityAlertWidget|GoalWidget|GiveawayWidget|LeaderboardWidget|StreamathonWidget|VersusWidget|ViewerCountWidget|ValueWidget
    {
        $tag = Union::tag($data, self::DISCRIMINATOR, self::class);

        return match ($tag) {
            'chat_widget' => ChatWidget::fromArray($data),
            'custom_widget' => CustomWidget::fromArray($data),
            'activity_alert_widget' => ActivityAlertWidget::fromArray($data),
            'goal_widget' => GoalWidget::fromArray($data),
            'giveaway_widget' => GiveawayWidget::fromArray($data),
            'leaderboard_widget' => LeaderboardWidget::fromArray($data),
            'streamathon_widget' => StreamathonWidget::fromArray($data),
            'versus_widget' => VersusWidget::fromArray($data),
            'viewer_count_widget' => ViewerCountWidget::fromArray($data),
            'value_widget' => ValueWidget::fromArray($data),
            default => throw Union::unknownTag($tag, self::DISCRIMINATOR, self::TAGS, self::class),
        };
    }
}
