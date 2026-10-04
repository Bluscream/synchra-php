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

use Synchra\Enum\ChatProfileFilterMode;
use Synchra\Enum\Provider;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `ChatProfileProviderFilterPayload` schema.
 */
final readonly class ChatProfileProviderFilterPayload implements DataModel
{
    /**
     * @param list<Provider>|null $values
     */
    public function __construct(
        public ?ChatProfileFilterMode $mode = null,
        public ?array $values = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            mode: $reader->optionalEnum('mode', ChatProfileFilterMode::class),
            values: $reader->optionalEnumList('values', Provider::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'mode' => [$this->mode, false],
            'values' => [$this->values, false],
        ]);
    }
}
