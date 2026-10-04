<?php

declare(strict_types=1);

namespace Synchra\Http;

use Http\Discovery\Exception\NotFoundException as DiscoveryNotFound;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Synchra\Exception\ConfigurationException;
use Synchra\Exception\TransportException;

/**
 * Transport backed by any PSR-18 HTTP client.
 */
final readonly class PsrTransport implements Transport
{
    public function __construct(
        private ClientInterface $client,
        private RequestFactoryInterface $requestFactory,
        private StreamFactoryInterface $streamFactory,
    ) {}

    /**
     * Finds the PSR-18 client and PSR-17 factories the application already has installed.
     *
     * @throws ConfigurationException When no implementation is installed.
     */
    public static function discover(): self
    {
        try {
            return new self(
                Psr18ClientDiscovery::find(),
                Psr17FactoryDiscovery::findRequestFactory(),
                Psr17FactoryDiscovery::findStreamFactory(),
            );
        } catch (DiscoveryNotFound $e) {
            throw new ConfigurationException(
                'No PSR-18 HTTP client found. Install one (for example "composer require guzzlehttp/guzzle") '
                . 'or pass your own Synchra\Http\Transport.',
                0,
                $e,
            );
        }
    }

    public function send(string $method, string $uri, array $headers, ?string $body): TransportResponse
    {
        $request = $this->requestFactory->createRequest($method, $uri);

        foreach ($headers as $name => $value) {
            $request = $request->withHeader($name, $value);
        }

        if ($body !== null) {
            $request = $request->withBody($this->streamFactory->createStream($body));
        }

        try {
            $response = $this->client->sendRequest($request);
        } catch (ClientExceptionInterface $e) {
            throw new TransportException(
                \sprintf('%s %s failed: %s', $method, $uri, $e->getMessage()),
                0,
                $e,
            );
        }

        $normalised = [];

        foreach ($response->getHeaders() as $name => $values) {
            $normalised[\strtolower($name)] = \array_values($values);
        }

        return new TransportResponse($response->getStatusCode(), $normalised, (string) $response->getBody());
    }
}
