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
 * The `SlotsSettingsUpdate` schema.
 */
final readonly class SlotsSettingsUpdate implements DataModel
{
    /**
     * @param list<string>|null $emotes
     */
    public function __construct(
        public ?array $emotes = null,
        public ?int $emote_pool_size = null,
        public ?int $payout_percent = null,
        public ?int $min_bet = null,
        public ?int $max_bet = null,
        public ?string $win_message = null,
        public ?string $lose_message = null,
        public ?string $allin_win_message = null,
        public ?string $allin_lose_message = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            emotes: $reader->optionalStringList('emotes'),
            emote_pool_size: $reader->optionalInt('emote_pool_size'),
            payout_percent: $reader->optionalInt('payout_percent'),
            min_bet: $reader->optionalInt('min_bet'),
            max_bet: $reader->optionalInt('max_bet'),
            win_message: $reader->optionalString('win_message'),
            lose_message: $reader->optionalString('lose_message'),
            allin_win_message: $reader->optionalString('allin_win_message'),
            allin_lose_message: $reader->optionalString('allin_lose_message'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'emotes' => [$this->emotes, false],
            'emote_pool_size' => [$this->emote_pool_size, false],
            'payout_percent' => [$this->payout_percent, false],
            'min_bet' => [$this->min_bet, false],
            'max_bet' => [$this->max_bet, false],
            'win_message' => [$this->win_message, false],
            'lose_message' => [$this->lose_message, false],
            'allin_win_message' => [$this->allin_win_message, false],
            'allin_lose_message' => [$this->allin_lose_message, false],
        ]);
    }
}
