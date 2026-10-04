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

use Synchra\Enum\Provider;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `ControlsProfileControl` schema.
 */
final readonly class ControlsProfileControl implements DataModel
{
    /**
     * @param list<ControlsProfileControl>|null $actions
     */
    public function __construct(
        public ?string $name = null,
        public ?string $type = null,
        public ?int $order = null,
        public ?string $color = null,
        public ?Provider $provider = null,
        public ?string $input = null,
        public ?array $actions = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            name: $reader->optionalString('name'),
            type: $reader->optionalString('type'),
            order: $reader->optionalInt('order'),
            color: $reader->optionalString('color'),
            provider: $reader->optionalEnum('provider', Provider::class),
            input: $reader->optionalString('input'),
            actions: $reader->optionalModelList('actions', ControlsProfileControl::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'name' => [$this->name, false],
            'type' => [$this->type, false],
            'order' => [$this->order, false],
            'color' => [$this->color, false],
            'provider' => [$this->provider, true],
            'input' => [$this->input, false],
            'actions' => [$this->actions, false],
        ]);
    }
}
