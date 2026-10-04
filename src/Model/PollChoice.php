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
 * The `PollChoice` schema.
 */
final readonly class PollChoice implements DataModel
{
    public function __construct(
        public string $provider_choice_id,
        public string $text,
        public ?int $votes = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            provider_choice_id: $reader->requiredString('provider_choice_id'),
            text: $reader->requiredString('text'),
            votes: $reader->optionalInt('votes'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'provider_choice_id' => [$this->provider_choice_id, true],
            'text' => [$this->text, true],
            'votes' => [$this->votes, false],
        ]);
    }
}
