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
 * The `Timer` schema.
 */
final readonly class Timer implements DataModel
{
    /**
     * @param list<string> $messages
     * @param int $interval Minutes.
     * @param list<string> $providers
     * @param list<string>|null $active_title_patterns
     * @param list<string>|null $active_categories
     */
    public function __construct(
        public string $id,
        public string $channel_id,
        public \DateTimeImmutable $created_at,
        public \DateTimeImmutable $updated_at,
        public string $name,
        public array $messages,
        public int $interval,
        public bool $enabled,
        public \DateTimeImmutable $next_run_at,
        public array $providers,
        public PickMode $pick_mode,
        public ActiveMode $active_mode,
        public ?int $last_message_index,
        public ?\DateTimeImmutable $active_from_date,
        public ?\DateTimeImmutable $active_to_date,
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
            id: $reader->requiredString('id'),
            channel_id: $reader->requiredString('channel_id'),
            created_at: $reader->requiredDateTime('created_at'),
            updated_at: $reader->requiredDateTime('updated_at'),
            name: $reader->requiredString('name'),
            messages: $reader->requiredStringList('messages'),
            interval: $reader->requiredInt('interval'),
            enabled: $reader->requiredBool('enabled'),
            next_run_at: $reader->requiredDateTime('next_run_at'),
            providers: $reader->requiredStringList('providers'),
            pick_mode: $reader->requiredEnum('pick_mode', PickMode::class),
            active_mode: $reader->requiredEnum('active_mode', ActiveMode::class),
            last_message_index: $reader->optionalInt('last_message_index'),
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
            'id' => [$this->id, true],
            'channel_id' => [$this->channel_id, true],
            'created_at' => [$this->created_at, true],
            'updated_at' => [$this->updated_at, true],
            'name' => [$this->name, true],
            'messages' => [$this->messages, true],
            'interval' => [$this->interval, true],
            'enabled' => [$this->enabled, true],
            'next_run_at' => [$this->next_run_at, true],
            'providers' => [$this->providers, true],
            'pick_mode' => [$this->pick_mode, true],
            'active_mode' => [$this->active_mode, true],
            'last_message_index' => [$this->last_message_index, true],
            'active_from_date' => [$this->active_from_date, true],
            'active_to_date' => [$this->active_to_date, true],
            'active_title_patterns' => [$this->active_title_patterns, true],
            'active_categories' => [$this->active_categories, true],
            'active_chat_messages' => [$this->active_chat_messages, true],
        ]);
    }
}
