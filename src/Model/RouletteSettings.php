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
 * The `RouletteSettings` schema.
 */
final readonly class RouletteSettings implements DataModel
{
    public function __construct(
        public string $channel_id,
        public int $win_chance,
        public string $win_message,
        public string $lose_message,
        public string $allin_win_message,
        public string $allin_lose_message,
        public int $min_bet,
        public int $max_bet,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            channel_id: $reader->requiredString('channel_id'),
            win_chance: $reader->requiredInt('win_chance'),
            win_message: $reader->requiredString('win_message'),
            lose_message: $reader->requiredString('lose_message'),
            allin_win_message: $reader->requiredString('allin_win_message'),
            allin_lose_message: $reader->requiredString('allin_lose_message'),
            min_bet: $reader->requiredInt('min_bet'),
            max_bet: $reader->requiredInt('max_bet'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'channel_id' => [$this->channel_id, true],
            'win_chance' => [$this->win_chance, true],
            'win_message' => [$this->win_message, true],
            'lose_message' => [$this->lose_message, true],
            'allin_win_message' => [$this->allin_win_message, true],
            'allin_lose_message' => [$this->allin_lose_message, true],
            'min_bet' => [$this->min_bet, true],
            'max_bet' => [$this->max_bet, true],
        ]);
    }
}
