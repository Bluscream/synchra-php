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
 * The `DashboardLayoutSplitNode` schema.
 */
final readonly class DashboardLayoutSplitNode implements DataModel
{
    /**
     * @param list<mixed>|null $children Items carry one of string|DashboardLayoutSplitNode.
     * @param list<float>|null $split_percentages
     */
    public function __construct(
        public ?string $type = 'split',
        public ?DashboardSplitDirection $direction = null,
        public ?array $children = null,
        public ?array $split_percentages = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            type: $reader->optionalString('type'),
            direction: $reader->optionalEnum('direction', DashboardSplitDirection::class),
            children: $reader->optionalMixedList('children'),
            split_percentages: $reader->optionalFloatList('split_percentages'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'type' => [$this->type, false],
            'direction' => [$this->direction, false],
            'children' => [$this->children, false],
            'split_percentages' => [$this->split_percentages, true],
        ]);
    }
}
