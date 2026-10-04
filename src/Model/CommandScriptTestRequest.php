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

use Synchra\Model\Union\CommandScriptTContextUnion;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `CommandScriptTestRequest` schema.
 */
final readonly class CommandScriptTestRequest implements DataModel
{
    public function __construct(
        public string $source,
        public CommandScriptTestActivityContext|CommandScriptTestChatContext $context,
        public ?int $timeout_ms = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            source: $reader->requiredString('source'),
            context: $reader->requiredVia('context', CommandScriptTContextUnion::fromArray(...)),
            timeout_ms: $reader->optionalInt('timeout_ms'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'source' => [$this->source, true],
            'context' => [$this->context, true],
            'timeout_ms' => [$this->timeout_ms, false],
        ]);
    }
}
