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

use Synchra\Enum\Provider;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `ActivityAlertTtsAsset` schema.
 */
final readonly class ActivityAlertTtsAsset implements DataModel
{
    /**
     * @param array<string, mixed>|null $provider_settings
     */
    public function __construct(
        public ?string $name = null,
        public ?bool $enabled = null,
        public ?string $channel_provider_id = null,
        public ?Provider $provider = null,
        public ?string $voice_id = null,
        public ?string $voice_trigger = null,
        public ?array $provider_settings = null,
        public ?int $weight = null,
        public ?ActivityAlertFilter $filter = null,
        public ?float $volume = null,
        public ?float $delay_seconds = null,
        public ?float $max_duration_seconds = null,
        public ?bool $read_title = null,
        public ?bool $read_message = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            name: $reader->optionalString('name'),
            enabled: $reader->optionalBool('enabled'),
            channel_provider_id: $reader->optionalString('channel_provider_id'),
            provider: $reader->optionalEnum('provider', Provider::class),
            voice_id: $reader->optionalString('voice_id'),
            voice_trigger: $reader->optionalString('voice_trigger'),
            provider_settings: $reader->optionalMap('provider_settings'),
            weight: $reader->optionalInt('weight'),
            filter: $reader->optionalModel('filter', ActivityAlertFilter::class),
            volume: $reader->optionalFloat('volume'),
            delay_seconds: $reader->optionalFloat('delay_seconds'),
            max_duration_seconds: $reader->optionalFloat('max_duration_seconds'),
            read_title: $reader->optionalBool('read_title'),
            read_message: $reader->optionalBool('read_message'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'name' => [$this->name, false],
            'enabled' => [$this->enabled, false],
            'channel_provider_id' => [$this->channel_provider_id, true],
            'provider' => [$this->provider, true],
            'voice_id' => [$this->voice_id, false],
            'voice_trigger' => [$this->voice_trigger, false],
            'provider_settings' => [$this->provider_settings, false],
            'weight' => [$this->weight, false],
            'filter' => [$this->filter, true],
            'volume' => [$this->volume, false],
            'delay_seconds' => [$this->delay_seconds, false],
            'max_duration_seconds' => [$this->max_duration_seconds, true],
            'read_title' => [$this->read_title, false],
            'read_message' => [$this->read_message, false],
        ]);
    }
}
