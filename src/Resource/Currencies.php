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

/**
 * The `Currencies` endpoints.
 *
 * Reach this group with `$synchra->currencies()`.
 */
final class Currencies extends AbstractResource
{
    /**
     * Get Currency Rates.
     *
     * `GET /api/2/currencies.json`
     */
    public function getCurrencyRates(): \Synchra\Model\CurrencyRates
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: '/currencies.json',
        );

        return \Synchra\Model\CurrencyRates::fromArray($this->client->send($request)->object());
    }
}
