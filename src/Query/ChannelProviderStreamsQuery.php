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
use Synchra\Enum\Status;

/**
 * Optional filters for `GET /api/2/channels/{channel_id}/provider-streams`.
 *
 * Every field defaults to null, which means the filter is not sent.
 */
final readonly class ChannelProviderStreamsQuery implements \JsonSerializable
{
    /**
     * @param list<Status>|null $status
     * @param ?Provider $provider
     * @param ?string $cursor
     * @param ?int $per_page
     */
    public function __construct(
        public ?array $status = null,
        public ?Provider $provider = null,
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
