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
 * The `ChannelSubscriptionCheckoutSessionCreate` schema.
 */
final readonly class ChannelSubscriptionCheckoutSessionCreate implements DataModel
{
    public function __construct(
        public PlanKey $plan_key,
        public string $currency,
        public string $request_id,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            plan_key: $reader->requiredEnum('plan_key', PlanKey::class),
            currency: $reader->requiredString('currency'),
            request_id: $reader->requiredString('request_id'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'plan_key' => [$this->plan_key, true],
            'currency' => [$this->currency, true],
            'request_id' => [$this->request_id, true],
        ]);
    }
}
