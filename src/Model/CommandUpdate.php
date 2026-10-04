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
use Synchra\Enum\TAccessLevel;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `CommandUpdate` schema.
 */
final readonly class CommandUpdate implements DataModel
{
    /**
     * @param list<string>|null $cmds
     * @param list<string>|null $patterns
     * @param ?TAccessLevel $access_level 0: PUBLIC - 1: SUB - 2: VIP - 7: MOD - 8: LEAD_MOD - 100: EDITOR - 200: ADMIN - 500: OWNER - 1000: GLOBAL_ADMIN.
     * @param list<string>|null $providers
     * @param list<string>|null $active_title_patterns
     * @param list<string>|null $active_categories
     * @param list<CommandActivityTrigger>|null $activity_triggers
     */
    public function __construct(
        public ?string $name = null,
        public ?array $cmds = null,
        public ?array $patterns = null,
        public ?string $response = null,
        public ?ActionType $action_type = null,
        public ?string $script_source = null,
        public ?string $group_name = null,
        public ?int $global_cooldown = null,
        public ?int $chatter_cooldown = null,
        public ?int $mod_cooldown = null,
        public ?ActiveMode $active_mode = null,
        public ?bool $enabled = null,
        public ?bool $public = null,
        public ?TAccessLevel $access_level = null,
        public ?array $providers = null,
        public ?\DateTimeImmutable $active_from_date = null,
        public ?\DateTimeImmutable $active_to_date = null,
        public ?array $active_title_patterns = null,
        public ?array $active_categories = null,
        public ?array $activity_triggers = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            name: $reader->optionalString('name'),
            cmds: $reader->optionalStringList('cmds'),
            patterns: $reader->optionalStringList('patterns'),
            response: $reader->optionalString('response'),
            action_type: $reader->optionalEnum('action_type', ActionType::class),
            script_source: $reader->optionalString('script_source'),
            group_name: $reader->optionalString('group_name'),
            global_cooldown: $reader->optionalInt('global_cooldown'),
            chatter_cooldown: $reader->optionalInt('chatter_cooldown'),
            mod_cooldown: $reader->optionalInt('mod_cooldown'),
            active_mode: $reader->optionalEnum('active_mode', ActiveMode::class),
            enabled: $reader->optionalBool('enabled'),
            public: $reader->optionalBool('public'),
            access_level: $reader->optionalEnum('access_level', TAccessLevel::class),
            providers: $reader->optionalStringList('providers'),
            active_from_date: $reader->optionalDateTime('active_from_date'),
            active_to_date: $reader->optionalDateTime('active_to_date'),
            active_title_patterns: $reader->optionalStringList('active_title_patterns'),
            active_categories: $reader->optionalStringList('active_categories'),
            activity_triggers: $reader->optionalModelList('activity_triggers', CommandActivityTrigger::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'name' => [$this->name, false],
            'cmds' => [$this->cmds, false],
            'patterns' => [$this->patterns, false],
            'response' => [$this->response, true],
            'action_type' => [$this->action_type, false],
            'script_source' => [$this->script_source, true],
            'group_name' => [$this->group_name, false],
            'global_cooldown' => [$this->global_cooldown, false],
            'chatter_cooldown' => [$this->chatter_cooldown, false],
            'mod_cooldown' => [$this->mod_cooldown, false],
            'active_mode' => [$this->active_mode, false],
            'enabled' => [$this->enabled, false],
            'public' => [$this->public, false],
            'access_level' => [$this->access_level, false],
            'providers' => [$this->providers, false],
            'active_from_date' => [$this->active_from_date, true],
            'active_to_date' => [$this->active_to_date, true],
            'active_title_patterns' => [$this->active_title_patterns, false],
            'active_categories' => [$this->active_categories, false],
            'activity_triggers' => [$this->activity_triggers, false],
        ]);
    }
}
