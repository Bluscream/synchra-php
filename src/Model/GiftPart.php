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

use Synchra\Enum\CurrencyType;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `GiftPart` schema.
 */
final readonly class GiftPart implements DataModel
{
    public function __construct(
        public string $id,
        public string $name,
        public string $type,
        public int $count,
        public ?string $count_display_name = null,
        public ?int $count_decimal_place = null,
        public ?string $count_currency = null,
        public ?CurrencyType $count_currency_type = null,
        public ?bool $animated = null,
        public ?string $image_url = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            id: $reader->requiredString('id'),
            name: $reader->requiredString('name'),
            type: $reader->requiredString('type'),
            count: $reader->requiredInt('count'),
            count_display_name: $reader->optionalString('count_display_name'),
            count_decimal_place: $reader->optionalInt('count_decimal_place'),
            count_currency: $reader->optionalString('count_currency'),
            count_currency_type: $reader->optionalEnum('count_currency_type', CurrencyType::class),
            animated: $reader->optionalBool('animated'),
            image_url: $reader->optionalString('image_url'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'id' => [$this->id, true],
            'name' => [$this->name, true],
            'type' => [$this->type, true],
            'count' => [$this->count, true],
            'count_display_name' => [$this->count_display_name, true],
            'count_decimal_place' => [$this->count_decimal_place, false],
            'count_currency' => [$this->count_currency, true],
            'count_currency_type' => [$this->count_currency_type, false],
            'animated' => [$this->animated, false],
            'image_url' => [$this->image_url, true],
        ]);
    }
}
