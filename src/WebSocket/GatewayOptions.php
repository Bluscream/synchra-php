<?php

declare(strict_types=1);

namespace Synchra\WebSocket;

/**
 * Timing for the realtime gateway.
 *
 * The defaults mirror what the Synchra dashboard does: a keepalive well inside the idle window,
 * and a reconnect that backs off to minutes rather than retrying tightly against an outage.
 */
final readonly class GatewayOptions
{
    /**
     * @param float $pingInterval Seconds between keepalive pings.
     * @param float $readTimeout Seconds one read waits before the loop does its housekeeping.
     *                           Shorter means pings and stop() land sooner, at more wakeups.
     * @param float $reconnectDelay First reconnect delay; multiplied by `$reconnectFactor` each
     *                              failure.
     * @param float $maxReconnectDelay Ceiling for the reconnect delay.
     * @param bool $reconnect Whether {@see EventStream::run()} reconnects after a drop.
     * @param (\Closure(float): void)|null $sleeper Overrides the backoff sleep, for tests.
     */
    public function __construct(
        public float $pingInterval = 30.0,
        public float $readTimeout = 1.0,
        public float $reconnectDelay = 1.0,
        public float $maxReconnectDelay = 300.0,
        public float $reconnectFactor = 1.5,
        public bool $reconnect = true,
        public ?\Closure $sleeper = null,
    ) {}

    public function sleep(float $seconds): void
    {
        if ($seconds <= 0.0) {
            return;
        }

        if ($this->sleeper !== null) {
            ($this->sleeper)($seconds);

            return;
        }

        \usleep((int) \round($seconds * 1_000_000));
    }
}
