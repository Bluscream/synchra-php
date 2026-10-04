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
 * The `CustomWidgetProject` schema.
 */
final readonly class CustomWidgetProject implements DataModel
{
    /**
     * @param array<string, mixed> $files
     */
    public function __construct(
        public string $entry,
        public array $files,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            entry: $reader->requiredString('entry'),
            files: $reader->requiredMap('files'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'entry' => [$this->entry, true],
            'files' => [$this->files, true],
        ]);
    }
}
