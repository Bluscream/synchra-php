<?php

declare(strict_types=1);

namespace Synchra\Auth;

/**
 * Supplies the bearer token sent with every request.
 *
 * Implement this to pull a token from a secret store, refresh an expiring one, or swap
 * tokens between tenants without rebuilding the client.
 */
interface TokenProvider
{
    /**
     * The current token, or null to send the request unauthenticated.
     *
     * Some endpoints serve public data without a token, so a null return is not an error.
     */
    public function token(): ?string;
}
