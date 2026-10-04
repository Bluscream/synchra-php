<?php

declare(strict_types=1);

namespace Synchra\Exception;

/**
 * Implemented by every exception this package throws, so a caller can catch all of them
 * without catching unrelated failures.
 */
interface SynchraException extends \Throwable {}
