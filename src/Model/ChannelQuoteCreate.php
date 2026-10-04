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
 * The `ChannelQuoteCreate` schema.
 */
final readonly class ChannelQuoteCreate implements DataModel
{
    public function __construct(
        public string $message,
        public Provider $provider,
        public string $created_by_display_name,
        public ?string $created_by_provider_viewer_id = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            message: $reader->requiredString('message'),
            provider: $reader->requiredEnum('provider', Provider::class),
            created_by_display_name: $reader->requiredString('created_by_display_name'),
            created_by_provider_viewer_id: $reader->optionalString('created_by_provider_viewer_id'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'message' => [$this->message, true],
            'provider' => [$this->provider, true],
            'created_by_display_name' => [$this->created_by_display_name, true],
            'created_by_provider_viewer_id' => [$this->created_by_provider_viewer_id, false],
        ]);
    }
}
