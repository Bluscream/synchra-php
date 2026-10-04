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

use Synchra\Enum\DashboardSplitDirection;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `DashboardLayoutSplitNodePayload` schema.
 */
final readonly class DashboardLayoutSplitNodePayload implements DataModel
{
    /**
     * @param list<mixed> $children Items carry one of string|DashboardLayoutSplitNodePayload.
     * @param list<float>|null $split_percentages
     */
    public function __construct(
        public DashboardSplitDirection $direction,
        public array $children,
        public string $type = 'split',
        public ?array $split_percentages = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            direction: $reader->requiredEnum('direction', DashboardSplitDirection::class),
            children: $reader->requiredMixedList('children'),
            type: $reader->requiredString('type'),
            split_percentages: $reader->optionalFloatList('split_percentages'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'direction' => [$this->direction, true],
            'children' => [$this->children, true],
            'type' => [$this->type, true],
            'split_percentages' => [$this->split_percentages, false],
        ]);
    }
}
