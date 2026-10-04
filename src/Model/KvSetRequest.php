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
 * The `KvSetRequest` schema.
 */
final readonly class KvSetRequest implements DataModel
{
    /**
     * @param mixed $value Carries one of array<string, mixed>|list<mixed>|string|int|float|bool.
     */
    public function __construct(
        public string $key,
        public mixed $value,
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
            value: $reader->mixed('value'),
            ttl: $reader->optionalInt('ttl'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'key' => [$this->key, true],
            'value' => [$this->value, true],
            'ttl' => [$this->ttl, false],
        ]);
    }
}
