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
 * The `LiveBroadcastInsertSnippet` schema.
 */
final readonly class LiveBroadcastInsertSnippet implements DataModel
{
    public function __construct(
        public string $title,
        public ?string $scheduled_start_time,
        public ?string $description,
        public ?string $scheduled_end_time,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            title: $reader->requiredString('title'),
            scheduled_start_time: $reader->optionalString('scheduled_start_time'),
            description: $reader->optionalString('description'),
            scheduled_end_time: $reader->optionalString('scheduled_end_time'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'title' => [$this->title, true],
            'scheduled_start_time' => [$this->scheduled_start_time, true],
            'description' => [$this->description, true],
            'scheduled_end_time' => [$this->scheduled_end_time, true],
        ]);
    }
}
