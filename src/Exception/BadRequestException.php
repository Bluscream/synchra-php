<?php

declare(strict_types=1);

namespace Synchra\Exception;

/**
 * The request was rejected as malformed, or the action is not possible in the current state (for example sending to a YouTube channel with no active broadcast).
 */
final class BadRequestException extends ApiException {}
