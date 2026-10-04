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

use Synchra\Model\ActivityAlertWidgetCreate;
use Synchra\Model\ChatWidgetCreate;
use Synchra\Model\CustomWidgetCreate;
use Synchra\Model\GiveawayWidgetCreate;
use Synchra\Model\GoalWidgetCreate;
use Synchra\Model\LeaderboardWidgetCreate;
use Synchra\Model\StreamathonWidgetCreate;
use Synchra\Model\ValueWidgetCreate;
use Synchra\Model\VersusWidgetCreate;
use Synchra\Model\ViewerCountWidgetCreate;
use Synchra\Serialization\Union;

/**
 * Resolves a `WidgetCreateUnion` object to the variant named by its `type` field.
 */
final class WidgetCreateUnion
{
    public const DISCRIMINATOR = 'type';

    /** @var list<string> */
    public const TAGS = ['chat_widget', 'custom_widget', 'activity_alert_widget', 'goal_widget', 'giveaway_widget', 'leaderboard_widget', 'streamathon_widget', 'versus_widget', 'viewer_count_widget', 'value_widget'];

    /**
     * @param array<string, mixed> $data
     *
     * @throws \Synchra\Exception\SerializationException When the tag is missing or unknown.
     */
    public static function fromArray(array $data): ChatWidgetCreate|CustomWidgetCreate|ActivityAlertWidgetCreate|GoalWidgetCreate|GiveawayWidgetCreate|LeaderboardWidgetCreate|StreamathonWidgetCreate|VersusWidgetCreate|ViewerCountWidgetCreate|ValueWidgetCreate
    {
        $tag = Union::tag($data, self::DISCRIMINATOR, self::class);

        return match ($tag) {
            'chat_widget' => ChatWidgetCreate::fromArray($data),
            'custom_widget' => CustomWidgetCreate::fromArray($data),
            'activity_alert_widget' => ActivityAlertWidgetCreate::fromArray($data),
            'goal_widget' => GoalWidgetCreate::fromArray($data),
            'giveaway_widget' => GiveawayWidgetCreate::fromArray($data),
            'leaderboard_widget' => LeaderboardWidgetCreate::fromArray($data),
            'streamathon_widget' => StreamathonWidgetCreate::fromArray($data),
            'versus_widget' => VersusWidgetCreate::fromArray($data),
            'viewer_count_widget' => ViewerCountWidgetCreate::fromArray($data),
            'value_widget' => ValueWidgetCreate::fromArray($data),
            default => throw Union::unknownTag($tag, self::DISCRIMINATOR, self::TAGS, self::class),
        };
    }
}
