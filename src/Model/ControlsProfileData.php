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
 * The `ControlsProfileData` schema.
 */
final readonly class ControlsProfileData implements DataModel
{
    /**
     * @param list<ControlsProfileControl>|null $controls
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
            controls: $reader->optionalModelList('controls', ControlsProfileControl::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'controls' => [$this->controls, false],
        ]);
    }
}
