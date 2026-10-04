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
 * The `ActivityFeedUserProfile` schema.
 */
final readonly class ActivityFeedUserProfile implements DataModel
{
    public function __construct(
        public string $id,
        public string $user_id,
        public string $name,
        public string $sort_order,
        public ActivityFeedProfileData $data,
        public \DateTimeImmutable $created_at,
        public \DateTimeImmutable $updated_at,
        public string $type = 'activity-feed',
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            id: $reader->requiredString('id'),
            user_id: $reader->requiredString('user_id'),
            name: $reader->requiredString('name'),
            sort_order: $reader->requiredString('sort_order'),
            data: $reader->requiredModel('data', ActivityFeedProfileData::class),
            created_at: $reader->requiredDateTime('created_at'),
            updated_at: $reader->requiredDateTime('updated_at'),
            type: $reader->requiredString('type'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'id' => [$this->id, true],
            'user_id' => [$this->user_id, true],
            'name' => [$this->name, true],
            'sort_order' => [$this->sort_order, true],
            'data' => [$this->data, true],
            'created_at' => [$this->created_at, true],
            'updated_at' => [$this->updated_at, true],
            'type' => [$this->type, true],
        ]);
    }
}
