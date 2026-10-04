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
 * The `Admin HTTP Proxies` endpoints.
 *
 * Reach this group with `$synchra->adminHttpProxies()`.
 */
final class AdminHttpProxies extends AbstractResource
{
    /**
     * Get Http Proxies Route.
     *
     * `GET /api/2/admin/http-proxies`
     *
     * @return list<\Synchra\Model\HttpProxy>
     */
    public function getHttpProxies(): array
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: '/admin/http-proxies',
        );

        return \array_map(\Synchra\Model\HttpProxy::fromArray(...), $this->client->send($request)->objects());
    }

    /**
     * Create Http Proxy Route.
     *
     * `POST /api/2/admin/http-proxies`
     *
     * @param \Synchra\Model\HttpProxyCreate $payload The request body.
     */
    public function createHttpProxy(\Synchra\Model\HttpProxyCreate $payload): \Synchra\Model\HttpProxy
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: '/admin/http-proxies',
            body: $payload,
        );

        return \Synchra\Model\HttpProxy::fromArray($this->client->send($request)->object());
    }

    /**
     * Delete Http Proxy Route.
     *
     * `DELETE /api/2/admin/http-proxies/{http_proxy_id}`
     */
    public function deleteHttpProxy(string $httpProxyId): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'DELETE',
            path: \Synchra\Http\Path::expand('/admin/http-proxies/{http_proxy_id}', ['http_proxy_id' => $httpProxyId]),
        );

        $this->client->send($request);
    }

    /**
     * Disable Http Proxy Route.
     *
     * `POST /api/2/admin/http-proxies/{http_proxy_id}/disable`
     */
    public function disableHttpProxy(string $httpProxyId): \Synchra\Model\HttpProxy
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/admin/http-proxies/{http_proxy_id}/disable', ['http_proxy_id' => $httpProxyId]),
        );

        return \Synchra\Model\HttpProxy::fromArray($this->client->send($request)->object());
    }

    /**
     * Reset Http Proxy Domain Route.
     *
     * `POST /api/2/admin/http-proxies/{http_proxy_id}/domains/{domain}/reset`
     */
    public function resetHttpProxyDomain(string $httpProxyId, string $domain): \Synchra\Model\HttpProxy
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/admin/http-proxies/{http_proxy_id}/domains/{domain}/reset', ['http_proxy_id' => $httpProxyId, 'domain' => $domain]),
        );

        return \Synchra\Model\HttpProxy::fromArray($this->client->send($request)->object());
    }

    /**
     * Reset Http Proxy Route.
     *
     * `POST /api/2/admin/http-proxies/{http_proxy_id}/reset`
     */
    public function resetHttpProxy(string $httpProxyId): \Synchra\Model\HttpProxy
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/admin/http-proxies/{http_proxy_id}/reset', ['http_proxy_id' => $httpProxyId]),
        );

        return \Synchra\Model\HttpProxy::fromArray($this->client->send($request)->object());
    }

    /**
     * Test Http Proxy Route.
     *
     * `POST /api/2/admin/http-proxies/{http_proxy_id}/test`
     *
     * @param \Synchra\Model\HttpProxyTest $payload The request body.
     */
    public function testHttpProxy(string $httpProxyId, \Synchra\Model\HttpProxyTest $payload): \Synchra\Model\HttpProxyTestResult
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/admin/http-proxies/{http_proxy_id}/test', ['http_proxy_id' => $httpProxyId]),
            body: $payload,
        );

        return \Synchra\Model\HttpProxyTestResult::fromArray($this->client->send($request)->object());
    }
}
