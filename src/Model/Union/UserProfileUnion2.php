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

use Synchra\Model\ActivityFeedUserProfile;
use Synchra\Model\ChatUserProfile;
use Synchra\Model\ControlsUserProfile;
use Synchra\Model\DashboardUserProfile;
use Synchra\Serialization\Union;

/**
 * Resolves a `UserProfileUnion2` object to the variant named by its `type` field.
 */
final class UserProfileUnion2
{
    public const DISCRIMINATOR = 'type';

    /** @var list<string> */
    public const TAGS = ['dashboard', 'chat', 'activity-feed', 'controls'];

    /**
     * @param array<string, mixed> $data
     *
     * @throws \Synchra\Exception\SerializationException When the tag is missing or unknown.
     */
    public static function fromArray(array $data): DashboardUserProfile|ChatUserProfile|ActivityFeedUserProfile|ControlsUserProfile
    {
        $tag = Union::tag($data, self::DISCRIMINATOR, self::class);

        return match ($tag) {
            'dashboard' => DashboardUserProfile::fromArray($data),
            'chat' => ChatUserProfile::fromArray($data),
            'activity-feed' => ActivityFeedUserProfile::fromArray($data),
            'controls' => ControlsUserProfile::fromArray($data),
            default => throw Union::unknownTag($tag, self::DISCRIMINATOR, self::TAGS, self::class),
        };
    }
}
