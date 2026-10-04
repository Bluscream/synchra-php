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

use Synchra\Enum\ChannelLinkStatsGroupBy;

/**
 * Optional filters for `GET /api/2/channels/{channel_id}/links/{link_id}/views`.
 *
 * Every field defaults to null, which means the filter is not sent.
 */
final readonly class ChannelLinkViewsQuery implements \JsonSerializable
{
    /**
     * @param ?\DateTimeImmutable $from_date
     * @param ?\DateTimeImmutable $to_date
     * @param ?ChannelLinkStatsGroupBy $group_by
     */
    public function __construct(
        public ?\DateTimeImmutable $from_date = null,
        public ?\DateTimeImmutable $to_date = null,
        public ?ChannelLinkStatsGroupBy $group_by = null,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'from_date' => $this->from_date,
            'to_date' => $this->to_date,
            'group_by' => $this->group_by,
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
