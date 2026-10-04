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
 * The `ControlsProfileDataPayload` schema.
 */
final readonly class ControlsProfileDataPayload implements DataModel
{
    /**
     * @param list<ControlsProfileControlPayload>|null $controls
     */
    public function __construct(
        public ?array $controls = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            controls: $reader->optionalModelList('controls', ControlsProfileControlPayload::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'controls' => [$this->controls, false],
        ]);
    }
}
