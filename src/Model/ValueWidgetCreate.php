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
 * The `ValueWidgetCreate` schema.
 */
final readonly class ValueWidgetCreate implements DataModel
{
    public function __construct(
        public string $name,
        public string $type = 'value_widget',
        public ?ValueWidgetSettingsPayload $settings = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            name: $reader->requiredString('name'),
            type: $reader->requiredString('type'),
            settings: $reader->optionalModel('settings', ValueWidgetSettingsPayload::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'name' => [$this->name, true],
            'type' => [$this->type, true],
            'settings' => [$this->settings, false],
        ]);
    }
}
