<?php

declare(strict_types=1);

namespace Synchra;

use Synchra\Exception\ConfigurationException;
use Synchra\Http\RetryPolicy;

/**
 * Where to reach Synchra and how to behave while doing so.
 *
 * The defaults target the public API. Point `apiBaseUri` at `https://dash.synchra.net/api/2` to
 * go through the dashboard origin — it serves the same API — or at a local instance when
 * developing against one.
 */
final readonly class ClientOptions
{
    public const DEFAULT_API_BASE_URI = 'https://api.synchra.net/api/2';
    public const DEFAULT_WEBSOCKET_URI = 'wss://api.synchra.net/api/2/ws';

    public string $apiBaseUri;

    /**
     * @param array<string, string> $headers Sent with every request. Do not put credentials
     *                                       here; pass a {@see \Synchra\Auth\TokenProvider}.
     */
    public function __construct(
        string $apiBaseUri = self::DEFAULT_API_BASE_URI,
        public string $webSocketUri = self::DEFAULT_WEBSOCKET_URI,
        public array $headers = [],
        public RetryPolicy $retry = new RetryPolicy(),
    ) {
        $this->apiBaseUri = self::normaliseBaseUri($apiBaseUri);
    }

    /**
     * The same options with a different API root, keeping everything else.
     */
    public function withApiBaseUri(string $apiBaseUri): self
    {
        return new self($apiBaseUri, $this->webSocketUri, $this->headers, $this->retry);
    }

    public function withWebSocketUri(string $webSocketUri): self
    {
        return new self($this->apiBaseUri, $webSocketUri, $this->headers, $this->retry);
    }

    public function withRetry(RetryPolicy $retry): self
    {
        return new self($this->apiBaseUri, $this->webSocketUri, $this->headers, $retry);
    }

    /** @param array<string, string> $headers */
    public function withHeaders(array $headers): self
    {
        return new self($this->apiBaseUri, $this->webSocketUri, [...$this->headers, ...$headers], $this->retry);
    }

    private static function normaliseBaseUri(string $uri): string
    {
        $trimmed = \rtrim(\trim($uri), '/');

        if ($trimmed === '') {
            throw new ConfigurationException('The API base URI cannot be empty.');
        }

        $scheme = \parse_url($trimmed, \PHP_URL_SCHEME);

        if ($scheme !== 'http' && $scheme !== 'https') {
            throw new ConfigurationException(\sprintf(
                'The API base URI must be an absolute http or https URL, got "%s".',
                $uri,
            ));
        }

        return $trimmed;
    }
}
