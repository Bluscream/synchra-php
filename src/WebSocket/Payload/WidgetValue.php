<?php

declare(strict_types=1);

namespace Synchra\WebSocket\Payload;

use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The payload of a `widget_value` event: one key in a widget's shared key-value store changed.
 *
 * The OpenAPI description does not cover the gateway's own payloads, so this model follows the
 * documented example in `spec/websocket.md` rather than a schema. It is hand-written for that
 * reason — the generator does not touch this directory.
 */
final readonly class WidgetValue implements DataModel
{
    public function __construct(
        public string $key,
        public mixed $value,
        public int $revision,
        public ?\DateTimeImmutable $expires_at = null,
    ) {}

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            key: $reader->requiredString('key'),
            value: $reader->mixed('value'),
            revision: $reader->requiredInt('revision'),
            expires_at: $reader->optionalDateTime('expires_at'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'key' => [$this->key, true],
            'value' => [$this->value, true],
            'revision' => [$this->revision, true],
            'expires_at' => [$this->expires_at, true],
        ]);
    }
}
