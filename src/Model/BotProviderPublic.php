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
 * The `BotProviderPublic` schema.
 */
final readonly class BotProviderPublic implements DataModel
{
    public function __construct(
        public string $id,
        public Provider $provider,
        public bool $scope_needed,
        public ?string $provider_channel_id = null,
        public ?string $name = null,
        public ?bool $system_default = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            id: $reader->requiredString('id'),
            provider: $reader->requiredEnum('provider', Provider::class),
            scope_needed: $reader->requiredBool('scope_needed'),
            provider_channel_id: $reader->optionalString('provider_channel_id'),
            name: $reader->optionalString('name'),
            system_default: $reader->optionalBool('system_default'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'id' => [$this->id, true],
            'provider' => [$this->provider, true],
            'scope_needed' => [$this->scope_needed, true],
            'provider_channel_id' => [$this->provider_channel_id, true],
            'name' => [$this->name, true],
            'system_default' => [$this->system_default, false],
        ]);
    }
}
