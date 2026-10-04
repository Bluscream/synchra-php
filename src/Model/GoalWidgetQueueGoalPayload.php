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
 * The `GoalWidgetQueueGoalPayload` schema.
 */
final readonly class GoalWidgetQueueGoalPayload implements DataModel
{
    public function __construct(
        public string $id,
        public string $title,
        public float $goal_value,
        public ?string $image_url = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            id: $reader->requiredString('id'),
            title: $reader->requiredString('title'),
            goal_value: $reader->requiredFloat('goal_value'),
            image_url: $reader->optionalString('image_url'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'id' => [$this->id, true],
            'title' => [$this->title, true],
            'goal_value' => [$this->goal_value, true],
            'image_url' => [$this->image_url, false],
        ]);
    }
}
