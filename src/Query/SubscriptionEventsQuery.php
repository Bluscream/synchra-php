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

use Synchra\Enum\SubscriptionEventStatus;

/**
 * Optional filters for `GET /api/2/admin/subscription-events`.
 *
 * Every field defaults to null, which means the filter is not sent.
 */
final readonly class SubscriptionEventsQuery implements \JsonSerializable
{
    /**
     * @param list<SubscriptionEventStatus>|null $status
     * @param list<string>|null $provider
     * @param list<string>|null $event_type
     * @param ?string $cursor
     * @param ?int $per_page
     */
    public function __construct(
        public ?array $status = null,
        public ?array $provider = null,
        public ?array $event_type = null,
        public ?string $cursor = null,
        public ?int $per_page = null,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'status' => $this->status,
            'provider' => $this->provider,
            'event_type' => $this->event_type,
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
