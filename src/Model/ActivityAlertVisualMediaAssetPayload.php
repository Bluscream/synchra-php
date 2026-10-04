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

use Synchra\Enum\Type;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `ActivityAlertVisualMediaAssetPayload` schema.
 */
final readonly class ActivityAlertVisualMediaAssetPayload implements DataModel
{
    public function __construct(
        public ?string $name = null,
        public ?bool $enabled = null,
        public ?string $url = null,
        public ?int $weight = null,
        public ?ActivityAlertFilterPayload $filter = null,
        public ?float $volume = null,
        public ?float $max_duration_seconds = null,
        public ?Type $type = null,
        public ?string $sound_url = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            name: $reader->optionalString('name'),
            enabled: $reader->optionalBool('enabled'),
            url: $reader->optionalString('url'),
            weight: $reader->optionalInt('weight'),
            filter: $reader->optionalModel('filter', ActivityAlertFilterPayload::class),
            volume: $reader->optionalFloat('volume'),
            max_duration_seconds: $reader->optionalFloat('max_duration_seconds'),
            type: $reader->optionalEnum('type', Type::class),
            sound_url: $reader->optionalString('sound_url'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'name' => [$this->name, false],
            'enabled' => [$this->enabled, false],
            'url' => [$this->url, false],
            'weight' => [$this->weight, false],
            'filter' => [$this->filter, true],
            'volume' => [$this->volume, false],
            'max_duration_seconds' => [$this->max_duration_seconds, true],
            'type' => [$this->type, false],
            'sound_url' => [$this->sound_url, false],
        ]);
    }
}
