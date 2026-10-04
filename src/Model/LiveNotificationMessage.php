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
 * The `LiveNotificationMessage` schema.
 */
final readonly class LiveNotificationMessage implements DataModel
{
    /**
     * @param list<string>|null $title_patterns
     * @param list<string>|null $categories
     */
    public function __construct(
        public string $text,
        public ?int $chance = null,
        public ?LiveNotificationEmbed $embed = null,
        public ?array $title_patterns = null,
        public ?array $categories = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            text: $reader->requiredString('text'),
            chance: $reader->optionalInt('chance'),
            embed: $reader->optionalModel('embed', LiveNotificationEmbed::class),
            title_patterns: $reader->optionalStringList('title_patterns'),
            categories: $reader->optionalStringList('categories'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'text' => [$this->text, true],
            'chance' => [$this->chance, false],
            'embed' => [$this->embed, true],
            'title_patterns' => [$this->title_patterns, false],
            'categories' => [$this->categories, false],
        ]);
    }
}
