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
 * The `LiveNotificationEmbedField` schema.
 */
final readonly class LiveNotificationEmbedField implements DataModel
{
    public function __construct(
        public string $name,
        public string $value,
        public ?bool $inline = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            name: $reader->requiredString('name'),
            value: $reader->requiredString('value'),
            inline: $reader->optionalBool('inline'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'name' => [$this->name, true],
            'value' => [$this->value, true],
            'inline' => [$this->inline, false],
        ]);
    }
}
