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

use Synchra\Enum\PlanKey;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `ChannelPlanSettings` schema.
 */
final readonly class ChannelPlanSettings implements DataModel
{
    /**
     * @param array<string, mixed>|null $limit_overrides
     * @param array<string, mixed>|null $feature_overrides
     */
    public function __construct(
        public PlanKey $plan_key,
        public ?array $limit_overrides = null,
        public ?array $feature_overrides = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            plan_key: $reader->requiredEnum('plan_key', PlanKey::class),
            limit_overrides: $reader->optionalMap('limit_overrides'),
            feature_overrides: $reader->optionalMap('feature_overrides'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'plan_key' => [$this->plan_key, true],
            'limit_overrides' => [$this->limit_overrides, false],
            'feature_overrides' => [$this->feature_overrides, false],
        ]);
    }
}
