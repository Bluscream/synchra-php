<?php

declare(strict_types=1);

namespace Synchra\Exception;

/**
 * The request never produced an HTTP response: DNS failure, refused connection, TLS error,
 * or a timeout. There is no status code and no API error body to inspect.
 */
final class TransportException extends \RuntimeException implements SynchraException {}
