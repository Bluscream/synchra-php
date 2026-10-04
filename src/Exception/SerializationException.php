<?php

declare(strict_types=1);

namespace Synchra\Exception;

/**
 * A response arrived but did not match what the API description promises — unparsable JSON,
 * a missing required field, or a value of the wrong shape.
 *
 * In practice this means the vendored spec has drifted from the live API. Re-run
 * `tools/fetch-spec.sh` and regenerate before assuming a bug in the caller's code.
 */
final class SerializationException extends \RuntimeException implements SynchraException {}
