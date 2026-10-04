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

use Synchra\Enum\ActivityActivityGroup;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `CommandActivityTrigger` schema.
 */
final readonly class CommandActivityTrigger implements DataModel
{
    /**
     * @param list<string> $activity_types
     * @param list<ActivityActivityGroup> $activity_groups
     * @param list<string> $sub_types
     * @param list<string> $message_keywords
     */
    public function __construct(
        public string $id,
        public string $name,
        public bool $enabled,
        public array $activity_types,
        public array $activity_groups,
        public array $sub_types,
        public ?int $min_count,
        public ?int $max_count,
        public array $message_keywords,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            id: $reader->requiredString('id'),
            name: $reader->requiredString('name'),
            enabled: $reader->requiredBool('enabled'),
            activity_types: $reader->requiredStringList('activity_types'),
            activity_groups: $reader->requiredEnumList('activity_groups', ActivityActivityGroup::class),
            sub_types: $reader->requiredStringList('sub_types'),
            min_count: $reader->optionalInt('min_count'),
            max_count: $reader->optionalInt('max_count'),
            message_keywords: $reader->requiredStringList('message_keywords'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'id' => [$this->id, true],
            'name' => [$this->name, true],
            'enabled' => [$this->enabled, true],
            'activity_types' => [$this->activity_types, true],
            'activity_groups' => [$this->activity_groups, true],
            'sub_types' => [$this->sub_types, true],
            'min_count' => [$this->min_count, true],
            'max_count' => [$this->max_count, true],
            'message_keywords' => [$this->message_keywords, true],
        ]);
    }
}
