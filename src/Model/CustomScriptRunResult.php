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
 * The `CustomScriptRunResult` schema.
 */
final readonly class CustomScriptRunResult implements DataModel
{
    /**
     * @param list<CustomScriptLogEntry> $logs
     * @param list<CustomScriptAction> $actions
     */
    public function __construct(
        public array $logs,
        public array $actions,
        public int $duration_ms,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            logs: $reader->requiredModelList('logs', CustomScriptLogEntry::class),
            actions: $reader->requiredModelList('actions', CustomScriptAction::class),
            duration_ms: $reader->requiredInt('duration_ms'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'logs' => [$this->logs, true],
            'actions' => [$this->actions, true],
            'duration_ms' => [$this->duration_ms, true],
        ]);
    }
}
