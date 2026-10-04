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

use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `AdminChannelSubscription` schema.
 */
final readonly class AdminChannelSubscription implements DataModel
{
    public function __construct(
        public ?string $provider,
        public ?string $status,
        public ?string $customer_url,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            provider: $reader->optionalString('provider'),
            status: $reader->optionalString('status'),
            customer_url: $reader->optionalString('customer_url'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'provider' => [$this->provider, true],
            'status' => [$this->status, true],
            'customer_url' => [$this->customer_url, true],
        ]);
    }
}
