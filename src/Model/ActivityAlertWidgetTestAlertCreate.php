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
 * The `ActivityAlertWidgetTestAlertCreate` schema.
 */
final readonly class ActivityAlertWidgetTestAlertCreate implements DataModel
{
    public function __construct(
        public ?string $activity_type = null,
        public ?Activity $activity = null,
        public ?ActivityAlertWidgetSettingsPayload $settings = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            activity_type: $reader->optionalString('activity_type'),
            activity: $reader->optionalModel('activity', Activity::class),
            settings: $reader->optionalModel('settings', ActivityAlertWidgetSettingsPayload::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'activity_type' => [$this->activity_type, false],
            'activity' => [$this->activity, false],
            'settings' => [$this->settings, false],
        ]);
    }
}
