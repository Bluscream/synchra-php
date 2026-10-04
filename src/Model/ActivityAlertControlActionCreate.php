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

use Synchra\Enum\Action;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `ActivityAlertControlActionCreate` schema.
 */
final readonly class ActivityAlertControlActionCreate implements DataModel
{
    public function __construct(
        public Action $action,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            action: $reader->requiredEnum('action', Action::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'action' => [$this->action, true],
        ]);
    }
}
