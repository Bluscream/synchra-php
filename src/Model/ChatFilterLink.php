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

use Synchra\Enum\TAccessLevel;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `ChatFilterLink` schema.
 */
final readonly class ChatFilterLink implements DataModel
{
    /**
     * @param list<string> $providers
     */
    public function __construct(
        public string $id,
        public \DateTimeImmutable $created_at,
        public \DateTimeImmutable $updated_at,
        public string $channel_id,
        public string $name,
        public array $providers,
        public bool $enabled,
        public TAccessLevel $exclude_access_level,
        public bool $warning_enabled,
        public string $warning_message,
        public int $warning_expire_duration,
        public string $timeout_message,
        public int $timeout_duration,
        public string $type = 'link',
        public ?ChatFilterLinkSettings $settings = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            id: $reader->requiredString('id'),
            created_at: $reader->requiredDateTime('created_at'),
            updated_at: $reader->requiredDateTime('updated_at'),
            channel_id: $reader->requiredString('channel_id'),
            name: $reader->requiredString('name'),
            providers: $reader->requiredStringList('providers'),
            enabled: $reader->requiredBool('enabled'),
            exclude_access_level: $reader->requiredEnum('exclude_access_level', TAccessLevel::class),
            warning_enabled: $reader->requiredBool('warning_enabled'),
            warning_message: $reader->requiredString('warning_message'),
            warning_expire_duration: $reader->requiredInt('warning_expire_duration'),
            timeout_message: $reader->requiredString('timeout_message'),
            timeout_duration: $reader->requiredInt('timeout_duration'),
            type: $reader->requiredString('type'),
            settings: $reader->optionalModel('settings', ChatFilterLinkSettings::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'id' => [$this->id, true],
            'created_at' => [$this->created_at, true],
            'updated_at' => [$this->updated_at, true],
            'channel_id' => [$this->channel_id, true],
            'name' => [$this->name, true],
            'providers' => [$this->providers, true],
            'enabled' => [$this->enabled, true],
            'exclude_access_level' => [$this->exclude_access_level, true],
            'warning_enabled' => [$this->warning_enabled, true],
            'warning_message' => [$this->warning_message, true],
            'warning_expire_duration' => [$this->warning_expire_duration, true],
            'timeout_message' => [$this->timeout_message, true],
            'timeout_duration' => [$this->timeout_duration, true],
            'type' => [$this->type, true],
            'settings' => [$this->settings, false],
        ]);
    }
}
