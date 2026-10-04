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

use Synchra\Enum\LiveNotificationWebhookService;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `LiveNotificationWebhookCreate` schema.
 */
final readonly class LiveNotificationWebhookCreate implements DataModel
{
    /**
     * @param list<LiveNotificationMessage> $messages
     * @param list<LiveNotificationImage>|null $image_urls
     * @param list<LiveNotificationVariable>|null $variables
     */
    public function __construct(
        public string $title,
        public LiveNotificationWebhookService $service,
        public string $url,
        public array $messages,
        public ?bool $enabled = null,
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
            title: $reader->requiredString('title'),
            service: $reader->requiredEnum('service', LiveNotificationWebhookService::class),
            url: $reader->requiredString('url'),
            messages: $reader->requiredModelList('messages', LiveNotificationMessage::class),
            enabled: $reader->optionalBool('enabled'),
            image_urls: $reader->optionalModelList('image_urls', LiveNotificationImage::class),
            variables: $reader->optionalModelList('variables', LiveNotificationVariable::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'title' => [$this->title, true],
            'service' => [$this->service, true],
            'url' => [$this->url, true],
            'messages' => [$this->messages, true],
            'enabled' => [$this->enabled, false],
            'image_urls' => [$this->image_urls, false],
            'variables' => [$this->variables, false],
        ]);
    }
}
