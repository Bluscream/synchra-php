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
 * The `ChannelLinkUpdate` schema.
 */
final readonly class ChannelLinkUpdate implements DataModel
{
    public function __construct(
        public ?string $name = null,
        public ?string $slug = null,
        public ?string $destination_url = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            name: $reader->optionalString('name'),
            slug: $reader->optionalString('slug'),
            destination_url: $reader->optionalString('destination_url'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'name' => [$this->name, false],
            'slug' => [$this->slug, false],
            'destination_url' => [$this->destination_url, false],
        ]);
    }
}
