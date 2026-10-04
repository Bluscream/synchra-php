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
 * The `GoalWidget` schema.
 */
final readonly class GoalWidget implements DataModel
{
    public function __construct(
        public string $id,
        public string $channel_id,
        public string $name,
        public \DateTimeImmutable $created_at,
        public \DateTimeImmutable $updated_at,
        public ?string $type = 'goal_widget',
        public ?\DateTimeImmutable $last_used_at = null,
        public ?GoalWidgetSettings $settings = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            id: $reader->requiredString('id'),
            channel_id: $reader->requiredString('channel_id'),
            name: $reader->requiredString('name'),
            created_at: $reader->requiredDateTime('created_at'),
            updated_at: $reader->requiredDateTime('updated_at'),
            type: $reader->optionalString('type'),
            last_used_at: $reader->optionalDateTime('last_used_at'),
            settings: $reader->optionalModel('settings', GoalWidgetSettings::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'id' => [$this->id, true],
            'channel_id' => [$this->channel_id, true],
            'name' => [$this->name, true],
            'created_at' => [$this->created_at, true],
            'updated_at' => [$this->updated_at, true],
            'type' => [$this->type, false],
            'last_used_at' => [$this->last_used_at, true],
            'settings' => [$this->settings, false],
        ]);
    }
}
