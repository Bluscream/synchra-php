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

use Synchra\Model\ActivityFeedUserProfileUpdate;
use Synchra\Model\ChatUserProfileUpdate;
use Synchra\Model\ControlsUserProfileUpdate;
use Synchra\Model\DashboardUserProfileUpdate;
use Synchra\Serialization\Union;

/**
 * Resolves a `UserProfileUpdateUnion` object to the variant named by its `type` field.
 */
final class UserProfileUpdateUnion
{
    public const DISCRIMINATOR = 'type';

    /** @var list<string> */
    public const TAGS = ['dashboard', 'chat', 'activity-feed', 'controls'];

    /**
     * @param array<string, mixed> $data
     *
     * @throws \Synchra\Exception\SerializationException When the tag is missing or unknown.
     */
    public static function fromArray(array $data): DashboardUserProfileUpdate|ChatUserProfileUpdate|ActivityFeedUserProfileUpdate|ControlsUserProfileUpdate
    {
        $tag = Union::tag($data, self::DISCRIMINATOR, self::class);

        return match ($tag) {
            'dashboard' => DashboardUserProfileUpdate::fromArray($data),
            'chat' => ChatUserProfileUpdate::fromArray($data),
            'activity-feed' => ActivityFeedUserProfileUpdate::fromArray($data),
            'controls' => ControlsUserProfileUpdate::fromArray($data),
            default => throw Union::unknownTag($tag, self::DISCRIMINATOR, self::TAGS, self::class),
        };
    }
}
