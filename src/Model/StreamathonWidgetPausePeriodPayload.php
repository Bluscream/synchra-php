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
 * The `StreamathonWidgetPausePeriodPayload` schema.
 */
final readonly class StreamathonWidgetPausePeriodPayload implements DataModel
{
    public function __construct(
        public \DateTimeImmutable $started_at,
        public \DateTimeImmutable $ended_at,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            started_at: $reader->requiredDateTime('started_at'),
            ended_at: $reader->requiredDateTime('ended_at'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'started_at' => [$this->started_at, true],
            'ended_at' => [$this->ended_at, true],
        ]);
    }
}
