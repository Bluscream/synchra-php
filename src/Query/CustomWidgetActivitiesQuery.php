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
 * Optional filters for `GET /api/2/widgets/{widget_id}/activities`.
 *
 * Every field defaults to null, which means the filter is not sent.
 */
final readonly class CustomWidgetActivitiesQuery implements \JsonSerializable
{
    /**
     * @param list<string>|null $type
     * @param list<ActivityActivityGroup>|null $activity_group
     * @param list<ActivityContributionGroup>|null $contribution_group
     * @param ?string $cursor
     * @param ?int $per_page
     */
    public function __construct(
        public ?array $type = null,
        public ?array $activity_group = null,
        public ?array $contribution_group = null,
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
