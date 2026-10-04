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

use Synchra\Enum\DisplaySize;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `EmotePartRequest` schema.
 */
final readonly class EmotePartRequest implements DataModel
{
    public function __construct(
        public string $id,
        public string $name,
        public bool $animated,
        public string $emote_provider,
        public ?ImageUrls $urls = null,
        public ?DisplaySize $display_size = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            id: $reader->requiredString('id'),
            name: $reader->requiredString('name'),
            animated: $reader->requiredBool('animated'),
            emote_provider: $reader->requiredString('emote_provider'),
            urls: $reader->optionalModel('urls', ImageUrls::class),
            display_size: $reader->optionalEnum('display_size', DisplaySize::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'id' => [$this->id, true],
            'name' => [$this->name, true],
            'animated' => [$this->animated, true],
            'emote_provider' => [$this->emote_provider, true],
            'urls' => [$this->urls, true],
            'display_size' => [$this->display_size, false],
        ]);
    }
}
