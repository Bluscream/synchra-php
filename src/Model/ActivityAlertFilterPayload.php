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
 * The `ActivityAlertFilterPayload` schema.
 */
final readonly class ActivityAlertFilterPayload implements DataModel
{
    /**
     * @param list<string>|null $sub_types
     * @param list<string>|null $message_keywords
     */
    public function __construct(
        public ?float $min_count = null,
        public ?float $max_count = null,
        public ?array $sub_types = null,
        public ?array $message_keywords = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            min_count: $reader->optionalFloat('min_count'),
            max_count: $reader->optionalFloat('max_count'),
            sub_types: $reader->optionalStringList('sub_types'),
            message_keywords: $reader->optionalStringList('message_keywords'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'min_count' => [$this->min_count, true],
            'max_count' => [$this->max_count, true],
            'sub_types' => [$this->sub_types, false],
            'message_keywords' => [$this->message_keywords, false],
        ]);
    }
}
