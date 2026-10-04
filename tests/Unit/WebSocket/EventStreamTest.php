<?php

declare(strict_types=1);

namespace Synchra\Tests\Unit\WebSocket;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Synchra\Auth\StaticToken;
use Synchra\ClientOptions;
use Synchra\Exception\TransportException;
use Synchra\Tests\Support\FakeWebSocketTransport;
use Synchra\WebSocket\Event;
use Synchra\WebSocket\EventAction;
use Synchra\WebSocket\EventStream;
use Synchra\WebSocket\EventType;
use Synchra\WebSocket\GatewayOptions;

#[CoversClass(EventStream::class)]
final class EventStreamTest extends TestCase
{
    private function stream(
        FakeWebSocketTransport $transport,
        ?GatewayOptions $gateway = null,
        ?string $token = 'test-token',
    ): EventStream {
        return new EventStream(
            new StaticToken($token),
            new ClientOptions(),
            $gateway ?? new GatewayOptions(sleeper: static function (float $seconds): void {}),
            injectedTransport: $transport,
        );
    }

    public function testConnectingAuthorisesBeforeAnythingElse(): void
    {
        $transport = new FakeWebSocketTransport();
        $this->stream($transport)->connect();

        $commands = $transport->sentCommands();

        self::assertSame('authorization', $commands[0]['command']);
        self::assertSame(['token' => 'test-token'], $commands[0]['data']);
    }

    public function testNoAuthorizationFrameIsSentWithoutAToken(): void
    {
        $transport = new FakeWebSocketTransport();
        $this->stream($transport, token: null)->connect();

        self::assertSame([], $transport->sentCommands());
    }

    public function testSubscribingBeforeConnectingSendsOnConnect(): void
    {
        $transport = new FakeWebSocketTransport();
        $stream = $this->stream($transport);

        $stream->subscribe(EventType::ChatMessage, ['channel_id' => 'c1']);

        self::assertSame([], $transport->sent, 'Nothing can be written before the socket is up.');

        $stream->connect();
        $commands = $transport->sentCommands();

        self::assertSame('subscribe', $commands[1]['command']);
        self::assertSame('chat_message', $commands[1]['type']);
        self::assertSame(['channel_id' => 'c1'], $commands[1]['data']);
    }

    public function testSubscribingWhileConnectedSendsImmediately(): void
    {
        $transport = new FakeWebSocketTransport();
        $stream = $this->stream($transport);
        $stream->connect();
        $stream->subscribe(EventType::ChatMessage, ['channel_id' => 'c1']);

        self::assertCount(2, $transport->sentCommands());
    }

    public function testSubscribingTwiceToTheSameKeyIsIgnored(): void
    {
        $transport = new FakeWebSocketTransport();
        $stream = $this->stream($transport);
        $stream->connect();
        $stream->subscribe(EventType::ChatMessage, ['channel_id' => 'c1']);
        $stream->subscribe(EventType::ChatMessage, ['channel_id' => 'c1']);

        self::assertCount(1, $stream->subscriptions());
    }

    public function testKeyOrderDoesNotCreateADuplicateSubscription(): void
    {
        $transport = new FakeWebSocketTransport();
        $stream = $this->stream($transport);
        $stream->subscribe('kv', ['channel_id' => 'c1', 'key' => 'k']);
        $stream->subscribe('kv', ['key' => 'k', 'channel_id' => 'c1']);

        self::assertCount(1, $stream->subscriptions());
    }

    public function testUnsubscribingDropsTheSubscriptionAndTellsTheServer(): void
    {
        $transport = new FakeWebSocketTransport();
        $stream = $this->stream($transport);
        $stream->connect();
        $stream->subscribe(EventType::ChatMessage, ['channel_id' => 'c1']);
        $stream->unsubscribe(EventType::ChatMessage, ['channel_id' => 'c1']);

        self::assertSame([], $stream->subscriptions());

        $last = $transport->sentCommands()[\count($transport->sentCommands()) - 1];

        self::assertSame('unsubscribe', $last['command']);
        self::assertSame('chat_message', $last['type']);
    }

    public function testUnsubscribeAllSendsABareUnsubscribe(): void
    {
        $transport = new FakeWebSocketTransport();
        $stream = $this->stream($transport);
        $stream->connect();
        $stream->subscribe(EventType::ChatMessage, ['channel_id' => 'c1']);
        $stream->subscribe(EventType::ChannelProviderStream, ['channel_id' => 'c1']);
        $stream->unsubscribeAll();

        self::assertSame([], $stream->subscriptions());

        $last = $transport->sentCommands()[\count($transport->sentCommands()) - 1];

        self::assertSame(['command' => 'unsubscribe'], $last);
    }

    public function testAnEventIsDispatchedToTheHandlerForItsType(): void
    {
        $transport = (new FakeWebSocketTransport())->pushJson([
            'type' => 'chat_message',
            'action' => 'new',
            'data' => ['id' => 'm1'],
        ]);

        $seen = [];
        $stream = $this->stream($transport);
        $stream->on(EventType::ChatMessage, function (Event $event) use (&$seen): void {
            $seen[] = $event;
        });
        $stream->connect();
        $stream->poll(0.0);

        self::assertCount(1, $seen);
        self::assertSame(EventAction::New, $seen[0]->action);
        self::assertSame(['id' => 'm1'], $seen[0]->dataObject());
    }

