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
 * The `WebSocket` endpoints.
 *
 * Reach this group with `$synchra->gateway()`.
 */
final class Gateway extends AbstractResource
{
    /**
     * Get Admin Websocket Metrics.
     *
     * `GET /api/2/admin/websockets/overview`
     *
     * Requires the `channel:read` scope.
     */
    public function getAdminWebsocketMetrics(): \Synchra\Model\WebSocketMetricsOverview
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: '/admin/websockets/overview',
        );

        return \Synchra\Model\WebSocketMetricsOverview::fromArray($this->client->send($request)->object());
    }

    /**
     * Websocket Documentation.
     *
     * `GET /api/2/ws-docs`
     */
    public function websocketDocumentation(): mixed
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: '/ws-docs',
        );

        return $this->client->send($request)->data;
    }
}
