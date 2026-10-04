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
 * The `ObsRemoteState` schema.
 */
final readonly class ObsRemoteState implements DataModel
{
    /**
     * @param list<string>|null $scenes
     */
    public function __construct(
        public ?string $plugin_version = null,
        public ?int $control_level = null,
        public ?bool $obs_available = null,
        public ?ObsRemoteOutputStatus $status = null,
        public ?ObsRemoteScene $current_scene = null,
        public ?array $scenes = null,
        public ?ObsRemoteWebSocketState $obs_websocket = null,
        public ?string $last_error = null,
        public ?ObsRemoteLastCommand $last_command = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            plugin_version: $reader->optionalString('plugin_version'),
            control_level: $reader->optionalInt('control_level'),
            obs_available: $reader->optionalBool('obs_available'),
            status: $reader->optionalModel('status', ObsRemoteOutputStatus::class),
            current_scene: $reader->optionalModel('current_scene', ObsRemoteScene::class),
            scenes: $reader->optionalStringList('scenes'),
            obs_websocket: $reader->optionalModel('obs_websocket', ObsRemoteWebSocketState::class),
            last_error: $reader->optionalString('last_error'),
            last_command: $reader->optionalModel('last_command', ObsRemoteLastCommand::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'plugin_version' => [$this->plugin_version, false],
            'control_level' => [$this->control_level, false],
            'obs_available' => [$this->obs_available, false],
            'status' => [$this->status, false],
            'current_scene' => [$this->current_scene, true],
            'scenes' => [$this->scenes, false],
            'obs_websocket' => [$this->obs_websocket, false],
            'last_error' => [$this->last_error, true],
            'last_command' => [$this->last_command, false],
        ]);
    }
}
