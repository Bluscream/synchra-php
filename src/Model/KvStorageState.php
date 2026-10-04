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
 * The `KvStorageState` schema.
 */
final readonly class KvStorageState implements DataModel
{
    public function __construct(
        public int $storage_limit_bytes,
        public int $bytes_used,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            storage_limit_bytes: $reader->requiredInt('storage_limit_bytes'),
            bytes_used: $reader->requiredInt('bytes_used'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'storage_limit_bytes' => [$this->storage_limit_bytes, true],
            'bytes_used' => [$this->bytes_used, true],
        ]);
    }
}
