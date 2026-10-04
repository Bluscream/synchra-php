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
 * The `BannedTermsTest` schema.
 */
final readonly class BannedTermsTest implements DataModel
{
    /**
     * @param list<BannedTermPayload> $terms
     */
    public function __construct(
        public string $message,
        public array $terms,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            message: $reader->requiredString('message'),
            terms: $reader->requiredModelList('terms', BannedTermPayload::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'message' => [$this->message, true],
            'terms' => [$this->terms, true],
        ]);
    }
}
