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
 * The `LiveNotificationMessageTest` schema.
 */
final readonly class LiveNotificationMessageTest implements DataModel
{
    /**
     * @param list<LiveNotificationImage>|null $image_urls
     * @param list<LiveNotificationVariable>|null $variables
     */
    public function __construct(
        public LiveNotificationWebhookService $service,
        public string $url,
        public LiveNotificationMessage $message,
        public ?string $live_notification_webhook_id = null,
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
            service: $reader->requiredEnum('service', LiveNotificationWebhookService::class),
            url: $reader->requiredString('url'),
            message: $reader->requiredModel('message', LiveNotificationMessage::class),
            live_notification_webhook_id: $reader->optionalString('live_notification_webhook_id'),
            image_urls: $reader->optionalModelList('image_urls', LiveNotificationImage::class),
            variables: $reader->optionalModelList('variables', LiveNotificationVariable::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'service' => [$this->service, true],
            'url' => [$this->url, true],
            'message' => [$this->message, true],
            'live_notification_webhook_id' => [$this->live_notification_webhook_id, false],
            'image_urls' => [$this->image_urls, false],
            'variables' => [$this->variables, false],
        ]);
    }
}
