<?php

declare(strict_types=1);

namespace Synchra\WebSocket\Payload;

use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The payload of a `channel_queue` event: what changed about a viewer queue, for example
 * `channel_queue_viewer_created`.
 *
 * The gateway sends only the change kind; re-read the queue to get its new contents.
 * Hand-written, for the reason given in {@see WidgetValue}.
 */
final readonly class QueueEvent implements DataModel
{
    public function __construct(public string $type) {}

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new self((new Reader($data, self::class))->requiredString('type'));
    }

    public function jsonSerialize(): array
    {
        return Writer::payload(['type' => [$this->type, true]]);
    }
}
