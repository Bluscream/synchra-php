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
 * The `CustomWidgetSettings` schema.
 */
final readonly class CustomWidgetSettings implements DataModel
{
    /**
     * @param array<string, mixed>|null $settings_values
     */
    public function __construct(
        public ?CustomWidgetBuild $build = null,
        public ?array $settings_values = null,
        public ?bool $enabled = null,
        public ?CustomWidgetProject $project = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            build: $reader->optionalModel('build', CustomWidgetBuild::class),
            settings_values: $reader->optionalMap('settings_values'),
            enabled: $reader->optionalBool('enabled'),
            project: $reader->optionalModel('project', CustomWidgetProject::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'build' => [$this->build, false],
            'settings_values' => [$this->settings_values, false],
            'enabled' => [$this->enabled, false],
            'project' => [$this->project, false],
        ]);
    }
}
