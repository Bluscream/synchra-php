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
 * The `CommandScriptTestActivityContext` schema.
 */
final readonly class CommandScriptTestActivityContext implements DataModel
{
    public function __construct(
        public ActivityCreate $activity,
        public string $trigger = 'activity',
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            activity: $reader->requiredModel('activity', ActivityCreate::class),
            trigger: $reader->requiredString('trigger'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'activity' => [$this->activity, true],
            'trigger' => [$this->trigger, true],
        ]);
    }
}
