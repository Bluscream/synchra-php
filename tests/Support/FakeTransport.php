<?php

declare(strict_types=1);

namespace Synchra\Tests\Support;

use Synchra\Exception\TransportException;
use Synchra\Http\Transport;
use Synchra\Http\TransportResponse;

/**
 * A transport that answers from a queue and records what it was asked.
 *
 * Every test that exercises the request path uses this instead of a real HTTP client, so the unit
 * suite never reaches the network and the assertions can be about the exact bytes the SDK would
 * have put on the wire.
 */
final class FakeTransport implements Transport
{
    /** @var list<TransportResponse> */
    private array $queue = [];

    /** @var list<array{method: string, uri: string, headers: array<string, string>, body: ?string}> */
    public array $sent = [];

    private ?\Throwable $failure = null;

    /** @param array<string, list<string>> $headers */
    public function queue(int $status, string $body = '', array $headers = []): self
    {
        $this->queue[] = new TransportResponse($status, $headers, $body);

        return $this;
    }

    /** @param array<string, list<string>> $headers */
    public function queueJson(int $status, mixed $body, array $headers = []): self
    {
        return $this->queue(
            $status,
            \json_encode($body, \JSON_THROW_ON_ERROR),
            ['content-type' => ['application/json'], ...$headers],
        );
    }

    /**
     * Makes the next send throw, standing in for a connection that never completed.
     */
    public function failWith(\Throwable $failure): self
    {
        $this->failure = $failure;

        return $this;
    }

    public function send(string $method, string $uri, array $headers, ?string $body): TransportResponse
    {
        $this->sent[] = ['method' => $method, 'uri' => $uri, 'headers' => $headers, 'body' => $body];

        if ($this->failure !== null) {
            $failure = $this->failure;
            $this->failure = null;

            throw $failure;
        }

        $next = \array_shift($this->queue);

        if ($next === null) {
            throw new TransportException(\sprintf(
                'FakeTransport has no queued response for %s %s (%d already served).',
                $method,
                $uri,
                \count($this->sent) - 1,
            ));
        }

        return $next;
    }

    public function callCount(): int
    {
        return \count($this->sent);
    }

    /** @return array{method: string, uri: string, headers: array<string, string>, body: ?string} */
    public function lastRequest(): array
    {
        $last = $this->sent[\count($this->sent) - 1] ?? null;

        if ($last === null) {
            throw new \LogicException('No request was sent.');
        }

        return $last;
    }

    public function lastHeader(string $name): ?string
    {
        foreach ($this->lastRequest()['headers'] as $key => $value) {
            if (\strtolower($key) === \strtolower($name)) {
                return $value;
            }
        }

        return null;
    }

    public function remaining(): int
    {
        return \count($this->queue);
    }
}
