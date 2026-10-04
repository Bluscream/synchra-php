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
 * The `ProviderViewer` schema.
 */
final readonly class ProviderViewer implements DataModel
{
    public function __construct(
        public Provider $provider,
        public string $provider_viewer_id,
        public string $name,
        public string $display_name,
        public ?string $profile_picture_url = null,
        public ?\DateTimeImmutable $created_at = null,
        public ?\DateTimeImmutable $followed_at = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            provider: $reader->requiredEnum('provider', Provider::class),
            provider_viewer_id: $reader->requiredString('provider_viewer_id'),
            name: $reader->requiredString('name'),
            display_name: $reader->requiredString('display_name'),
            profile_picture_url: $reader->optionalString('profile_picture_url'),
            created_at: $reader->optionalDateTime('created_at'),
            followed_at: $reader->optionalDateTime('followed_at'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'provider' => [$this->provider, true],
            'provider_viewer_id' => [$this->provider_viewer_id, true],
            'name' => [$this->name, true],
            'display_name' => [$this->display_name, true],
            'profile_picture_url' => [$this->profile_picture_url, true],
            'created_at' => [$this->created_at, true],
            'followed_at' => [$this->followed_at, true],
        ]);
    }
}
