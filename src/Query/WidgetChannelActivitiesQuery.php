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

/**
 * Optional filters for `GET /api/2/widgets/{widget_id}/channel-activities`.
 *
 * Every field defaults to null, which means the filter is not sent.
 */
final readonly class WidgetChannelActivitiesQuery implements \JsonSerializable
{
    /**
     * @param ?\DateTimeImmutable $gt_created_at
     * @param ?\DateTimeImmutable $gte_created_at
     * @param ?\DateTimeImmutable $lt_created_at
     * @param ?\DateTimeImmutable $lte_created_at
     * @param ?string $cursor
     * @param ?int $per_page
     */
    public function __construct(
        public ?\DateTimeImmutable $gt_created_at = null,
        public ?\DateTimeImmutable $gte_created_at = null,
        public ?\DateTimeImmutable $lt_created_at = null,
        public ?\DateTimeImmutable $lte_created_at = null,
        public ?string $cursor = null,
        public ?int $per_page = null,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'gt_created_at' => $this->gt_created_at,
            'gte_created_at' => $this->gte_created_at,
            'lt_created_at' => $this->lt_created_at,
            'lte_created_at' => $this->lte_created_at,
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
