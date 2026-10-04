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
 * The `ChatFilterLinkCreate` schema.
 */
final readonly class ChatFilterLinkCreate implements DataModel
{
    /**
     * @param list<string>|null $providers
     */
    public function __construct(
        public ?string $name = null,
        public ?bool $enabled = null,
        public ?array $providers = null,
        public ?TAccessLevel $exclude_access_level = null,
        public ?bool $warning_enabled = null,
        public ?string $warning_message = null,
        public ?int $warning_expire_duration = null,
        public ?string $timeout_message = null,
        public ?int $timeout_duration = null,
        public string $type = 'link',
        public ?ChatFilterLinkSettingsPayload $settings = null,
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
            providers: $reader->optionalStringList('providers'),
            exclude_access_level: $reader->optionalEnum('exclude_access_level', TAccessLevel::class),
            warning_enabled: $reader->optionalBool('warning_enabled'),
            warning_message: $reader->optionalString('warning_message'),
            warning_expire_duration: $reader->optionalInt('warning_expire_duration'),
            timeout_message: $reader->optionalString('timeout_message'),
            timeout_duration: $reader->optionalInt('timeout_duration'),
            type: $reader->requiredString('type'),
            settings: $reader->optionalModel('settings', ChatFilterLinkSettingsPayload::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'name' => [$this->name, false],
            'enabled' => [$this->enabled, false],
            'providers' => [$this->providers, false],
            'exclude_access_level' => [$this->exclude_access_level, false],
            'warning_enabled' => [$this->warning_enabled, false],
            'warning_message' => [$this->warning_message, false],
            'warning_expire_duration' => [$this->warning_expire_duration, false],
            'timeout_message' => [$this->timeout_message, false],
            'timeout_duration' => [$this->timeout_duration, false],
            'type' => [$this->type, true],
            'settings' => [$this->settings, false],
        ]);
    }
}
