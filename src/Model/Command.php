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

use Synchra\Enum\ActionType;
use Synchra\Enum\ActiveMode;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `Command` schema.
 */
final readonly class Command implements DataModel
{
    /**
     * @param list<string> $cmds
     * @param list<string> $patterns
     * @param list<string> $active_title_patterns
     * @param list<string> $active_categories
     * @param list<string> $providers
     * @param list<CommandActivityTrigger> $activity_triggers
     */
    public function __construct(
        public string $id,
        public string $channel_id,
        public string $name,
        public array $cmds,
        public array $patterns,
        public ?string $response,
        public ActionType $action_type,
        public ?string $script_source,
        public string $group_name,
        public int $global_cooldown,
        public int $chatter_cooldown,
        public int $mod_cooldown,
        public ActiveMode $active_mode,
        public bool $enabled,
        public bool $public,
        public int $access_level,
        public ?\DateTimeImmutable $active_from_date,
        public ?\DateTimeImmutable $active_to_date,
        public array $active_title_patterns,
        public array $active_categories,
        public array $providers,
        public array $activity_triggers,
        public \DateTimeImmutable $created_at,
        public \DateTimeImmutable $updated_at,
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
            name: $reader->requiredString('name'),
            cmds: $reader->requiredStringList('cmds'),
            patterns: $reader->requiredStringList('patterns'),
            response: $reader->optionalString('response'),
            action_type: $reader->requiredEnum('action_type', ActionType::class),
            script_source: $reader->optionalString('script_source'),
            group_name: $reader->requiredString('group_name'),
            global_cooldown: $reader->requiredInt('global_cooldown'),
            chatter_cooldown: $reader->requiredInt('chatter_cooldown'),
            mod_cooldown: $reader->requiredInt('mod_cooldown'),
            active_mode: $reader->requiredEnum('active_mode', ActiveMode::class),
            enabled: $reader->requiredBool('enabled'),
            public: $reader->requiredBool('public'),
            access_level: $reader->requiredInt('access_level'),
            active_from_date: $reader->optionalDateTime('active_from_date'),
            active_to_date: $reader->optionalDateTime('active_to_date'),
            active_title_patterns: $reader->requiredStringList('active_title_patterns'),
            active_categories: $reader->requiredStringList('active_categories'),
            providers: $reader->requiredStringList('providers'),
            activity_triggers: $reader->requiredModelList('activity_triggers', CommandActivityTrigger::class),
            created_at: $reader->requiredDateTime('created_at'),
            updated_at: $reader->requiredDateTime('updated_at'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'id' => [$this->id, true],
            'channel_id' => [$this->channel_id, true],
            'name' => [$this->name, true],
            'cmds' => [$this->cmds, true],
            'patterns' => [$this->patterns, true],
            'response' => [$this->response, true],
            'action_type' => [$this->action_type, true],
            'script_source' => [$this->script_source, true],
            'group_name' => [$this->group_name, true],
            'global_cooldown' => [$this->global_cooldown, true],
            'chatter_cooldown' => [$this->chatter_cooldown, true],
            'mod_cooldown' => [$this->mod_cooldown, true],
            'active_mode' => [$this->active_mode, true],
            'enabled' => [$this->enabled, true],
            'public' => [$this->public, true],
            'access_level' => [$this->access_level, true],
            'active_from_date' => [$this->active_from_date, true],
            'active_to_date' => [$this->active_to_date, true],
            'active_title_patterns' => [$this->active_title_patterns, true],
            'active_categories' => [$this->active_categories, true],
            'providers' => [$this->providers, true],
            'activity_triggers' => [$this->activity_triggers, true],
            'created_at' => [$this->created_at, true],
            'updated_at' => [$this->updated_at, true],
        ]);
    }
}
