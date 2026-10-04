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
 * The `HttpProxyTestResult` schema.
 */
final readonly class HttpProxyTestResult implements DataModel
{
    /**
     * @param array<string, mixed> $headers
     */
    public function __construct(
        public string $url,
        public ?int $status_code,
        public ?string $reason_phrase,
        public ?string $content_type,
        public array $headers,
        public string $body,
        public bool $truncated,
        public int $elapsed_ms,
        public ?string $error,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            url: $reader->requiredString('url'),
            status_code: $reader->optionalInt('status_code'),
            reason_phrase: $reader->optionalString('reason_phrase'),
            content_type: $reader->optionalString('content_type'),
            headers: $reader->requiredMap('headers'),
            body: $reader->requiredString('body'),
            truncated: $reader->requiredBool('truncated'),
            elapsed_ms: $reader->requiredInt('elapsed_ms'),
            error: $reader->optionalString('error'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'url' => [$this->url, true],
            'status_code' => [$this->status_code, true],
            'reason_phrase' => [$this->reason_phrase, true],
            'content_type' => [$this->content_type, true],
            'headers' => [$this->headers, true],
            'body' => [$this->body, true],
            'truncated' => [$this->truncated, true],
            'elapsed_ms' => [$this->elapsed_ms, true],
            'error' => [$this->error, true],
        ]);
    }
}
