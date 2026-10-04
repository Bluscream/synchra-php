<?php

declare(strict_types=1);

namespace Synchra\Tests\Support;

use Synchra\WebSocket\WebSocketTransport;

/**
 * A gateway transport driven from the test rather than from a socket.
 *
 * `push()` queues what the server would say next; `sent` holds every frame the client wrote, so a
 * test can assert on the authorization handshake and the resubscribe-after-reconnect behaviour
 * without a server.
 */
final class FakeWebSocketTransport implements WebSocketTransport
{
    /** @var list<string> */
    public array $sent = [];

    /** @var list<string|null> */
    private array $inbox = [];

    private bool $connected = false;

    public int $connects = 0;
    public int $closes = 0;

    private ?\Throwable $connectFailure = null;

    /**
     * Queues an inbound frame. A null entry stands for "nothing arrived before the timeout".
     */
    public function push(string|null $frame): self
    {
        $this->inbox[] = $frame;

        return $this;
    }

    public function pushJson(mixed $frame): self
    {
        return $this->push(\json_encode($frame, \JSON_THROW_ON_ERROR));
    }

    /**
     * Makes the next `connect()` throw once, standing in for a server that is briefly down.
     */
    public function failNextConnect(\Throwable $failure): self
    {
        $this->connectFailure = $failure;

        return $this;
    }

    public function connect(): void
    {
        ++$this->connects;

        if ($this->connectFailure !== null) {
            $failure = $this->connectFailure;
            $this->connectFailure = null;

            throw $failure;
        }

        $this->connected = true;
    }

    public function isConnected(): bool
    {
        return $this->connected;
    }

    public function sendText(string $payload): void
    {
        $this->sent[] = $payload;
    }

    public function receive(float $timeout): ?string
    {
        if ($this->inbox === []) {
            return null;
        }

        return \array_shift($this->inbox);
    }

    public function close(): void
    {
        ++$this->closes;
        $this->connected = false;
    }

    /**
     * Every frame the client sent, decoded, skipping the raw-text keepalives.
     *
     * @return list<array<string, mixed>>
     */
    public function sentCommands(): array
    {
        $out = [];

        foreach ($this->sent as $frame) {
            $decoded = \json_decode($frame, true);

            if (\is_array($decoded) && !\array_is_list($decoded)) {
                /** @var array<string, mixed> $decoded */
                $out[] = $decoded;
            }
        }

        return $out;
    }
}
