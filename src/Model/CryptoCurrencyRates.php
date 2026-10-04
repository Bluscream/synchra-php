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
 * The `CryptoCurrencyRates` schema.
 */
final readonly class CryptoCurrencyRates implements DataModel
{
    /**
     * @param array<string, mixed> $rates
     */
    public function __construct(
        public array $rates,
        public \DateTimeImmutable $updated_at,
        public ?string $source = null,
        public ?string $source_url = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            rates: $reader->requiredMap('rates'),
            updated_at: $reader->requiredDateTime('updated_at'),
            source: $reader->optionalString('source'),
            source_url: $reader->optionalString('source_url'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'rates' => [$this->rates, true],
            'updated_at' => [$this->updated_at, true],
            'source' => [$this->source, false],
            'source_url' => [$this->source_url, false],
        ]);
    }
}
