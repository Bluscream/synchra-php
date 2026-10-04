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
 * The `ChannelQuoteUpdate` schema.
 */
final readonly class ChannelQuoteUpdate implements DataModel
{
    public function __construct(
        public ?string $message = null,
        public ?Provider $provider = null,
        public ?string $created_by_provider_viewer_id = null,
        public ?string $created_by_display_name = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            message: $reader->optionalString('message'),
            provider: $reader->optionalEnum('provider', Provider::class),
            created_by_provider_viewer_id: $reader->optionalString('created_by_provider_viewer_id'),
            created_by_display_name: $reader->optionalString('created_by_display_name'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'message' => [$this->message, false],
            'provider' => [$this->provider, false],
            'created_by_provider_viewer_id' => [$this->created_by_provider_viewer_id, false],
            'created_by_display_name' => [$this->created_by_display_name, false],
        ]);
    }
}
