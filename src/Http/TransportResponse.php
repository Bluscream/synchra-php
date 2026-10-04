<?php

declare(strict_types=1);

namespace Synchra\Http;

/**
 * A raw HTTP response, before any JSON decoding or error mapping.
 */
final readonly class TransportResponse
{
    /** @param array<string, list<string>> $headers Header names lowercased. */
    public function __construct(
        public int $status,
        public array $headers,
        public string $body,
    ) {}

    public function header(string $name): ?string
    {
        return ($this->headers[\strtolower($name)] ?? [])[0] ?? null;
    }
}
