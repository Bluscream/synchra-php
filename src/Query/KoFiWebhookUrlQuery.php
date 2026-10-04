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
 * Optional filters for `GET /api/2/channels/{channel_id}/kofi/webhook-url`.
 *
 * Every field defaults to null, which means the filter is not sent.
 */
final readonly class KoFiWebhookUrlQuery implements \JsonSerializable
{
    /**
     * @param ?string $provider_channel_id
     */
    public function __construct(
        public ?string $provider_channel_id = null,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'provider_channel_id' => $this->provider_channel_id,
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
