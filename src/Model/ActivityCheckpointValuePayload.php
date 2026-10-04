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
 * The `ActivityCheckpointValuePayload` schema.
 */
final readonly class ActivityCheckpointValuePayload implements DataModel
{
    public function __construct(
        public \DateTimeImmutable $activity_checkpoint_at,
        public float $activity_checkpoint_value,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            activity_checkpoint_at: $reader->requiredDateTime('activity_checkpoint_at'),
            activity_checkpoint_value: $reader->requiredFloat('activity_checkpoint_value'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'activity_checkpoint_at' => [$this->activity_checkpoint_at, true],
            'activity_checkpoint_value' => [$this->activity_checkpoint_value, true],
        ]);
    }
}
