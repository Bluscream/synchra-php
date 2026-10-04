<?php

declare(strict_types=1);

namespace Synchra\Exception;

/**
 * The upload exceeds the channel plan's storage or per-file limit.
 */
final class PayloadTooLargeException extends ApiException {}
