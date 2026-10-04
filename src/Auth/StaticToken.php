<?php

declare(strict_types=1);

namespace Synchra\Auth;

/**
 * A token that never changes — the usual case for a personal access token.
 */
final readonly class StaticToken implements TokenProvider
{
    public function __construct(private ?string $token) {}

    /**
     * Reads the token from an environment variable, or returns an anonymous provider when
     * it is unset.
     */
    public static function fromEnvironment(string $variable = 'SYNCHRA_TOKEN'): self
    {
        $value = \getenv($variable);

        return new self($value === false || $value === '' ? null : $value);
    }

    public function token(): ?string
    {
        return $this->token;
    }
}
