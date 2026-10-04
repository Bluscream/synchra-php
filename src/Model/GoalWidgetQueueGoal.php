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
 * The `GoalWidgetQueueGoal` schema.
 */
final readonly class GoalWidgetQueueGoal implements DataModel
{
    public function __construct(
        public ?string $id = null,
        public ?string $title = null,
        public ?float $goal_value = null,
        public ?string $image_url = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            id: $reader->optionalString('id'),
            title: $reader->optionalString('title'),
            goal_value: $reader->optionalFloat('goal_value'),
            image_url: $reader->optionalString('image_url'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'id' => [$this->id, false],
            'title' => [$this->title, false],
            'goal_value' => [$this->goal_value, false],
            'image_url' => [$this->image_url, false],
        ]);
    }
}
