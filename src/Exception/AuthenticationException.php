<?php

declare(strict_types=1);

namespace Synchra\Exception;

/**
 * No token was sent, or the token is expired or invalid.
 */
final class AuthenticationException extends ApiException {}
