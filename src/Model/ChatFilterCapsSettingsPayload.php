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
 * The `ChatFilterCapsSettingsPayload` schema.
 */
final readonly class ChatFilterCapsSettingsPayload implements DataModel
{
    public function __construct(
        public ?int $min_length = null,
        public ?int $max_percent = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            min_length: $reader->optionalInt('min_length'),
            max_percent: $reader->optionalInt('max_percent'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'min_length' => [$this->min_length, false],
            'max_percent' => [$this->max_percent, false],
        ]);
    }
}
