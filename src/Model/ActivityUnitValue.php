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
 * The `ActivityUnitValue` schema.
 */
final readonly class ActivityUnitValue implements DataModel
{
    public function __construct(
        public float $amount,
        public string $currency,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            amount: $reader->requiredFloat('amount'),
            currency: $reader->requiredString('currency'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'amount' => [$this->amount, true],
            'currency' => [$this->currency, true],
        ]);
    }
}
