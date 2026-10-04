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
 * The `ActivityAlertTtsPack` schema.
 */
final readonly class ActivityAlertTtsPack implements DataModel
{
    /**
     * @param list<ActivityAlertTtsAsset>|null $tts
     */
    public function __construct(
        public ?string $id = null,
        public ?string $name = null,
        public ?array $tts = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            id: $reader->optionalString('id'),
            name: $reader->optionalString('name'),
            tts: $reader->optionalModelList('tts', ActivityAlertTtsAsset::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'id' => [$this->id, false],
            'name' => [$this->name, false],
            'tts' => [$this->tts, false],
        ]);
    }
}
