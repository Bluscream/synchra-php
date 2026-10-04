<?php

declare(strict_types=1);

namespace Synchra\Http;

/**
 * One call to the API, described independently of any HTTP library.
 */
final readonly class ApiRequest
{
    /**
     * @param string $method Uppercase HTTP method.
     * @param string $path Path below the API root, already expanded — see {@see Path::expand()}.
     * @param array<string, mixed> $query Query parameters; nulls are dropped.
     * @param mixed $body A value to send as JSON, or null for no body.
     * @param array<string, string> $headers Extra headers for this request only.
     * @param string|null $rawBody Pre-encoded body, used for the binary file upload endpoint.
     *                             Takes precedence over `$body`.
     */
    public function __construct(
        public string $method,
        public string $path,
        public array $query = [],
        public mixed $body = null,
        public array $headers = [],
        public ?string $rawBody = null,
    ) {}
}
