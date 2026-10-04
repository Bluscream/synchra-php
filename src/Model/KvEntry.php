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
 * The `KvEntry` schema.
 */
final readonly class KvEntry implements DataModel
{
    /**
     * @param mixed $value Carries one of array<string, mixed>|list<mixed>|string|int|float|bool.
     */
    public function __construct(
        public string $key,
        public mixed $value,
        public int $size_bytes,
        public ?\DateTimeImmutable $expires_at,
        public \DateTimeImmutable $updated_at,
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
            size_bytes: $reader->requiredInt('size_bytes'),
            expires_at: $reader->optionalDateTime('expires_at'),
            updated_at: $reader->requiredDateTime('updated_at'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'key' => [$this->key, true],
            'value' => [$this->value, true],
            'size_bytes' => [$this->size_bytes, true],
            'expires_at' => [$this->expires_at, true],
            'updated_at' => [$this->updated_at, true],
        ]);
    }
}
