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

use Synchra\Enum\Provider;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `LeaderboardWidgetActivitySourcePayload` schema.
 */
final readonly class LeaderboardWidgetActivitySourcePayload implements DataModel
{
    /**
     * @param array<string, mixed> $sub_type_multipliers
     */
    public function __construct(
        public Provider $provider,
        public string $activity_type,
        public bool $enabled,
        public float $default_multiplier,
        public array $sub_type_multipliers,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            provider: $reader->requiredEnum('provider', Provider::class),
            activity_type: $reader->requiredString('activity_type'),
            enabled: $reader->requiredBool('enabled'),
            default_multiplier: $reader->requiredFloat('default_multiplier'),
            sub_type_multipliers: $reader->requiredMap('sub_type_multipliers'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'provider' => [$this->provider, true],
            'activity_type' => [$this->activity_type, true],
            'enabled' => [$this->enabled, true],
            'default_multiplier' => [$this->default_multiplier, true],
            'sub_type_multipliers' => [$this->sub_type_multipliers, true],
        ]);
    }
}
