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
 * The `HttpProxyDomain` schema.
 */
final readonly class HttpProxyDomain implements DataModel
{
    public function __construct(
        public string $domain,
        public HttpProxyStatus $status,
        public int $failure_count,
        public ?\DateTimeImmutable $retry_at,
        public ?string $last_error,
        public ?\DateTimeImmutable $last_failed_at,
        public ?\DateTimeImmutable $last_success_at,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            domain: $reader->requiredString('domain'),
            status: $reader->requiredEnum('status', HttpProxyStatus::class),
            failure_count: $reader->requiredInt('failure_count'),
            retry_at: $reader->optionalDateTime('retry_at'),
            last_error: $reader->optionalString('last_error'),
            last_failed_at: $reader->optionalDateTime('last_failed_at'),
            last_success_at: $reader->optionalDateTime('last_success_at'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'domain' => [$this->domain, true],
            'status' => [$this->status, true],
            'failure_count' => [$this->failure_count, true],
            'retry_at' => [$this->retry_at, true],
            'last_error' => [$this->last_error, true],
            'last_failed_at' => [$this->last_failed_at, true],
            'last_success_at' => [$this->last_success_at, true],
        ]);
    }
}
