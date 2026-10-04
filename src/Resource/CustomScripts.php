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
 * The `Custom Scripts` endpoints.
 *
 * Reach this group with `$synchra->customScripts()`.
 */
final class CustomScripts extends AbstractResource
{
    /**
     * Delete Custom Script Kv Entries.
     *
     * `DELETE /api/2/channels/{channel_id}/custom-scripts/kv`
     *
     * @param \Synchra\Model\KvBulkDeleteRequest $payload The request body.
     */
    public function deleteCustomScriptKvEntries(string $channelId, \Synchra\Model\KvBulkDeleteRequest $payload): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'DELETE',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/custom-scripts/kv', ['channel_id' => $channelId]),
            body: $payload,
        );

        $this->client->send($request);
    }

    /**
     * Get Custom Script Kv Entries.
     *
     * `GET /api/2/channels/{channel_id}/custom-scripts/kv`
     *
     * @param ?\Synchra\Query\CustomScriptKvEntriesQuery $query Optional filters.
     * @return \Synchra\Pagination\Page<\Synchra\Model\KvEntry>
     */
    public function getCustomScriptKvEntries(string $channelId, ?\Synchra\Query\CustomScriptKvEntriesQuery $query = null): \Synchra\Pagination\Page
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/custom-scripts/kv', ['channel_id' => $channelId]),
            query: [...($query?->toArray() ?? [])],
        );

        return \Synchra\Pagination\Page::ofModel($this->client->send($request)->object(), \Synchra\Model\KvEntry::class);
    }

    /**
     * Get Custom Script Kv Storage State.
     *
     * `GET /api/2/channels/{channel_id}/custom-scripts/kv/state`
     */
    public function getCustomScriptKvStorageState(string $channelId): \Synchra\Model\KvStorageState
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/custom-scripts/kv/state', ['channel_id' => $channelId]),
        );

        return \Synchra\Model\KvStorageState::fromArray($this->client->send($request)->object());
    }

    /**
     * Get Custom Script Kv Value For Channel.
     *
     * `GET /api/2/channels/{channel_id}/custom-scripts/kv/value`
     */
    public function getCustomScriptKvValueForChannel(string $channelId, string $key): \Synchra\Model\KvValueState
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/custom-scripts/kv/value', ['channel_id' => $channelId]),
            query: ['key' => $key],
        );

        return \Synchra\Model\KvValueState::fromArray($this->client->send($request)->object());
    }

    /**
     * Get Custom Script Logs.
     *
     * `GET /api/2/channels/{channel_id}/custom-scripts/{owner_module}/{owner_uuid}/logs`
     *
     * @return list<\Synchra\Model\CustomScriptLogRecord>
     */
    public function getCustomScriptLogs(string $channelId, string $ownerModule, string $ownerUuid): array
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/custom-scripts/{owner_module}/{owner_uuid}/logs', ['channel_id' => $channelId, 'owner_module' => $ownerModule, 'owner_uuid' => $ownerUuid]),
        );

        return \array_map(\Synchra\Model\CustomScriptLogRecord::fromArray(...), $this->client->send($request)->objects());
    }

    /**
     * Delete Custom Script Kv Value.
     *
     * `POST /api/2/custom-scripts/kv/delete`
     *
     * @param \Synchra\Model\KvDeleteRequest $payload The request body.
     * @return array<string, mixed>
     */
    public function deleteCustomScriptKvValue(\Synchra\Model\KvDeleteRequest $payload, ?string $xKvToken = null): array
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: '/custom-scripts/kv/delete',
            body: $payload,
            headers: self::headers(['x-kv-token' => $xKvToken]),
        );

        return $this->client->send($request)->object();
    }

    /**
     * Get Custom Script Kv Value.
     *
     * `POST /api/2/custom-scripts/kv/get`
     *
     * @param \Synchra\Model\KvGetRequest $payload The request body.
     * @return array<string, mixed>
     */
    public function getCustomScriptKvValue(\Synchra\Model\KvGetRequest $payload, ?string $xKvToken = null): array
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: '/custom-scripts/kv/get',
            body: $payload,
            headers: self::headers(['x-kv-token' => $xKvToken]),
        );

        return $this->client->send($request)->object();
    }

    /**
     * Increment Custom Script Kv Value.
     *
     * `POST /api/2/custom-scripts/kv/inc`
     *
     * @param \Synchra\Model\KvIncRequest $payload The request body.
     * @return array<string, mixed>
     */
    public function incrementCustomScriptKvValue(\Synchra\Model\KvIncRequest $payload, ?string $xKvToken = null): array
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: '/custom-scripts/kv/inc',
            body: $payload,
            headers: self::headers(['x-kv-token' => $xKvToken]),
        );

        return $this->client->send($request)->object();
    }

    /**
     * Set Custom Script Kv Value.
     *
     * `POST /api/2/custom-scripts/kv/set`
     *
     * @param \Synchra\Model\KvSetRequest $payload The request body.
     * @return array<string, mixed>
     */
    public function setCustomScriptKvValue(\Synchra\Model\KvSetRequest $payload, ?string $xKvToken = null): array
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: '/custom-scripts/kv/set',
            body: $payload,
            headers: self::headers(['x-kv-token' => $xKvToken]),
        );

        return $this->client->send($request)->object();
    }
}
