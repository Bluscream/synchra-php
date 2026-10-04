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

use Synchra\Enum\DashboardWidgetType;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `DashboardWidgetConfigPayload` schema.
 */
final readonly class DashboardWidgetConfigPayload implements DataModel
{
    public function __construct(
        public string $id,
        public DashboardWidgetType $type,
        public ?string $profile_id = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            id: $reader->requiredString('id'),
            type: $reader->requiredEnum('type', DashboardWidgetType::class),
            profile_id: $reader->optionalString('profile_id'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'id' => [$this->id, true],
            'type' => [$this->type, true],
            'profile_id' => [$this->profile_id, true],
        ]);
    }
}
