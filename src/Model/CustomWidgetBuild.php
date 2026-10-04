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
 * The `CustomWidgetBuild` schema.
 */
final readonly class CustomWidgetBuild implements DataModel
{
    public function __construct(
        public string $javascript,
        public string $css,
        public string $html,
        public string $source_map,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            javascript: $reader->requiredString('javascript'),
            css: $reader->requiredString('css'),
            html: $reader->requiredString('html'),
            source_map: $reader->requiredString('source_map'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'javascript' => [$this->javascript, true],
            'css' => [$this->css, true],
            'html' => [$this->html, true],
            'source_map' => [$this->source_map, true],
        ]);
    }
}
