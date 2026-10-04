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
 * The `LiveNotificationEmbed` schema.
 */
final readonly class LiveNotificationEmbed implements DataModel
{
    /**
     * @param list<LiveNotificationEmbedField>|null $fields
     */
    public function __construct(
        public ?string $title = null,
        public ?string $description = null,
        public ?string $url = null,
        public ?string $color = null,
        public ?string $image_url = null,
        public ?string $thumbnail_url = null,
        public ?LiveNotificationEmbedAuthor $author = null,
        public ?LiveNotificationEmbedFooter $footer = null,
        public ?array $fields = null,
        public ?bool $show_timestamp = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            title: $reader->optionalString('title'),
            description: $reader->optionalString('description'),
            url: $reader->optionalString('url'),
            color: $reader->optionalString('color'),
            image_url: $reader->optionalString('image_url'),
            thumbnail_url: $reader->optionalString('thumbnail_url'),
            author: $reader->optionalModel('author', LiveNotificationEmbedAuthor::class),
            footer: $reader->optionalModel('footer', LiveNotificationEmbedFooter::class),
            fields: $reader->optionalModelList('fields', LiveNotificationEmbedField::class),
            show_timestamp: $reader->optionalBool('show_timestamp'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'title' => [$this->title, false],
            'description' => [$this->description, false],
            'url' => [$this->url, true],
            'color' => [$this->color, true],
            'image_url' => [$this->image_url, true],
            'thumbnail_url' => [$this->thumbnail_url, true],
            'author' => [$this->author, true],
            'footer' => [$this->footer, true],
            'fields' => [$this->fields, false],
            'show_timestamp' => [$this->show_timestamp, false],
        ]);
    }
}
