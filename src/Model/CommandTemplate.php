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
 * The `CommandTemplate` schema.
 */
final readonly class CommandTemplate implements DataModel
{
    /**
     * @param list<CommandCreate> $commands
     */
    public function __construct(
        public string $id,
        public string $title,
        public ?string $description,
        public array $commands,
        public \DateTimeImmutable $created_at,
        public ?\DateTimeImmutable $updated_at = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            id: $reader->requiredString('id'),
            title: $reader->requiredString('title'),
            description: $reader->optionalString('description'),
            commands: $reader->requiredModelList('commands', CommandCreate::class),
            created_at: $reader->requiredDateTime('created_at'),
            updated_at: $reader->optionalDateTime('updated_at'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'id' => [$this->id, true],
            'title' => [$this->title, true],
            'description' => [$this->description, true],
            'commands' => [$this->commands, true],
            'created_at' => [$this->created_at, true],
            'updated_at' => [$this->updated_at, true],
        ]);
    }
}
