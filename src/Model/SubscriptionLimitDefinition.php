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

use Synchra\Enum\LimitKey;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `SubscriptionLimitDefinition` schema.
 */
final readonly class SubscriptionLimitDefinition implements DataModel
{
    public function __construct(
        public LimitKey $key,
        public string $label,
        public string $unit,
        public ?string $singular_label,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            key: $reader->requiredEnum('key', LimitKey::class),
            label: $reader->requiredString('label'),
            unit: $reader->requiredString('unit'),
            singular_label: $reader->optionalString('singular_label'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'key' => [$this->key, true],
            'label' => [$this->label, true],
            'unit' => [$this->unit, true],
            'singular_label' => [$this->singular_label, true],
        ]);
    }
}
