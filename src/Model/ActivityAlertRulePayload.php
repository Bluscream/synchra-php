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
 * The `ActivityAlertRulePayload` schema.
 */
final readonly class ActivityAlertRulePayload implements DataModel
{
    /**
     * @param list<ActivityAlertVariantPayload>|null $variants
     */
    public function __construct(
        public ?string $id = null,
        public ?string $name = null,
        public ?string $activity_type = null,
        public ?bool $enabled = null,
        public ?array $variants = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            id: $reader->optionalString('id'),
            name: $reader->optionalString('name'),
            activity_type: $reader->optionalString('activity_type'),
            enabled: $reader->optionalBool('enabled'),
            variants: $reader->optionalModelList('variants', ActivityAlertVariantPayload::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'id' => [$this->id, false],
            'name' => [$this->name, false],
            'activity_type' => [$this->activity_type, false],
            'enabled' => [$this->enabled, false],
            'variants' => [$this->variants, false],
        ]);
    }
}
