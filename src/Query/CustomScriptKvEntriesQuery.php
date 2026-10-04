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
 * Optional filters for `GET /api/2/channels/{channel_id}/custom-scripts/kv`.
 *
 * Every field defaults to null, which means the filter is not sent.
 */
final readonly class CustomScriptKvEntriesQuery implements \JsonSerializable
{
    /**
     * @param ?string $cursor
     * @param ?int $per_page
     */
    public function __construct(
        public ?string $cursor = null,
        public ?int $per_page = null,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
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
