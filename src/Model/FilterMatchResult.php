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

use Synchra\Enum\FilterMatchResultAction;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `FilterMatchResult` schema.
 */
final readonly class FilterMatchResult implements DataModel
{
    public function __construct(
        public ChatFilterBase $filter,
        public ?bool $matched = null,
        public ?FilterMatchResultAction $action = null,
        public ?string $sub_id = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            filter: $reader->requiredModel('filter', ChatFilterBase::class),
            matched: $reader->optionalBool('matched'),
            action: $reader->optionalEnum('action', FilterMatchResultAction::class),
            sub_id: $reader->optionalString('sub_id'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'filter' => [$this->filter, true],
            'matched' => [$this->matched, false],
            'action' => [$this->action, true],
            'sub_id' => [$this->sub_id, true],
        ]);
    }
}