    public function testAHandlerForADifferentTypeIsNotCalled(): void
    {
        $transport = (new FakeWebSocketTransport())->pushJson([
            'type' => 'chat_message',
            'action' => 'new',
            'data' => [],
        ]);

        $called = false;
        $stream = $this->stream($transport);
        $stream->on(EventType::ChannelProviderStream, function (Event $event) use (&$called): void {
            $called = true;
        });
        $stream->connect();
        $stream->poll(0.0);

        self::assertFalse($called);
    }

    public function testOnAnySeesEveryFrameIncludingAcknowledgements(): void
    {
        $transport = (new FakeWebSocketTransport())
            ->pushJson(['type' => 'ok', 'nonce' => 'n1'])
            ->pushJson(['type' => 'chat_message', 'action' => 'new', 'data' => []]);

        $types = [];
        $stream = $this->stream($transport);
        $stream->onAny(function (Event $event) use (&$types): void {
            $types[] = $event->type;
        });
        $stream->connect();
        $stream->poll(0.0);
        $stream->poll(0.0);

        self::assertSame(['ok', 'chat_message'], $types);
    }

    public function testAKeepalivePongIsNotAnEvent(): void
    {
        $transport = (new FakeWebSocketTransport())->push('pong');
        $stream = $this->stream($transport);
        $stream->connect();

        self::assertNull($stream->poll(0.0));
    }

    public function testAnEmptyReadWindowYieldsNothing(): void
    {
        $transport = new FakeWebSocketTransport();
        $stream = $this->stream($transport);
        $stream->connect();

        self::assertNull($stream->poll(0.0));
    }

    public function testAnUnparsableFrameIsDiscardedRatherThanKillingTheLoop(): void
    {
        $transport = (new FakeWebSocketTransport())->push('{not json');
        $stream = $this->stream($transport);
        $stream->connect();

        self::assertNull($stream->poll(0.0));
    }

    public function testAFailingHandlerDoesNotStopTheOtherHandlers(): void
    {
        $transport = (new FakeWebSocketTransport())->pushJson([
            'type' => 'chat_message',
            'action' => 'new',
            'data' => [],
        ]);

        $second = false;
        $stream = $this->stream($transport);
        $stream->on(EventType::ChatMessage, static function (Event $event): void {
            throw new \RuntimeException('handler blew up');
        });
        $stream->on(EventType::ChatMessage, function (Event $event) use (&$second): void {
            $second = true;
        });
        $stream->connect();
        $stream->poll(0.0);

        self::assertTrue($second);
    }

    public function testPollingBeforeConnectingSaysSo(): void
    {
        $this->expectException(TransportException::class);
        $this->expectExceptionMessage('connect()');

        $this->stream(new FakeWebSocketTransport())->poll(0.0);
    }

    public function testLifecycleHandlersFireOnConnectAndClose(): void
    {
        $transport = new FakeWebSocketTransport();
        $events = [];
        $stream = $this->stream($transport);
        $stream->onConnect(function () use (&$events): void {
            $events[] = 'connect';
        });
        $stream->onDisconnect(function () use (&$events): void {
            $events[] = 'disconnect';
        });

        $stream->connect();
        $stream->close();

        self::assertSame(['connect', 'disconnect'], $events);
    }

    public function testRunReconnectsAfterADropAndRestoresEverySubscription(): void
    {
        // This is the behaviour that makes the gateway usable unattended: a dropped socket must
        // come back with the same subscriptions, without the caller re-registering anything.
        $transport = new FakeWebSocketTransport();
        $stream = $this->stream($transport, new GatewayOptions(
            readTimeout: 0.0,
            reconnectDelay: 0.0,
            reconnect: true,
            sleeper: static function (float $seconds): void {},
        ));

        $stream->subscribe(EventType::ChatMessage, ['channel_id' => 'c1']);
        $stream->connect();

        self::assertSame(1, $transport->connects);

        // Simulate the server going away mid-read, then let run() handle one cycle.
        $transport->close();
        $stream->run(0.0);

        self::assertGreaterThanOrEqual(2, $transport->connects);

        $subscribes = \array_values(\array_filter(
            $transport->sentCommands(),
            static fn(array $command): bool => ($command['command'] ?? null) === 'subscribe',
        ));

        self::assertCount(2, $subscribes, 'The subscription has to be re-sent on the new socket.');
    }

    public function testRunStopsInsteadOfReconnectingWhenReconnectIsOff(): void
    {
        $transport = (new FakeWebSocketTransport())
            ->failNextConnect(new TransportException('refused'));

        $stream = $this->stream($transport, new GatewayOptions(
            readTimeout: 0.0,
            reconnect: false,
            sleeper: static function (float $seconds): void {},
        ));

        $stream->run(0.0);

        self::assertFalse($stream->isRunning());
        self::assertSame(1, $transport->connects);
    }

    public function testAHandlerCanStopTheLoop(): void
    {
        $transport = (new FakeWebSocketTransport())->pushJson([
            'type' => 'chat_message',
            'action' => 'new',
            'data' => [],
        ]);

        $stream = $this->stream($transport, new GatewayOptions(
            readTimeout: 0.0,
            sleeper: static function (float $seconds): void {},
        ));
        $stream->on(EventType::ChatMessage, static function (Event $event) use (&$stream): void {
            $stream->stop();
        });

        $stream->run(5.0);

        self::assertFalse($stream->isRunning());
    }

    public function testClosingKeepsTheSubscriptionsForTheNextConnect(): void
    {
        $transport = new FakeWebSocketTransport();
        $stream = $this->stream($transport);
        $stream->subscribe(EventType::ChatMessage, ['channel_id' => 'c1']);
        $stream->connect();
        $stream->close();

        self::assertCount(1, $stream->subscriptions());
        self::assertFalse($stream->isConnected());
    }
}
