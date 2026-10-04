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
 * The `UserProviderPublic` schema.
 */
final readonly class UserProviderPublic implements DataModel
{
    public function __construct(
        public string $id,
        public Provider $provider,
        public string $provider_channel_id,
        public ?string $display_name,
        public ?string $scope,
        public ?bool $chat_scope_needed = null,
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
            provider_channel_id: $reader->requiredString('provider_channel_id'),
            display_name: $reader->optionalString('display_name'),
            scope: $reader->optionalString('scope'),
            chat_scope_needed: $reader->optionalBool('chat_scope_needed'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'id' => [$this->id, true],
            'provider' => [$this->provider, true],
            'provider_channel_id' => [$this->provider_channel_id, true],
            'display_name' => [$this->display_name, true],
            'scope' => [$this->scope, true],
            'chat_scope_needed' => [$this->chat_scope_needed, false],
        ]);
    }
}
