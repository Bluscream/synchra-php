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

use Synchra\Enum\ActiveMode;
use Synchra\Enum\PickMode;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `TimerUpdate` schema.
 */
final readonly class TimerUpdate implements DataModel
{
    /**
     * @param list<string>|null $messages
     * @param ?int $interval Minutes.
     * @param list<string>|null $providers
     * @param list<string>|null $active_title_patterns
     * @param list<string>|null $active_categories
     */
    public function __construct(
        public ?string $name = null,
        public ?array $messages = null,
        public ?int $interval = null,
        public ?bool $enabled = null,
        public ?array $providers = null,
        public ?PickMode $pick_mode = null,
        public ?ActiveMode $active_mode = null,
        public ?\DateTimeImmutable $active_from_date = null,
        public ?\DateTimeImmutable $active_to_date = null,
        public ?array $active_title_patterns = null,
        public ?array $active_categories = null,
        public ?int $active_chat_messages = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            name: $reader->optionalString('name'),
            messages: $reader->optionalStringList('messages'),
            interval: $reader->optionalInt('interval'),
            enabled: $reader->optionalBool('enabled'),
            providers: $reader->optionalStringList('providers'),
            pick_mode: $reader->optionalEnum('pick_mode', PickMode::class),
            active_mode: $reader->optionalEnum('active_mode', ActiveMode::class),
            active_from_date: $reader->optionalDateTime('active_from_date'),
            active_to_date: $reader->optionalDateTime('active_to_date'),
            active_title_patterns: $reader->optionalStringList('active_title_patterns'),
            active_categories: $reader->optionalStringList('active_categories'),
            active_chat_messages: $reader->optionalInt('active_chat_messages'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'name' => [$this->name, false],
            'messages' => [$this->messages, false],
            'interval' => [$this->interval, false],
            'enabled' => [$this->enabled, false],
            'providers' => [$this->providers, false],
            'pick_mode' => [$this->pick_mode, false],
            'active_mode' => [$this->active_mode, false],
            'active_from_date' => [$this->active_from_date, true],
            'active_to_date' => [$this->active_to_date, true],
            'active_title_patterns' => [$this->active_title_patterns, false],
            'active_categories' => [$this->active_categories, false],
            'active_chat_messages' => [$this->active_chat_messages, true],
        ]);
    }
}
