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
 * The `SubscriptionPlans` schema.
 */
final readonly class SubscriptionPlans implements DataModel
{
    /**
     * @param list<SubscriptionCurrency> $currencies
     * @param list<SubscriptionPlan> $plans
     * @param list<SubscriptionLimitDefinition> $limit_definitions
     * @param list<SubscriptionFeatureDefinition> $feature_definitions
     */
    public function __construct(
        public string $default_currency,
        public array $currencies,
        public array $plans,
        public array $limit_definitions,
        public array $feature_definitions,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            default_currency: $reader->requiredString('default_currency'),
            currencies: $reader->requiredModelList('currencies', SubscriptionCurrency::class),
            plans: $reader->requiredModelList('plans', SubscriptionPlan::class),
            limit_definitions: $reader->requiredModelList('limit_definitions', SubscriptionLimitDefinition::class),
            feature_definitions: $reader->requiredModelList('feature_definitions', SubscriptionFeatureDefinition::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'default_currency' => [$this->default_currency, true],
            'currencies' => [$this->currencies, true],
            'plans' => [$this->plans, true],
            'limit_definitions' => [$this->limit_definitions, true],
            'feature_definitions' => [$this->feature_definitions, true],
        ]);
    }
}
