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

namespace Synchra\Query;

use Synchra\Enum\ActivityActivityGroup;
use Synchra\Enum\ActivityContributionGroup;

/**
 * Optional filters for `GET /api/2/channels/{channel_id}/activities`.
 *
 * Every field defaults to null, which means the filter is not sent.
 */
final readonly class ActivitiesQuery implements \JsonSerializable
{
    /**
     * @param list<string>|null $type
     * @param list<ActivityActivityGroup>|null $activity_group
     * @param list<ActivityContributionGroup>|null $contribution_group
     * @param list<string>|null $not_type
     * @param list<string>|null $min_count <type>.<min count>.
     * @param ?string $cursor
     * @param ?int $per_page
     */
    public function __construct(
        public ?array $type = null,
        public ?array $activity_group = null,
        public ?array $contribution_group = null,
        public ?array $not_type = null,
        public ?array $min_count = null,
        public ?string $cursor = null,
        public ?int $per_page = null,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'activity_group' => $this->activity_group,
            'contribution_group' => $this->contribution_group,
            'not_type' => $this->not_type,
            'min_count' => $this->min_count,
            'cursor' => $this->cursor,
            'per_page' => $this->per_page,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return \array_filter($this->toArray(), static fn(mixed $v): bool => $v !== null);
    }
}
