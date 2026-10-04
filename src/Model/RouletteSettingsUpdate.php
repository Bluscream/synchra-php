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
 * The `RouletteSettingsUpdate` schema.
 */
final readonly class RouletteSettingsUpdate implements DataModel
{
    public function __construct(
        public ?int $win_chance = null,
        public ?string $win_message = null,
        public ?string $lose_message = null,
        public ?string $allin_win_message = null,
        public ?string $allin_lose_message = null,
        public ?int $min_bet = null,
        public ?int $max_bet = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            win_chance: $reader->optionalInt('win_chance'),
            win_message: $reader->optionalString('win_message'),
            lose_message: $reader->optionalString('lose_message'),
            allin_win_message: $reader->optionalString('allin_win_message'),
            allin_lose_message: $reader->optionalString('allin_lose_message'),
            min_bet: $reader->optionalInt('min_bet'),
            max_bet: $reader->optionalInt('max_bet'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'win_chance' => [$this->win_chance, false],
            'win_message' => [$this->win_message, false],
            'lose_message' => [$this->lose_message, false],
            'allin_win_message' => [$this->allin_win_message, false],
            'allin_lose_message' => [$this->allin_lose_message, false],
            'min_bet' => [$this->min_bet, false],
            'max_bet' => [$this->max_bet, false],
        ]);
    }
}
