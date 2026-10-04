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

use Synchra\Enum\Feature;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `SubscriptionFeatureDefinition` schema.
 */
final readonly class SubscriptionFeatureDefinition implements DataModel
{
    public function __construct(
        public Feature $key,
        public string $label,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            key: $reader->requiredEnum('key', Feature::class),
            label: $reader->requiredString('label'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'key' => [$this->key, true],
            'label' => [$this->label, true],
        ]);
    }
}
