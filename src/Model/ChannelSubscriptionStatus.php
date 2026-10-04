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

namespace Synchra\Model;

use Synchra\Enum\PlanKey;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `ChannelSubscriptionStatus` schema.
 */
final readonly class ChannelSubscriptionStatus implements DataModel
{
    public function __construct(
        public PlanKey $plan_key,
        public string $status,
        public ?\DateTimeImmutable $current_period_end,
        public ?\DateTimeImmutable $cancel_at,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            plan_key: $reader->requiredEnum('plan_key', PlanKey::class),
            status: $reader->requiredString('status'),
            current_period_end: $reader->optionalDateTime('current_period_end'),
            cancel_at: $reader->optionalDateTime('cancel_at'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'plan_key' => [$this->plan_key, true],
            'status' => [$this->status, true],
            'current_period_end' => [$this->current_period_end, true],
            'cancel_at' => [$this->cancel_at, true],
        ]);
    }
}
