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

use Synchra\Enum\ActivityActivityGroup;
use Synchra\Enum\ActivityContributionGroup;
use Synchra\Enum\Provider;
use Synchra\Enum\SubTypeInputMode;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `ActivityTypeName` schema.
 */
final readonly class ActivityTypeName implements DataModel
{
    /**
     * @param array<string, mixed>|null $sub_type_names
     * @param array<string, mixed>|null $sub_type_default_multipliers
     */
    public function __construct(
        public string $name,
        public string $display_name,
        public string $color,
        public Provider $provider,
        public string $count_name,
        public string $font_color,
        public ?string $count_name_singular = null,
        public ?bool $filter_min_count = null,
        public ?bool $has_amount = null,
        public ?bool $has_message = null,
        public ?bool $has_recipient = null,
        public ?bool $has_subtype = null,
        public ?ActivityActivityGroup $activity_group = null,
        public ?ActivityActivityGroup $source_group = null,
        public ?array $sub_type_names = null,
        public ?SubTypeInputMode $sub_type_input_mode = null,
        public ?array $sub_type_default_multipliers = null,
        public ?ActivityContributionGroup $contribution_group = null,
        public ?ActivityUnitValue $unit_value = null,
        public ?string $title_template = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            name: $reader->requiredString('name'),
            display_name: $reader->requiredString('display_name'),
            color: $reader->requiredString('color'),
            provider: $reader->requiredEnum('provider', Provider::class),
            count_name: $reader->requiredString('count_name'),
            font_color: $reader->requiredString('font_color'),
            count_name_singular: $reader->optionalString('count_name_singular'),
            filter_min_count: $reader->optionalBool('filter_min_count'),
            has_amount: $reader->optionalBool('has_amount'),
            has_message: $reader->optionalBool('has_message'),
            has_recipient: $reader->optionalBool('has_recipient'),
            has_subtype: $reader->optionalBool('has_subtype'),
            activity_group: $reader->optionalEnum('activity_group', ActivityActivityGroup::class),
            source_group: $reader->optionalEnum('source_group', ActivityActivityGroup::class),
            sub_type_names: $reader->optionalMap('sub_type_names'),
            sub_type_input_mode: $reader->optionalEnum('sub_type_input_mode', SubTypeInputMode::class),
            sub_type_default_multipliers: $reader->optionalMap('sub_type_default_multipliers'),
            contribution_group: $reader->optionalEnum('contribution_group', ActivityContributionGroup::class),
            unit_value: $reader->optionalModel('unit_value', ActivityUnitValue::class),
            title_template: $reader->optionalString('title_template'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'name' => [$this->name, true],
            'display_name' => [$this->display_name, true],
            'color' => [$this->color, true],
            'provider' => [$this->provider, true],
            'count_name' => [$this->count_name, true],
            'font_color' => [$this->font_color, true],
            'count_name_singular' => [$this->count_name_singular, true],
            'filter_min_count' => [$this->filter_min_count, false],
            'has_amount' => [$this->has_amount, false],
            'has_message' => [$this->has_message, false],
            'has_recipient' => [$this->has_recipient, false],
            'has_subtype' => [$this->has_subtype, false],
            'activity_group' => [$this->activity_group, true],
            'source_group' => [$this->source_group, true],
            'sub_type_names' => [$this->sub_type_names, false],
            'sub_type_input_mode' => [$this->sub_type_input_mode, false],
            'sub_type_default_multipliers' => [$this->sub_type_default_multipliers, false],
            'contribution_group' => [$this->contribution_group, true],
            'unit_value' => [$this->unit_value, true],
            'title_template' => [$this->title_template, false],
        ]);
    }
}
