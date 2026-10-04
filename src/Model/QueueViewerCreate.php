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

use Synchra\Enum\Provider;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `QueueViewerCreate` schema.
 */
final readonly class QueueViewerCreate implements DataModel
{
    public function __construct(
        public Provider $provider,
        public string $provider_viewer_id,
        public string $display_name,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            provider: $reader->requiredEnum('provider', Provider::class),
            provider_viewer_id: $reader->requiredString('provider_viewer_id'),
            display_name: $reader->requiredString('display_name'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'provider' => [$this->provider, true],
            'provider_viewer_id' => [$this->provider_viewer_id, true],
            'display_name' => [$this->display_name, true],
        ]);
    }
}
