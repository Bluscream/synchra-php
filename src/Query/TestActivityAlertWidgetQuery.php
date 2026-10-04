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
 * Optional filters for `POST /api/2/channels/{channel_id}/widgets/{widget_id}/test-alert`.
 *
 * Every field defaults to null, which means the filter is not sent.
 */
final readonly class TestActivityAlertWidgetQuery implements \JsonSerializable
{
    /**
     * @param ?string $activity_type
     */
    public function __construct(
        public ?string $activity_type = null,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'activity_type' => $this->activity_type,
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
