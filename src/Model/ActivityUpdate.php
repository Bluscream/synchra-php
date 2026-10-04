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
 * The `ActivityUpdate` schema.
 */
final readonly class ActivityUpdate implements DataModel
{
    /**
     * @param list<MentionPartRequest>|null $gifted_viewers
     */
    public function __construct(
        public ?array $gifted_viewers = null,
        public ?bool $read = null,
        public ?int $count = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            gifted_viewers: $reader->optionalModelList('gifted_viewers', MentionPartRequest::class),
            read: $reader->optionalBool('read'),
            count: $reader->optionalInt('count'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'gifted_viewers' => [$this->gifted_viewers, true],
            'read' => [$this->read, false],
            'count' => [$this->count, false],
        ]);
    }
}
