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
 * The `VersusWidgetOptionPayload` schema.
 */
final readonly class VersusWidgetOptionPayload implements DataModel
{
    /**
     * @param list<string> $keywords
     */
    public function __construct(
        public string $id,
        public string $title,
        public array $keywords,
        public string $color,
        public string $image_url,
        public float $base_value,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            id: $reader->requiredString('id'),
            title: $reader->requiredString('title'),
            keywords: $reader->requiredStringList('keywords'),
            color: $reader->requiredString('color'),
            image_url: $reader->requiredString('image_url'),
            base_value: $reader->requiredFloat('base_value'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'id' => [$this->id, true],
            'title' => [$this->title, true],
            'keywords' => [$this->keywords, true],
            'color' => [$this->color, true],
            'image_url' => [$this->image_url, true],
            'base_value' => [$this->base_value, true],
        ]);
    }
}
