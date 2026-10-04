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
 * The `ActivityAlertControlState` schema.
 */
final readonly class ActivityAlertControlState implements DataModel
{
    public function __construct(
        public bool $muted,
        public bool $paused,
        public bool $has_widgets,
        public int $revision,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            muted: $reader->requiredBool('muted'),
            paused: $reader->requiredBool('paused'),
            has_widgets: $reader->requiredBool('has_widgets'),
            revision: $reader->requiredInt('revision'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'muted' => [$this->muted, true],
            'paused' => [$this->paused, true],
            'has_widgets' => [$this->has_widgets, true],
            'revision' => [$this->revision, true],
        ]);
    }
}
