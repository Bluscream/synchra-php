<?php

declare(strict_types=1);

namespace Synchra\Http;

/**
 * When to retry a failed request, and how long to wait first.
 *
 * Retries are limited to methods that can be repeated without changing the outcome twice, so a
 * `POST` that creates a giveaway is never sent again on a timeout. A `Retry-After` header always
 * wins over the computed backoff — the server knows better than the client does.
 */
final readonly class RetryPolicy
{
    public const IDEMPOTENT_METHODS = ['GET', 'HEAD', 'OPTIONS', 'PUT', 'DELETE'];

    /**
     * @param int $maxAttempts Total attempts including the first. 1 disables retrying.
     * @param int $baseDelayMs First backoff step; doubles each attempt.
     * @param int $maxDelayMs Ceiling for the computed backoff and for an honoured `Retry-After`.
     * @param list<int> $retryStatuses Statuses worth another attempt.
     * @param bool $retryUnsafeMethods Also retry POST and PATCH. Only enable when every such
     *                                 call in your application is safe to repeat.
     * @param (\Closure(int): void)|null $sleeper Overrides the sleep, for tests.
     */
    public function __construct(
        public int $maxAttempts = 3,
        public int $baseDelayMs = 500,
        public int $maxDelayMs = 30_000,
        public array $retryStatuses = [429, 500, 502, 503, 504],
        public bool $retryUnsafeMethods = false,
        public ?\Closure $sleeper = null,
    ) {}

    public static function disabled(): self
    {
        return new self(maxAttempts: 1);
    }

    public function allowsMethod(string $method): bool
    {
        return $this->retryUnsafeMethods || \in_array(\strtoupper($method), self::IDEMPOTENT_METHODS, true);
    }

    public function shouldRetry(string $method, int $status, int $attempt): bool
    {
        return $attempt < $this->maxAttempts
            && $this->allowsMethod($method)
            && \in_array($status, $this->retryStatuses, true);
    }

    /**
     * Milliseconds to wait before attempt number `$attempt + 1`.
     */
    public function delayMs(int $attempt, ?string $retryAfter): int
    {
        $fromHeader = $this->parseRetryAfter($retryAfter);

        if ($fromHeader !== null) {
            return \min($fromHeader, $this->maxDelayMs);
        }

        $delay = $this->baseDelayMs * (2 ** ($attempt - 1));

        return (int) \min($delay, $this->maxDelayMs);
    }

    public function sleep(int $milliseconds): void
    {
        if ($milliseconds <= 0) {
            return;
        }

        if ($this->sleeper !== null) {
            ($this->sleeper)($milliseconds);

            return;
        }

        \usleep($milliseconds * 1000);
    }

    private function parseRetryAfter(?string $value): ?int
    {
        if ($value === null || \trim($value) === '') {
            return null;
        }

        $value = \trim($value);

        if (\ctype_digit($value)) {
            return (int) $value * 1000;
        }

        $at = \strtotime($value);

        if ($at === false) {
            return null;
        }

        return \max(0, ($at - \time()) * 1000);
    }
}
