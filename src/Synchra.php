<?php

declare(strict_types=1);

namespace Synchra;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Synchra\Auth\StaticToken;
use Synchra\Auth\TokenProvider;
use Synchra\Http\ApiClient;
use Synchra\Http\PsrTransport;
use Synchra\Http\Transport;
use Synchra\Resource\AbstractResource;
use Synchra\Resource\ResourceAccessors;
use Synchra\WebSocket\EventStream;

/**
 * Entry point for the Synchra API.
 *
 * ```php
 * $synchra = Synchra::withToken(getenv('SYNCHRA_TOKEN'));
 *
 * $me = $synchra->user()->getUser();
 * $channels = $synchra->channel()->getChannels();
 *
 * foreach ($channels as $channel) {
 *     echo $channel->display_name, "\n";
 * }
 * ```
 *
 * Every endpoint group is reachable from here; see {@see ResourceAccessors} for the full list.
 * Realtime events go through {@see self::events()}.
 */
final class Synchra
{
    use ResourceAccessors;

    public const VERSION = '0.1.0';

    private readonly ApiClient $api;

    /** @var array<class-string<AbstractResource>, AbstractResource> */
    private array $resources = [];

    private ?EventStream $eventStream = null;

    public function __construct(
        private readonly TokenProvider $tokens,
        private readonly ClientOptions $options = new ClientOptions(),
        ?Transport $transport = null,
        private readonly LoggerInterface $logger = new NullLogger(),
    ) {
        $this->api = new ApiClient(
            $this->tokens,
            $this->options,
            $transport ?? PsrTransport::discover(),
            $this->logger,
        );
    }

    /**
     * Builds a client from a personal access token.
     *
     * Tokens are issued by the Synchra dashboard and carry a fixed scope set; the API rejects a
     * call whose scope the token does not hold, so a narrow token fails loudly rather than
     * silently doing less.
     */
    public static function withToken(?string $token, ?ClientOptions $options = null): self
    {
        return new self(new StaticToken($token), $options ?? new ClientOptions());
    }

    /**
     * Builds a client from the `SYNCHRA_TOKEN` environment variable.
     */
    public static function fromEnvironment(?ClientOptions $options = null): self
    {
        return new self(StaticToken::fromEnvironment(), $options ?? new ClientOptions());
    }

    /**
     * The HTTP client every endpoint group shares.
     */
    public function api(): ApiClient
    {
        return $this->api;
    }

    public function options(): ClientOptions
    {
        return $this->options;
    }

    /**
     * The realtime gateway, for subscribing to chat, activity, widget and stream events.
     *
     * The stream is created on first use and reused afterwards, so handlers registered on it stay
     * registered across calls.
     */
    public function events(): EventStream
    {
        return $this->eventStream ??= new EventStream($this->tokens, $this->options, logger: $this->logger);
    }

    /**
     * @template T of AbstractResource
     *
     * @param class-string<T> $class
     *
     * @return T
     */
    private function resource(string $class): AbstractResource
    {
        $existing = $this->resources[$class] ?? null;

        if ($existing instanceof $class) {
            return $existing;
        }

        return $this->resources[$class] = new $class($this->api);
    }
}
