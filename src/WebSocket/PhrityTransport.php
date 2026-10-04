<?php

declare(strict_types=1);

namespace Synchra\WebSocket;

use Synchra\Exception\ConfigurationException;
use Synchra\Exception\TransportException;
use WebSocket\Client;
use WebSocket\Exception\ConnectionClosedException;
use WebSocket\Exception\ConnectionTimeoutException;
use WebSocket\Exception\ExceptionInterface;
use WebSocket\Message\Binary;
use WebSocket\Message\Text;
use WebSocket\Middleware\CloseHandler;
use WebSocket\Middleware\PingResponder;

/**
 * Default transport, backed by phrity/websocket.
 *
 * Install it with `composer require phrity/websocket`; it is a dev dependency here because an
 * application that only calls the REST API should not have to pull in a WebSocket stack.
 */
final class PhrityTransport implements WebSocketTransport
{
    private ?Client $client = null;

    public function __construct(private readonly string $uri)
    {
        if (!\class_exists(Client::class)) {
            throw new ConfigurationException(
                'The realtime gateway needs a WebSocket client: run "composer require phrity/websocket", '
                . 'or pass your own Synchra\WebSocket\WebSocketTransport.',
            );
        }
    }

    public function connect(): void
    {
        $client = new Client($this->uri);
        $client->addMiddleware(new CloseHandler());
        $client->addMiddleware(new PingResponder());

        try {
            $client->connect();
        } catch (ExceptionInterface $e) {
            throw new TransportException(
                \sprintf('Could not connect to %s: %s', $this->uri, $e->getMessage()),
                0,
                $e,
            );
        }

        $this->client = $client;
    }

    public function isConnected(): bool
    {
        return $this->client?->isConnected() ?? false;
    }

    public function sendText(string $payload): void
    {
        try {
            $this->client()->send(new Text($payload));
        } catch (ExceptionInterface $e) {
            throw new TransportException('Could not send on the Synchra gateway: ' . $e->getMessage(), 0, $e);
        }
    }

    public function receive(float $timeout): ?string
    {
        $client = $this->client();
        $client->setTimeout($timeout);

        try {
            $message = $client->receive();
        } catch (ConnectionTimeoutException) {
            // Nothing arrived in the window. The caller decides whether to keep waiting.
            return null;
        } catch (ConnectionClosedException $e) {
            throw new TransportException('The Synchra gateway closed the connection.', 0, $e);
        } catch (ExceptionInterface $e) {
            throw new TransportException('Could not read from the Synchra gateway: ' . $e->getMessage(), 0, $e);
        }

        // Control frames are handled by the middlewares; binary frames are not part of the
        // protocol, so anything that is not text is not ours to interpret.
        return $message instanceof Binary ? null : $message->getContent();
    }

    public function close(): void
    {
        $this->client?->disconnect();
        $this->client = null;
    }

    private function client(): Client
    {
        $client = $this->client;

        if ($client === null) {
            throw new TransportException('The Synchra gateway is not connected.');
        }

        return $client;
    }
}
