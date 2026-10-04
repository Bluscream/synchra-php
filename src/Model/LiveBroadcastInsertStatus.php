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
 * The `LiveBroadcastInsertStatus` schema.
 */
final readonly class LiveBroadcastInsertStatus implements DataModel
{
    public function __construct(
        public string $privacy_status,
        public ?bool $self_declared_made_for_kids,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            privacy_status: $reader->requiredString('privacy_status'),
            self_declared_made_for_kids: $reader->optionalBool('self_declared_made_for_kids'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'privacy_status' => [$this->privacy_status, true],
            'self_declared_made_for_kids' => [$this->self_declared_made_for_kids, true],
        ]);
    }
}
