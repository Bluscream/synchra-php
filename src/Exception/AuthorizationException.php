<?php

declare(strict_types=1);

namespace Synchra\Exception;

/**
 * The token is valid but lacks the scope or channel access level this endpoint needs.
 */
final class AuthorizationException extends ApiException {}
