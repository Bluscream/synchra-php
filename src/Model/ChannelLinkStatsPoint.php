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
 * The `ChannelLinkStatsPoint` schema.
 */
final readonly class ChannelLinkStatsPoint implements DataModel
{
    public function __construct(
        public string $x,
        public int $y,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            x: $reader->requiredString('x'),
            y: $reader->requiredInt('y'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'x' => [$this->x, true],
            'y' => [$this->y, true],
        ]);
    }
}
