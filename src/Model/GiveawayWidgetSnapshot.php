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
 * The `GiveawayWidgetSnapshot` schema.
 */
final readonly class GiveawayWidgetSnapshot implements DataModel
{
    /**
     * @param list<GiveawayEntry>|null $recent_entries
     */
    public function __construct(
        public ?bool $is_running = null,
        public ?string $giveaway_id = null,
        public ?Giveaway $giveaway = null,
        public ?string $trigger = null,
        public ?\DateTimeImmutable $end_at = null,
        public ?\DateTimeImmutable $next_change_at = null,
        public ?int $entry_count = null,
        public ?array $recent_entries = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            is_running: $reader->optionalBool('is_running'),
            giveaway_id: $reader->optionalString('giveaway_id'),
            giveaway: $reader->optionalModel('giveaway', Giveaway::class),
            trigger: $reader->optionalString('trigger'),
            end_at: $reader->optionalDateTime('end_at'),
            next_change_at: $reader->optionalDateTime('next_change_at'),
            entry_count: $reader->optionalInt('entry_count'),
            recent_entries: $reader->optionalModelList('recent_entries', GiveawayEntry::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'is_running' => [$this->is_running, false],
            'giveaway_id' => [$this->giveaway_id, true],
            'giveaway' => [$this->giveaway, true],
            'trigger' => [$this->trigger, true],
            'end_at' => [$this->end_at, true],
            'next_change_at' => [$this->next_change_at, true],
            'entry_count' => [$this->entry_count, false],
            'recent_entries' => [$this->recent_entries, false],
        ]);
    }
}
