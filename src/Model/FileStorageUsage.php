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
 * The `FileStorageUsage` schema.
 */
final readonly class FileStorageUsage implements DataModel
{
    public function __construct(
        public string $owner_id,
        public int $used_bytes,
        public int $total_bytes,
        public string $owner_module = 'channel',
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            owner_id: $reader->requiredString('owner_id'),
            used_bytes: $reader->requiredInt('used_bytes'),
            total_bytes: $reader->requiredInt('total_bytes'),
            owner_module: $reader->requiredString('owner_module'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'owner_id' => [$this->owner_id, true],
            'used_bytes' => [$this->used_bytes, true],
            'total_bytes' => [$this->total_bytes, true],
            'owner_module' => [$this->owner_module, true],
        ]);
    }
}
