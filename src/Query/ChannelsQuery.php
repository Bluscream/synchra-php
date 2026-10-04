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
 * Optional filters for `GET /api/2/channels`.
 *
 * Every field defaults to null, which means the filter is not sent.
 */
final readonly class ChannelsQuery implements \JsonSerializable
{
    /**
     * @param ?string $name
     * @param ?string $channel_id
     * @param ?Provider $provider
     * @param ?string $provider_channel_name
     * @param ?string $cursor
     * @param ?int $per_page
     */
    public function __construct(
        public ?string $name = null,
        public ?string $channel_id = null,
        public ?Provider $provider = null,
        public ?string $provider_channel_name = null,
        public ?string $cursor = null,
        public ?int $per_page = null,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'channel_id' => $this->channel_id,
            'provider' => $this->provider,
            'provider_channel_name' => $this->provider_channel_name,
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
