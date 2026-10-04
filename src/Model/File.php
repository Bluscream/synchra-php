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

use Synchra\Enum\FileStatus;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `File` schema.
 */
final readonly class File implements DataModel
{
    public function __construct(
        public string $id,
        public \DateTimeImmutable $created_at,
        public ?\DateTimeImmutable $deleted_at,
        public string $owner_id,
        public string $storage_key,
        public FileStatus $status,
        public ?string $original_filename,
        public ?string $extension,
        public ?string $content_type,
        public int $size_bytes,
        public int $reserved_size_bytes,
        public ?string $created_by_user_id,
        public string $url,
        public string $owner_module = 'channel',
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            id: $reader->requiredString('id'),
            created_at: $reader->requiredDateTime('created_at'),
            deleted_at: $reader->optionalDateTime('deleted_at'),
            owner_id: $reader->requiredString('owner_id'),
            storage_key: $reader->requiredString('storage_key'),
            status: $reader->requiredEnum('status', FileStatus::class),
            original_filename: $reader->optionalString('original_filename'),
            extension: $reader->optionalString('extension'),
            content_type: $reader->optionalString('content_type'),
            size_bytes: $reader->requiredInt('size_bytes'),
            reserved_size_bytes: $reader->requiredInt('reserved_size_bytes'),
            created_by_user_id: $reader->optionalString('created_by_user_id'),
            url: $reader->requiredString('url'),
            owner_module: $reader->requiredString('owner_module'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'id' => [$this->id, true],
            'created_at' => [$this->created_at, true],
            'deleted_at' => [$this->deleted_at, true],
            'owner_id' => [$this->owner_id, true],
            'storage_key' => [$this->storage_key, true],
            'status' => [$this->status, true],
            'original_filename' => [$this->original_filename, true],
            'extension' => [$this->extension, true],
            'content_type' => [$this->content_type, true],
            'size_bytes' => [$this->size_bytes, true],
            'reserved_size_bytes' => [$this->reserved_size_bytes, true],
            'created_by_user_id' => [$this->created_by_user_id, true],
            'url' => [$this->url, true],
            'owner_module' => [$this->owner_module, true],
        ]);
    }
}
