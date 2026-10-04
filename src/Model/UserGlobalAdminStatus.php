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
 * The `UserGlobalAdminStatus` schema.
 */
final readonly class UserGlobalAdminStatus implements DataModel
{
    public function __construct(
        public bool $is_global_admin,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            is_global_admin: $reader->requiredBool('is_global_admin'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'is_global_admin' => [$this->is_global_admin, true],
        ]);
    }
}
