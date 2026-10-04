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
 * The `LiveNotificationWebhookUpdate` schema.
 */
final readonly class LiveNotificationWebhookUpdate implements DataModel
{
    /**
     * @param list<LiveNotificationMessage>|null $messages
     * @param list<LiveNotificationImage>|null $image_urls
     * @param list<LiveNotificationVariable>|null $variables
     */
    public function __construct(
        public ?string $title = null,
        public ?bool $enabled = null,
        public ?string $url = null,
        public ?array $messages = null,
        public ?array $image_urls = null,
        public ?array $variables = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            title: $reader->optionalString('title'),
            enabled: $reader->optionalBool('enabled'),
            url: $reader->optionalString('url'),
            messages: $reader->optionalModelList('messages', LiveNotificationMessage::class),
            image_urls: $reader->optionalModelList('image_urls', LiveNotificationImage::class),
            variables: $reader->optionalModelList('variables', LiveNotificationVariable::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'title' => [$this->title, false],
            'enabled' => [$this->enabled, false],
            'url' => [$this->url, false],
            'messages' => [$this->messages, false],
            'image_urls' => [$this->image_urls, false],
            'variables' => [$this->variables, false],
        ]);
    }
}
