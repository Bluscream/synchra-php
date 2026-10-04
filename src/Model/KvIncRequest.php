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
 * The `KvIncRequest` schema.
 */
final readonly class KvIncRequest implements DataModel
{
    public function __construct(
        public string $key,
        public ?int $amount = null,
        public ?int $ttl = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            key: $reader->requiredString('key'),
            amount: $reader->optionalInt('amount'),
            ttl: $reader->optionalInt('ttl'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'key' => [$this->key, true],
            'amount' => [$this->amount, false],
            'ttl' => [$this->ttl, false],
        ]);
    }
}
