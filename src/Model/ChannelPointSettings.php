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
 * The `ChannelPointSettings` schema.
 */
final readonly class ChannelPointSettings implements DataModel
{
    /**
     * @param list<string>|null $ignore_users
     */
    public function __construct(
        public string $channel_id,
        public ?bool $enabled = null,
        public ?string $points_name = null,
        public ?int $points_per_min = null,
        public ?int $points_per_min_sub_multiplier = null,
        public ?int $points_per_sub = null,
        public ?int $points_per_cheer = null,
        public ?array $ignore_users = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            channel_id: $reader->requiredString('channel_id'),
            enabled: $reader->optionalBool('enabled'),
            points_name: $reader->optionalString('points_name'),
            points_per_min: $reader->optionalInt('points_per_min'),
            points_per_min_sub_multiplier: $reader->optionalInt('points_per_min_sub_multiplier'),
            points_per_sub: $reader->optionalInt('points_per_sub'),
            points_per_cheer: $reader->optionalInt('points_per_cheer'),
            ignore_users: $reader->optionalStringList('ignore_users'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'channel_id' => [$this->channel_id, true],
            'enabled' => [$this->enabled, false],
            'points_name' => [$this->points_name, false],
            'points_per_min' => [$this->points_per_min, false],
            'points_per_min_sub_multiplier' => [$this->points_per_min_sub_multiplier, false],
            'points_per_sub' => [$this->points_per_sub, false],
            'points_per_cheer' => [$this->points_per_cheer, false],
            'ignore_users' => [$this->ignore_users, false],
        ]);
    }
}
