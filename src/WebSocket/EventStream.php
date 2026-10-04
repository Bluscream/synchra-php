<?php

declare(strict_types=1);

namespace Synchra\WebSocket;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Synchra\Auth\TokenProvider;
use Synchra\ClientOptions;
use Synchra\Exception\TransportException;

/**
 * The realtime gateway: subscribe to chat, activity, stream and widget events.
 *
 * ```php
 * $events = $synchra->events();
 *
 * $events->on(EventType::ChatMessage, function (Event $event): void {
 *     $message = $event->model();
 *     echo $message->viewer_display_name, ': ', $message->id, "\n";
 * });
 *
 * $events->subscribeChatMessage($channelId);
 * $events->run();            // blocks, reconnecting as needed
 * ```
 *
 * Subscriptions are remembered, so a reconnect restores them without the caller noticing.
 * To drive the socket from an existing loop, call {@see self::connect()} and then
 * {@see self::poll()} instead of {@see self::run()}.
 */
final class EventStream
{
    use Subscriptions;

    /** @var array<string, list<\Closure(Event): void>> */
    private array $handlers = [];

    /** @var list<\Closure(Event): void> */
    private array $anyHandlers = [];

    /** @var array<string, list<\Closure(): void>> */
    private array $lifecycle = [];

    /** @var list<Subscription> */
    private array $subscriptions = [];

    private ?WebSocketTransport $transport = null;
    private bool $running = false;
    private bool $authorized = false;
    private float $lastPingAt = 0.0;
    private float $nextDelay;

    public function __construct(
        private readonly TokenProvider $tokens,
        private readonly ClientOptions $options = new ClientOptions(),
        private readonly GatewayOptions $gateway = new GatewayOptions(),
        private readonly LoggerInterface $logger = new NullLogger(),
        private readonly ?WebSocketTransport $injectedTransport = null,
    ) {
        $this->nextDelay = $this->gateway->reconnectDelay;
    }

    /**
     * Registers a handler for one event type.
     *
     * @param \Closure(Event): void $handler
     */
    public function on(EventType|string $type, \Closure $handler): self
    {
        $key = $type instanceof EventType ? $type->value : $type;
        $this->handlers[$key][] = $handler;

        return $this;
    }

    /**
     * Registers a handler that sees every event, including `ok` and `error` frames.
     *
     * @param \Closure(Event): void $handler
     */
    public function onAny(\Closure $handler): self
    {
        $this->anyHandlers[] = $handler;

        return $this;
    }

    /** @param \Closure(Event): void $handler */
    public function onError(\Closure $handler): self
    {
        return $this->on('error', $handler);
    }

    /** @param \Closure(): void $handler */
    public function onConnect(\Closure $handler): self
    {
        $this->lifecycle['connect'][] = $handler;

        return $this;
    }

    /** @param \Closure(): void $handler */
    public function onDisconnect(\Closure $handler): self
    {
        $this->lifecycle['disconnect'][] = $handler;

        return $this;
    }

    /**
     * Subscribes to an event type.
     *
     * Safe to call before connecting: the subscription is sent as soon as the socket is up.
     *
     * @param array<string, string> $data The subscription key the event type requires.
     */
    public function subscribe(EventType|string $type, array $data, ?string $nonce = null): self
    {
        $subscription = new Subscription($type instanceof EventType ? $type->value : $type, $data, $nonce);

        foreach ($this->subscriptions as $existing) {
            if ($existing->matches($subscription)) {
                return $this;
            }
        }

        $this->subscriptions[] = $subscription;

        if ($this->transport?->isConnected() === true) {
            $this->sendJson($subscription->jsonSerialize());
        }

        return $this;
    }

    /** @param array<string, string> $data */
    public function unsubscribe(EventType|string $type, array $data): self
    {
        $target = new Subscription($type instanceof EventType ? $type->value : $type, $data);

        $this->subscriptions = \array_values(\array_filter(
            $this->subscriptions,
            static fn(Subscription $s): bool => !$s->matches($target),
        ));

        if ($this->transport?->isConnected() === true) {
            $this->sendJson(['command' => 'unsubscribe', 'type' => $target->type, 'data' => $target->data]);
        }

        return $this;
    }

    /**
     * Drops every subscription on this socket.
     */
    public function unsubscribeAll(): self
    {
        $this->subscriptions = [];

        if ($this->transport?->isConnected() === true) {
            $this->sendJson(['command' => 'unsubscribe']);
        }

        return $this;
    }

    /** @return list<Subscription> */
    public function subscriptions(): array
    {
        return $this->subscriptions;
    }

    public function isConnected(): bool
    {
        return $this->transport?->isConnected() ?? false;
    }

