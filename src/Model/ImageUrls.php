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
 * The `ImageUrls` schema.
 */
final readonly class ImageUrls implements DataModel
{
    public function __construct(
        public string $sm,
        public string $md,
        public string $lg,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            sm: $reader->requiredString('sm'),
            md: $reader->requiredString('md'),
            lg: $reader->requiredString('lg'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'sm' => [$this->sm, true],
            'md' => [$this->md, true],
            'lg' => [$this->lg, true],
        ]);
    }
}
