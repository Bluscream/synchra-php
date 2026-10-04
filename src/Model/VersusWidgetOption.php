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
 * The `VersusWidgetOption` schema.
 */
final readonly class VersusWidgetOption implements DataModel
{
    /**
     * @param list<string>|null $keywords
     */
    public function __construct(
        public ?string $id = null,
        public ?string $title = null,
        public ?array $keywords = null,
        public ?string $color = null,
        public ?string $image_url = null,
        public ?float $base_value = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            id: $reader->optionalString('id'),
            title: $reader->optionalString('title'),
            keywords: $reader->optionalStringList('keywords'),
            color: $reader->optionalString('color'),
            image_url: $reader->optionalString('image_url'),
            base_value: $reader->optionalFloat('base_value'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'id' => [$this->id, false],
            'title' => [$this->title, false],
            'keywords' => [$this->keywords, false],
            'color' => [$this->color, false],
            'image_url' => [$this->image_url, false],
            'base_value' => [$this->base_value, false],
        ]);
    }
}
