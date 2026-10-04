<?php

declare(strict_types=1);

namespace Synchra\Http;

/**
 * Performs one HTTP exchange.
 *
 * This sits between the SDK and whichever HTTP library an application already uses.
 * {@see PsrTransport} covers any PSR-18 client; implement this directly to drive a transport
 * that is not PSR-18, or to record and replay traffic in tests.
 */
interface Transport
{
    /**
     * @param array<string, string> $headers
     *
     * @throws \Synchra\Exception\TransportException When no response could be obtained.
     */
    public function send(string $method, string $uri, array $headers, ?string $body): TransportResponse;
}
