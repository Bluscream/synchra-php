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

namespace Synchra\Resource;

use Synchra\Http\ApiClient;

/**
 * Base for the generated endpoint groups.
 *
 * Each subclass covers one tag of the API description and does nothing but describe
 * requests — transport, authentication and error handling all live in the client.
 */
abstract class AbstractResource
{
    public function __construct(protected readonly ApiClient $client) {}

    /**
     * The underlying client, for reaching an endpoint this package does not model yet.
     */
    final public function client(): ApiClient
    {
        return $this->client;
    }

    /**
     * Drops the headers a caller left unset.
     *
     * @param array<string, string|null> $headers
     *
     * @return array<string, string>
     */
    final protected static function headers(array $headers): array
    {
        $out = [];

        foreach ($headers as $name => $value) {
            if ($value !== null) {
                $out[$name] = $value;
            }
        }

        return $out;
    }
}
