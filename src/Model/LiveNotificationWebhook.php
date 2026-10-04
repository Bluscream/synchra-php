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
 * The `LiveNotificationWebhook` schema.
 */
final readonly class LiveNotificationWebhook implements DataModel
{
    /**
     * @param list<LiveNotificationMessage> $messages
     * @param list<LiveNotificationImage> $image_urls
     * @param list<LiveNotificationVariable> $variables
     */
    public function __construct(
        public string $id,
        public string $channel_id,
        public string $title,
        public LiveNotificationWebhookService $service,
        public array $messages,
        public array $image_urls,
        public array $variables,
        public bool $enabled,
        public ?\DateTimeImmutable $last_delivered_at,
        public ?string $last_error,
        public \DateTimeImmutable $created_at,
        public \DateTimeImmutable $updated_at,
        public ?string $url = null,
        public ?string $signing_secret = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            id: $reader->requiredString('id'),
            channel_id: $reader->requiredString('channel_id'),
            title: $reader->requiredString('title'),
            service: $reader->requiredEnum('service', LiveNotificationWebhookService::class),
            messages: $reader->requiredModelList('messages', LiveNotificationMessage::class),
            image_urls: $reader->requiredModelList('image_urls', LiveNotificationImage::class),
            variables: $reader->requiredModelList('variables', LiveNotificationVariable::class),
            enabled: $reader->requiredBool('enabled'),
            last_delivered_at: $reader->optionalDateTime('last_delivered_at'),
            last_error: $reader->optionalString('last_error'),
            created_at: $reader->requiredDateTime('created_at'),
            updated_at: $reader->requiredDateTime('updated_at'),
            url: $reader->optionalString('url'),
            signing_secret: $reader->optionalString('signing_secret'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'id' => [$this->id, true],
            'channel_id' => [$this->channel_id, true],
            'title' => [$this->title, true],
            'service' => [$this->service, true],
            'messages' => [$this->messages, true],
            'image_urls' => [$this->image_urls, true],
            'variables' => [$this->variables, true],
            'enabled' => [$this->enabled, true],
            'last_delivered_at' => [$this->last_delivered_at, true],
            'last_error' => [$this->last_error, true],
            'created_at' => [$this->created_at, true],
            'updated_at' => [$this->updated_at, true],
            'url' => [$this->url, true],
            'signing_secret' => [$this->signing_secret, true],
        ]);
    }
}
