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
 * The `ChannelCreate` schema.
 */
final readonly class ChannelCreate implements DataModel
{
    public function __construct(
        public string $display_name,
        public ?bool $show_on_landing_page = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            display_name: $reader->requiredString('display_name'),
            show_on_landing_page: $reader->optionalBool('show_on_landing_page'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'display_name' => [$this->display_name, true],
            'show_on_landing_page' => [$this->show_on_landing_page, false],
        ]);
    }
}
