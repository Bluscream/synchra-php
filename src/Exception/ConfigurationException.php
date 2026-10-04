<?php

declare(strict_types=1);

namespace Synchra\Exception;

/**
 * The client was built with arguments it cannot work with — a malformed base URI, a missing
 * PSR-18 implementation, or a required value left empty.
 */
final class ConfigurationException extends \InvalidArgumentException implements SynchraException {}
