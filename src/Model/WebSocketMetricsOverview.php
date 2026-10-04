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
 * The `WebSocketMetricsOverview` schema.
 */
final readonly class WebSocketMetricsOverview implements DataModel
{
    /**
     * @param list<WebSocketMetricPoint> $history
     */
    public function __construct(
        public ?int $connections,
        public ?int $subscriptions,
        public ?float $sent_per_second,
        public ?float $opened_per_minute,
        public ?float $closed_per_minute,
        public ?float $slow_clients_per_minute,
        public int $interval_minutes,
        public array $history,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            connections: $reader->optionalInt('connections'),
            subscriptions: $reader->optionalInt('subscriptions'),
            sent_per_second: $reader->optionalFloat('sent_per_second'),
            opened_per_minute: $reader->optionalFloat('opened_per_minute'),
            closed_per_minute: $reader->optionalFloat('closed_per_minute'),
            slow_clients_per_minute: $reader->optionalFloat('slow_clients_per_minute'),
            interval_minutes: $reader->requiredInt('interval_minutes'),
            history: $reader->requiredModelList('history', WebSocketMetricPoint::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'connections' => [$this->connections, true],
            'subscriptions' => [$this->subscriptions, true],
            'sent_per_second' => [$this->sent_per_second, true],
            'opened_per_minute' => [$this->opened_per_minute, true],
            'closed_per_minute' => [$this->closed_per_minute, true],
            'slow_clients_per_minute' => [$this->slow_clients_per_minute, true],
            'interval_minutes' => [$this->interval_minutes, true],
            'history' => [$this->history, true],
        ]);
    }
}
