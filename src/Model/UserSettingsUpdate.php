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

use Synchra\Enum\FilterCurrency;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `UserSettingsUpdate` schema.
 */
final readonly class UserSettingsUpdate implements DataModel
{
    public function __construct(
        public ?bool $view_count = null,
        public ?FilterCurrency $currency = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            view_count: $reader->optionalBool('view_count'),
            currency: $reader->optionalEnum('currency', FilterCurrency::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'view_count' => [$this->view_count, false],
            'currency' => [$this->currency, false],
        ]);
    }
}
