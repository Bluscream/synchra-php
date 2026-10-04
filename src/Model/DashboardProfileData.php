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
 * The `DashboardProfileData` schema.
 */
final readonly class DashboardProfileData implements DataModel
{
    /**
     * @param array<string, mixed>|null $widgets_config
     * @param list<DashboardWidgetConfig>|null $items
     * @param mixed $layout Carries one of string|DashboardLayoutSplitNode.
     */
    public function __construct(
        public ?array $widgets_config = null,
        public ?array $items = null,
        public mixed $layout = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            widgets_config: $reader->optionalMap('widgets_config'),
            items: $reader->optionalModelList('items', DashboardWidgetConfig::class),
            layout: $reader->mixed('layout'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'widgets_config' => [$this->widgets_config, false],
            'items' => [$this->items, false],
            'layout' => [$this->layout, true],
        ]);
    }
}
