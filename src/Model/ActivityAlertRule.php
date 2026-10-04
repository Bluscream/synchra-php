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
 * The `ActivityAlertRule` schema.
 */
final readonly class ActivityAlertRule implements DataModel
{
    /**
     * @param list<ActivityAlertVariant>|null $variants
     */
    public function __construct(
        public string $name,
        public string $activity_type,
        public ?string $id = null,
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
            name: $reader->requiredString('name'),
            activity_type: $reader->requiredString('activity_type'),
            id: $reader->optionalString('id'),
            enabled: $reader->optionalBool('enabled'),
            variants: $reader->optionalModelList('variants', ActivityAlertVariant::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'name' => [$this->name, true],
            'activity_type' => [$this->activity_type, true],
            'id' => [$this->id, false],
            'enabled' => [$this->enabled, false],
            'variants' => [$this->variants, false],
        ]);
    }
}
