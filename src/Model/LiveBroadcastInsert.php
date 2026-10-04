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
 * The `LiveBroadcastInsert` schema.
 */
final readonly class LiveBroadcastInsert implements DataModel
{
    public function __construct(
        public LiveBroadcastInsertSnippet $snippet,
        public LiveBroadcastInsertStatus $status,
        public ?LiveBroadcastInsertContentDetails $content_details,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            snippet: $reader->requiredModel('snippet', LiveBroadcastInsertSnippet::class),
            status: $reader->requiredModel('status', LiveBroadcastInsertStatus::class),
            content_details: $reader->optionalModel('content_details', LiveBroadcastInsertContentDetails::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'snippet' => [$this->snippet, true],
            'status' => [$this->status, true],
            'content_details' => [$this->content_details, true],
        ]);
    }
}
