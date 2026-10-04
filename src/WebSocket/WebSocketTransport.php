<?php

declare(strict_types=1);

namespace Synchra\WebSocket;

/**
 * A WebSocket connection, reduced to what the gateway needs.
 *
 * {@see PhrityTransport} is the default. Implement this to drive a different WebSocket library,
 * to run inside an existing event loop, or to replay a recorded session in a test.
 */
interface WebSocketTransport
{
    /**
     * @throws \Synchra\Exception\TransportException When the connection or handshake fails.
     */
    public function connect(): void;

    public function isConnected(): bool;

    /**
     * @throws \Synchra\Exception\TransportException When the frame cannot be written.
     */
    public function sendText(string $payload): void;

    /**
     * Waits for one text frame.
     *
     * @param float $timeout Seconds to wait.
     *
     * @return string|null The payload, or null when the wait elapsed with nothing to read.
     *
     * @throws \Synchra\Exception\TransportException When the connection drops.
     */
    public function receive(float $timeout): ?string;

    public function close(): void;
}
