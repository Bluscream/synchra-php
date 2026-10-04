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
 * The `ActivityCheckpointOptionValuesPayload` schema.
 */
final readonly class ActivityCheckpointOptionValuesPayload implements DataModel
{
    /**
     * @param array<string, mixed> $activity_checkpoint_option_values
     */
    public function __construct(
        public \DateTimeImmutable $activity_checkpoint_at,
        public array $activity_checkpoint_option_values,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            activity_checkpoint_at: $reader->requiredDateTime('activity_checkpoint_at'),
            activity_checkpoint_option_values: $reader->requiredMap('activity_checkpoint_option_values'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'activity_checkpoint_at' => [$this->activity_checkpoint_at, true],
            'activity_checkpoint_option_values' => [$this->activity_checkpoint_option_values, true],
        ]);
    }
}
