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
 * Optional filters for `GET /api/2/widgets/{widget_id}/giveaway`.
 *
 * Every field defaults to null, which means the filter is not sent.
 */
final readonly class WidgetGiveawayQuery implements \JsonSerializable
{
    /**
     * @param ?string $giveaway_id
     */
    public function __construct(
        public ?string $giveaway_id = null,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'giveaway_id' => $this->giveaway_id,
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
