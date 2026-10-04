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
 * The `SubscriptionPlan` schema.
 */
final readonly class SubscriptionPlan implements DataModel
{
    /**
     * @param array<string, mixed> $monthly_prices_minor
     * @param array<string, mixed> $limits
     * @param array<string, mixed> $limit_descriptions
     * @param list<string> $benefits
     * @param list<Feature> $features
     */
    public function __construct(
        public PlanKey $key,
        public string $name,
        public string $description,
        public array $monthly_prices_minor,
        public array $limits,
        public array $limit_descriptions,
        public array $benefits,
        public array $features,
        public bool $available,
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
            description: $reader->requiredString('description'),
            monthly_prices_minor: $reader->requiredMap('monthly_prices_minor'),
            limits: $reader->requiredMap('limits'),
            limit_descriptions: $reader->requiredMap('limit_descriptions'),
            benefits: $reader->requiredStringList('benefits'),
            features: $reader->requiredEnumList('features', Feature::class),
            available: $reader->requiredBool('available'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'key' => [$this->key, true],
            'name' => [$this->name, true],
            'description' => [$this->description, true],
            'monthly_prices_minor' => [$this->monthly_prices_minor, true],
            'limits' => [$this->limits, true],
            'limit_descriptions' => [$this->limit_descriptions, true],
            'benefits' => [$this->benefits, true],
            'features' => [$this->features, true],
            'available' => [$this->available, true],
        ]);
    }
}
