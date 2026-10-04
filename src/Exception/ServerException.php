<?php

declare(strict_types=1);

namespace Synchra\Exception;

/**
 * Synchra failed to handle the request. Retrying a safe request later is reasonable.
 */
final class ServerException extends ApiException {}
