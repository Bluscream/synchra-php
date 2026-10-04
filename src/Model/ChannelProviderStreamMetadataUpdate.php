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
 * The `ChannelProviderStreamMetadataUpdate` schema.
 */
final readonly class ChannelProviderStreamMetadataUpdate implements DataModel
{
    /**
     * @param list<string>|null $stream_tags
     */
    public function __construct(
        public ?string $stream_title = null,
        public ?string $stream_category = null,
        public ?string $stream_category_id = null,
        public ?array $stream_tags = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            stream_title: $reader->optionalString('stream_title'),
            stream_category: $reader->optionalString('stream_category'),
            stream_category_id: $reader->optionalString('stream_category_id'),
            stream_tags: $reader->optionalStringList('stream_tags'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'stream_title' => [$this->stream_title, false],
            'stream_category' => [$this->stream_category, false],
            'stream_category_id' => [$this->stream_category_id, false],
            'stream_tags' => [$this->stream_tags, false],
        ]);
    }
}
