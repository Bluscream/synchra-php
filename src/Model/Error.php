<?php

/*
 * This file is generated — do not edit it by hand.
 *
 * Source:    spec/openapi.json (and spec/websocket.md for the gateway)
 * Generator: tools/generate.php
 *
 * To pick up an API change: ./tools/fetch-spec.sh && composer generate
 */

declare(strict_types=1);

namespace Synchra\Model;

use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `Error` schema.
 */
final readonly class Error implements DataModel
{
    /**
     * @param list<SubError> $errors
     */
    public function __construct(
        public int $code,
        public string $message,
        public string $type,
        public array $errors,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            code: $reader->requiredInt('code'),
            message: $reader->requiredString('message'),
            type: $reader->requiredString('type'),
            errors: $reader->requiredModelList('errors', SubError::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'code' => [$this->code, true],
            'message' => [$this->message, true],
            'type' => [$this->type, true],
            'errors' => [$this->errors, true],
        ]);
    }
}
