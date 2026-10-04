<?php

declare(strict_types=1);

namespace Synchra\Exception;

/**
 * The request body or query failed validation. {@see ApiException::fieldErrors()} names the
 * offending fields.
 */
final class ValidationException extends ApiException {}
