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
 * The `ChannelViewer` schema.
 */
final readonly class ChannelViewer implements DataModel
{
    public function __construct(
        public ProviderViewer $viewer,
        public ChannelViewerStats $stats,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            viewer: $reader->requiredModel('viewer', ProviderViewer::class),
            stats: $reader->requiredModel('stats', ChannelViewerStats::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'viewer' => [$this->viewer, true],
            'stats' => [$this->stats, true],
        ]);
    }
}
