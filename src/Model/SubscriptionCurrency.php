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
 * The `SubscriptionCurrency` schema.
 */
final readonly class SubscriptionCurrency implements DataModel
{
    public function __construct(
        public string $code,
        public string $name,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            code: $reader->requiredString('code'),
            name: $reader->requiredString('name'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'code' => [$this->code, true],
            'name' => [$this->name, true],
        ]);
    }
}
