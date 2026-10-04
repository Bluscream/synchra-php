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
 * The `CurrencyRates` schema.
 */
final readonly class CurrencyRates implements DataModel
{
    /**
     * @param array<string, mixed> $rates
     */
    public function __construct(
        public string $date,
        public array $rates,
        public ?string $base = 'EUR',
        public ?string $source = null,
        public ?string $source_url = null,
        public ?CryptoCurrencyRates $crypto = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            date: $reader->requiredString('date'),
            rates: $reader->requiredMap('rates'),
            base: $reader->optionalString('base'),
            source: $reader->optionalString('source'),
            source_url: $reader->optionalString('source_url'),
            crypto: $reader->optionalModel('crypto', CryptoCurrencyRates::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'date' => [$this->date, true],
            'rates' => [$this->rates, true],
            'base' => [$this->base, false],
            'source' => [$this->source, false],
            'source_url' => [$this->source_url, false],
            'crypto' => [$this->crypto, true],
        ]);
    }
}
