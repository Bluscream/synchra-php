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
 * The `LiveNotificationWebhookServiceInfo` schema.
 */
final readonly class LiveNotificationWebhookServiceInfo implements DataModel
{
    /**
     * @param list<string> $setup_steps
     */
    public function __construct(
        public LiveNotificationWebhookService $key,
        public string $name,
        public string $url_placeholder,
        public array $setup_steps,
        public string $documentation_url,
        public bool $signs_requests,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            key: $reader->requiredEnum('key', LiveNotificationWebhookService::class),
            name: $reader->requiredString('name'),
            url_placeholder: $reader->requiredString('url_placeholder'),
            setup_steps: $reader->requiredStringList('setup_steps'),
            documentation_url: $reader->requiredString('documentation_url'),
            signs_requests: $reader->requiredBool('signs_requests'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'key' => [$this->key, true],
            'name' => [$this->name, true],
            'url_placeholder' => [$this->url_placeholder, true],
            'setup_steps' => [$this->setup_steps, true],
            'documentation_url' => [$this->documentation_url, true],
            'signs_requests' => [$this->signs_requests, true],
        ]);
    }
}
