<?php

declare(strict_types=1);

namespace Synchra\Http;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Synchra\Auth\TokenProvider;
use Synchra\ClientOptions;
use Synchra\Exception\ApiException;
use Synchra\Exception\SerializationException;
use Synchra\Model\Error;
use Synchra\Serialization\Writer;
use Synchra\Synchra;

/**
 * Turns an {@see ApiRequest} into an HTTP exchange: adds credentials, encodes the body, retries
 * what is safe to retry, and converts an error status into the matching exception.
 *
 * The generated resource classes are thin wrappers over this; call it directly to reach an
 * endpoint the vendored description does not cover yet.
 */
final class ApiClient
{
    public function __construct(
        private readonly TokenProvider $tokens,
        private readonly ClientOptions $options,
        private readonly Transport $transport,
        private readonly LoggerInterface $logger = new NullLogger(),
    ) {}

    /**
     * @throws ApiException On any 4xx or 5xx response.
     * @throws \Synchra\Exception\TransportException When no response arrived.
     * @throws SerializationException When a success response is not decodable JSON.
     */
    public function send(ApiRequest $request): ApiResponse
    {
        $uri = $this->uri($request);
        $body = $this->body($request);
        $headers = $this->headers($request, $body !== null);
        $method = \strtoupper($request->method);

        $attempt = 0;

        do {
            ++$attempt;
            $response = $this->transport->send($method, $uri, $headers, $body);

            $this->logger->debug('Synchra {method} {path} -> {status}', [
                'method' => $method,
                'path' => $request->path,
                'status' => $response->status,
                'attempt' => $attempt,
            ]);

            if (!$this->options->retry->shouldRetry($method, $response->status, $attempt)) {
                break;
            }

            $this->options->retry->sleep(
                $this->options->retry->delayMs($attempt, $response->header('retry-after')),
            );
        } while (true);

        if ($response->status >= 400) {
            throw ApiException::forStatus(
                $response->status,
                $this->parseError($response->body),
                $response->body,
                $method,
                $uri,
            );
        }

        return new ApiResponse($response->status, $response->headers, $this->decode($response));
    }

    private function uri(ApiRequest $request): string
    {
        $uri = $this->options->apiBaseUri . '/' . \ltrim($request->path, '/');
        $query = Query::build($request->query);

        return $query === '' ? $uri : $uri . '?' . $query;
    }

    private function body(ApiRequest $request): ?string
    {
        if ($request->rawBody !== null) {
            return $request->rawBody;
        }

        if ($request->body === null) {
            return null;
        }

        return \json_encode(Writer::value($request->body), \JSON_THROW_ON_ERROR | \JSON_UNESCAPED_SLASHES | \JSON_UNESCAPED_UNICODE);
    }

    /** @return array<string, string> */
    private function headers(ApiRequest $request, bool $hasBody): array
    {
        $headers = [
            'Accept' => 'application/json',
            'User-Agent' => \sprintf('synchra-php/%s (+https://github.com/Bluscream/synchra-php)', Synchra::VERSION),
            ...$this->options->headers,
            ...$request->headers,
        ];

        if ($hasBody && !$this->hasHeader($headers, 'content-type')) {
            $headers['Content-Type'] = 'application/json';
        }

        $token = $this->tokens->token();

        if ($token !== null && $token !== '') {
            $headers['Authorization'] = 'Bearer ' . $token;
        }

        return $headers;
    }

    /** @param array<string, string> $headers */
    private function hasHeader(array $headers, string $name): bool
    {
        foreach (\array_keys($headers) as $key) {
            if (\strtolower($key) === $name) {
                return true;
            }
        }

        return false;
    }

    private function decode(TransportResponse $response): mixed
    {
        if ($response->status === 204 || \trim($response->body) === '') {
            return null;
        }

        try {
            return \json_decode($response->body, true, 512, \JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new SerializationException(
                \sprintf('The %d response body is not valid JSON: %s', $response->status, $e->getMessage()),
                0,
                $e,
            );
        }
    }

    /**
     * Parses the standard error envelope, returning null for anything that is not one — a proxy
     * error page, say, which must not mask the real status with a parse failure.
     */
    private function parseError(string $body): ?Error
    {
        try {
            $decoded = \json_decode($body, true, 512, \JSON_THROW_ON_ERROR);
        } catch (\JsonException) {
            return null;
        }

        if (!\is_array($decoded) || \array_is_list($decoded)) {
            return null;
        }

        try {
            /** @var array<string, mixed> $decoded */
            return Error::fromArray($decoded);
        } catch (SerializationException) {
            return null;
        }
    }
}
