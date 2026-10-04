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
 * The `KvValueState` schema.
 */
final readonly class KvValueState implements DataModel
{
    /**
     * @param mixed $value Carries one of array<string, mixed>|list<mixed>|string|int|float|bool.
     */
    public function __construct(
        public mixed $value,
        public ?\DateTimeImmutable $expires_at,
        public int $revision,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            value: $reader->mixed('value'),
            expires_at: $reader->optionalDateTime('expires_at'),
            revision: $reader->requiredInt('revision'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'value' => [$this->value, true],
            'expires_at' => [$this->expires_at, true],
            'revision' => [$this->revision, true],
        ]);
    }
}
