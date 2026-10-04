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
 * The `GiveawayWinnerPick` schema.
 */
final readonly class GiveawayWinnerPick implements DataModel
{
    public function __construct(
        public int $entry_count,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            entry_count: $reader->requiredInt('entry_count'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'entry_count' => [$this->entry_count, true],
        ]);
    }
}
