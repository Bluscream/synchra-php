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
 * The `UserSummary` schema.
 */
final readonly class UserSummary implements DataModel
{
    /**
     * @param list<UserProviderSummary>|null $providers
     */
    public function __construct(
        public string $id,
        public string $username,
        public string $display_name,
        public ?string $email,
        public bool $is_active,
        public \DateTimeImmutable $created_at,
        public ?array $providers = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            id: $reader->requiredString('id'),
            username: $reader->requiredString('username'),
            display_name: $reader->requiredString('display_name'),
            email: $reader->optionalString('email'),
            is_active: $reader->requiredBool('is_active'),
            created_at: $reader->requiredDateTime('created_at'),
            providers: $reader->optionalModelList('providers', UserProviderSummary::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'id' => [$this->id, true],
            'username' => [$this->username, true],
            'display_name' => [$this->display_name, true],
            'email' => [$this->email, true],
            'is_active' => [$this->is_active, true],
            'created_at' => [$this->created_at, true],
            'providers' => [$this->providers, false],
        ]);
    }
}
