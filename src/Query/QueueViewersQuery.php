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

use Synchra\Enum\Provider;

/**
 * Optional filters for `GET /api/2/channels/{channel_id}/queues/{channel_queue_id}/viewers`.
 *
 * Every field defaults to null, which means the filter is not sent.
 */
final readonly class QueueViewersQuery implements \JsonSerializable
{
    /**
     * @param ?Provider $provider
     * @param ?string $provider_viewer_id
     * @param ?string $cursor
     * @param ?int $per_page
     */
    public function __construct(
        public ?Provider $provider = null,
        public ?string $provider_viewer_id = null,
        public ?string $cursor = null,
        public ?int $per_page = null,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'provider' => $this->provider,
            'provider_viewer_id' => $this->provider_viewer_id,
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
