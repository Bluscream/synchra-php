<?php

declare(strict_types=1);

namespace Synchra\Auth;

/**
 * Resolves the token through a callback on every request.
 *
 * Use this when the token can change while the client is alive — an OAuth access token
 * being refreshed in the background, or a token read from a rotating secret file.
 */
final readonly class CallableToken implements TokenProvider
{
    /** @param \Closure(): ?string $resolver */
    public function __construct(private \Closure $resolver) {}

    /** @param callable(): ?string $resolver */
    public static function of(callable $resolver): self
    {
        return new self(\Closure::fromCallable($resolver));
    }

    public function token(): ?string
    {
        return ($this->resolver)();
    }
}