    /**
     * Opens the socket, authorises it and (re)sends every subscription.
     */
    public function connect(): void
    {
        $transport = $this->transport ??= $this->injectedTransport ?? new PhrityTransport($this->options->webSocketUri);

        if (!$transport->isConnected()) {
            $transport->connect();
            $this->authorized = false;
        }

        $token = $this->tokens->token();

        if (!$this->authorized && $token !== null && $token !== '') {
            $this->sendJson(['command' => 'authorization', 'data' => ['token' => $token]]);
            $this->authorized = true;
        }

        foreach ($this->subscriptions as $subscription) {
            $this->sendJson($subscription->jsonSerialize());
        }

        $this->lastPingAt = \microtime(true);
        $this->nextDelay = $this->gateway->reconnectDelay;
        $this->emitLifecycle('connect');
    }

    /**
     * Reads at most one event, dispatching it to the handlers.
     *
     * Returns null when the read window elapsed with nothing to read, or when the frame was a
     * keepalive `pong`. Requires {@see self::connect()} first.
     */
    public function poll(?float $timeout = null): ?Event
    {
        $raw = $this->requireTransport()->receive($timeout ?? $this->gateway->readTimeout);

        if ($raw === null) {
            return null;
        }

        $payload = \trim($raw);

        // The gateway answers the keepalive with the bare word `pong`, which is not JSON.
        if ($payload === 'pong' || $payload === '') {
            return null;
        }

        try {
            $decoded = \json_decode($payload, true, 512, \JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            $this->logger->warning('Discarding an unparsable Synchra gateway frame: {error}', ['error' => $e->getMessage()]);

            return null;
        }

        if (!\is_array($decoded) || \array_is_list($decoded)) {
            return null;
        }

        /** @var array<string, mixed> $decoded */
        $event = Event::fromArray($decoded);
        $this->dispatch($event);

        return $event;
    }

    /**
     * Blocks, dispatching events until {@see self::stop()} is called or `$seconds` elapses.
     *
     * Reconnects with backoff when the connection drops, unless that is switched off in
     * {@see GatewayOptions}.
     */
    public function run(?float $seconds = null): void
    {
        $this->running = true;
        $deadline = $seconds === null ? null : \microtime(true) + $seconds;

        while ($this->running) {
            try {
                if (!$this->isConnected()) {
                    $this->connect();
                }

                $this->poll($this->windowUntil($deadline));
                $this->keepAlive();
            } catch (TransportException $e) {
                $this->logger->info('Synchra gateway disconnected: {error}', ['error' => $e->getMessage()]);
                $this->handleDrop();

                if (!$this->gateway->reconnect) {
                    $this->running = false;

                    return;
                }

                $this->gateway->sleep($this->nextDelay);
                $this->nextDelay = \min($this->nextDelay * $this->gateway->reconnectFactor, $this->gateway->maxReconnectDelay);
            }

            if ($deadline !== null && \microtime(true) >= $deadline) {
                $this->running = false;
            }
        }
    }

    /**
     * Asks {@see self::run()} to return after the current read. Safe to call from a handler.
     */
    public function stop(): void
    {
        $this->running = false;
    }

    public function isRunning(): bool
    {
        return $this->running;
    }

    /**
     * Closes the socket. Subscriptions are kept, so a later `connect()` restores them.
     */
    public function close(): void
    {
        $this->running = false;
        $this->transport?->close();
        $this->authorized = false;
        $this->emitLifecycle('disconnect');
    }

    /**
     * Sends the keepalive if enough time has passed since the last one.
     */
    private function keepAlive(): void
    {
        $now = \microtime(true);

        if ($now - $this->lastPingAt < $this->gateway->pingInterval) {
            return;
        }

        $this->requireTransport()->sendText('ping');
        $this->lastPingAt = $now;
    }

    private function handleDrop(): void
    {
        $this->transport?->close();
        $this->authorized = false;
        $this->emitLifecycle('disconnect');
    }

    private function windowUntil(?float $deadline): float
    {
        if ($deadline === null) {
            return $this->gateway->readTimeout;
        }

        return \max(0.0, \min($this->gateway->readTimeout, $deadline - \microtime(true)));
    }

    private function dispatch(Event $event): void
    {
        foreach ([...$this->anyHandlers, ...($this->handlers[$event->type] ?? [])] as $handler) {
            // One failing handler must not take down the loop or the other handlers with it.
            try {
                $handler($event);
            } catch (\Throwable $e) {
                $this->logger->error('A Synchra {type} handler threw: {error}', [
                    'type' => $event->type,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }

    private function emitLifecycle(string $name): void
    {
        foreach ($this->lifecycle[$name] ?? [] as $handler) {
            try {
                $handler();
            } catch (\Throwable $e) {
                $this->logger->error('A Synchra {name} handler threw: {error}', [
                    'name' => $name,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }

    /** @param array<string, mixed> $payload */
    private function sendJson(array $payload): void
    {
        $this->requireTransport()->sendText(
            \json_encode($payload, \JSON_THROW_ON_ERROR | \JSON_UNESCAPED_SLASHES | \JSON_UNESCAPED_UNICODE),
        );
    }

    private function requireTransport(): WebSocketTransport
    {
        $transport = $this->transport;

        if ($transport === null) {
            throw new TransportException('Call connect() before using the Synchra gateway.');
        }

        return $transport;
    }
}
