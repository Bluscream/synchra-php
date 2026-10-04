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

use Synchra\Enum\StreamathonWidgetActionPayloadAction;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `StreamathonWidgetActionPayload` schema.
 */
final readonly class StreamathonWidgetActionPayload implements DataModel
{
    public function __construct(
        public StreamathonWidgetActionPayloadAction $action,
        public ?float $seconds = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            action: $reader->requiredEnum('action', StreamathonWidgetActionPayloadAction::class),
            seconds: $reader->optionalFloat('seconds'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'action' => [$this->action, true],
            'seconds' => [$this->seconds, false],
        ]);
    }
}
