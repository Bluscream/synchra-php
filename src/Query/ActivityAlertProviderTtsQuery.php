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

use Synchra\Enum\Format;

/**
 * Optional filters for `GET /api/2/widgets/{widget_id}/activity-alert-provider-tts`.
 *
 * Every field defaults to null, which means the filter is not sent.
 */
final readonly class ActivityAlertProviderTtsQuery implements \JsonSerializable
{
    /**
     * @param ?string $settings
     * @param ?Format $format
     */
    public function __construct(
        public ?string $settings = null,
        public ?Format $format = null,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'settings' => $this->settings,
            'format' => $this->format,
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
