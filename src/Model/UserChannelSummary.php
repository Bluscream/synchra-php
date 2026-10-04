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

use Synchra\Enum\TAccessLevel;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `UserChannelSummary` schema.
 */
final readonly class UserChannelSummary implements DataModel
{
    public function __construct(
        public string $id,
        public string $display_name,
        public TAccessLevel $access_level,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            id: $reader->requiredString('id'),
            display_name: $reader->requiredString('display_name'),
            access_level: $reader->requiredEnum('access_level', TAccessLevel::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'id' => [$this->id, true],
            'display_name' => [$this->display_name, true],
            'access_level' => [$this->access_level, true],
        ]);
    }
}
