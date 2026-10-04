<?php

declare(strict_types=1);

namespace Synchra\Exception;

use Synchra\Model\Error;

/**
 * The API answered with a 4xx or 5xx status.
 *
 * Synchra sends a machine-readable envelope with every error — `{code, message, type, errors}`
 * — so branch on {@see self::errorType()} rather than on the message text, which is prose and
 * may be reworded at any time.
 */
class ApiException extends \RuntimeException implements SynchraException
{
    /**
     * @param int $status HTTP status code.
     * @param Error|null $error Parsed error envelope, or null when the body was not one.
     * @param string $body The raw response body, kept for diagnosing non-envelope errors.
     */
    final public function __construct(
        public readonly int $status,
        public readonly ?Error $error,
        public readonly string $body,
        public readonly string $requestMethod,
        public readonly string $requestUri,
        ?\Throwable $previous = null,
    ) {
        parent::__construct(self::describe($status, $error, $body, $requestMethod, $requestUri), $status, $previous);
    }

    /**
     * Builds the subclass that matches the status, so callers can catch the specific failure
     * they know how to handle and let the rest propagate.
     */
    public static function forStatus(
        int $status,
        ?Error $error,
        string $body,
        string $requestMethod,
        string $requestUri,
    ): self {
        $class = match (true) {
            $status === 400 => BadRequestException::class,
            $status === 401 => AuthenticationException::class,
            $status === 403 => AuthorizationException::class,
            $status === 404 => NotFoundException::class,
            $status === 409 => ConflictException::class,
            $status === 413 => PayloadTooLargeException::class,
            $status === 422 => ValidationException::class,
            $status === 429 => RateLimitException::class,
            $status >= 500 => ServerException::class,
            default => self::class,
        };

        return new $class($status, $error, $body, $requestMethod, $requestUri);
    }

    /**
     * The stable error identifier, for example `unauthenticated` or `no_youtube_stream_chat`.
     */
    public function errorType(): ?string
    {
        return $this->error?->type;
    }

    /**
     * Per-field validation problems. Empty for errors that are not about the request body.
     *
     * @return list<\Synchra\Model\SubError>
     */
    public function fieldErrors(): array
    {
        return $this->error === null ? [] : $this->error->errors;
    }

    private static function describe(
        int $status,
        ?Error $error,
        string $body,
        string $method,
        string $uri,
    ): string {
        $detail = $error !== null
            ? \sprintf('%s: %s', $error->type, $error->message)
            : self::summarise($body);

        return \sprintf('Synchra API error %d on %s %s — %s', $status, $method, $uri, $detail);
    }

    private static function summarise(string $body): string
    {
        $trimmed = \trim($body);

        if ($trimmed === '') {
            return 'the response had no body.';
        }

        return \strlen($trimmed) > 300 ? \substr($trimmed, 0, 297) . '...' : $trimmed;
    }
}
