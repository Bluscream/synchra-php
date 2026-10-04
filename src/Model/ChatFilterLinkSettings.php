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
 * The `ChatFilterLinkSettings` schema.
 */
final readonly class ChatFilterLinkSettings implements DataModel
{
    /**
     * @param list<string>|null $allowlist
     */
    public function __construct(
        public ?array $allowlist = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            allowlist: $reader->optionalStringList('allowlist'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'allowlist' => [$this->allowlist, false],
        ]);
    }
}
