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
 * The `ChannelLinkStats` schema.
 */
final readonly class ChannelLinkStats implements DataModel
{
    public function __construct(
        public int $visitors,
        public int $visits,
        public int $views,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            visitors: $reader->requiredInt('visitors'),
            visits: $reader->requiredInt('visits'),
            views: $reader->requiredInt('views'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'visitors' => [$this->visitors, true],
            'visits' => [$this->visits, true],
            'views' => [$this->views, true],
        ]);
    }
}
