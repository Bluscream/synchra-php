<?php

declare(strict_types=1);

namespace Synchra\Exception;

/**
 * Too many requests. Back off before retrying.
 */
final class RateLimitException extends ApiException {}
