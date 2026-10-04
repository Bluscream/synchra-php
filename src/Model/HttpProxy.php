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

use Synchra\Enum\HttpProxyStatus;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `HttpProxy` schema.
 */
final readonly class HttpProxy implements DataModel
{
    /**
     * @param list<HttpProxyDomain> $domains
     */
    public function __construct(
        public string $id,
        public string $name,
        public string $masked_url,
        public HttpProxyStatus $status,
        public int $failure_count,
        public ?\DateTimeImmutable $retry_at,
        public ?string $last_error,
        public ?\DateTimeImmutable $last_failed_at,
        public ?\DateTimeImmutable $last_success_at,
        public \DateTimeImmutable $created_at,
        public \DateTimeImmutable $updated_at,
        public array $domains,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            id: $reader->requiredString('id'),
            name: $reader->requiredString('name'),
            masked_url: $reader->requiredString('masked_url'),
            status: $reader->requiredEnum('status', HttpProxyStatus::class),
            failure_count: $reader->requiredInt('failure_count'),
            retry_at: $reader->optionalDateTime('retry_at'),
            last_error: $reader->optionalString('last_error'),
            last_failed_at: $reader->optionalDateTime('last_failed_at'),
            last_success_at: $reader->optionalDateTime('last_success_at'),
            created_at: $reader->requiredDateTime('created_at'),
            updated_at: $reader->requiredDateTime('updated_at'),
            domains: $reader->requiredModelList('domains', HttpProxyDomain::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'id' => [$this->id, true],
            'name' => [$this->name, true],
            'masked_url' => [$this->masked_url, true],
            'status' => [$this->status, true],
            'failure_count' => [$this->failure_count, true],
            'retry_at' => [$this->retry_at, true],
            'last_error' => [$this->last_error, true],
            'last_failed_at' => [$this->last_failed_at, true],
            'last_success_at' => [$this->last_success_at, true],
            'created_at' => [$this->created_at, true],
            'updated_at' => [$this->updated_at, true],
            'domains' => [$this->domains, true],
        ]);
    }
}
