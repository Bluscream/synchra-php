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
use Synchra\Enum\PlanKey;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `ChannelPlan` schema.
 */
final readonly class ChannelPlan implements DataModel
{
    /**
     * @param list<Feature> $features
     * @param array<string, mixed> $limits
     */
    public function __construct(
        public PlanKey $key,
        public string $name,
        public array $features,
        public array $limits,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            key: $reader->requiredEnum('key', PlanKey::class),
            name: $reader->requiredString('name'),
            features: $reader->requiredEnumList('features', Feature::class),
            limits: $reader->requiredMap('limits'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'key' => [$this->key, true],
            'name' => [$this->name, true],
            'features' => [$this->features, true],
            'limits' => [$this->limits, true],
        ]);
    }
}
