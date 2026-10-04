<?php

declare(strict_types=1);

namespace Synchra\WebSocket\Payload;

use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The payload of a `channel_giveaways` event: which giveaway on which channel changed.
 *
 * Fetch the giveaway itself with `$synchra->channelGiveaway()->getGiveaway()` when you need its
 * state. Hand-written, for the reason given in {@see WidgetValue}.
 */
final readonly class GiveawayPointer implements DataModel
{
    public function __construct(
        public string $channel_id,
        public string $giveaway_id,
    ) {}

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            channel_id: $reader->requiredString('channel_id'),
            giveaway_id: $reader->requiredString('giveaway_id'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'channel_id' => [$this->channel_id, true],
            'giveaway_id' => [$this->giveaway_id, true],
        ]);
    }
}
