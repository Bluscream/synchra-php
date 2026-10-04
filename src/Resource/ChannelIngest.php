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
 * The `Channel Ingest` endpoints.
 *
 * Reach this group with `$synchra->channelIngest()`.
 */
final class ChannelIngest extends AbstractResource
{
    /**
     * Get Ingest Api Keys.
     *
     * `GET /api/2/channels/{channel_id}/ingest-api-keys`
     *
     * Requires the `ingest_api_key:read` scope.
     *
     * @param ?\Synchra\Query\IngestApiKeysQuery $query Optional filters.
     * @return \Synchra\Pagination\Page<\Synchra\Model\IngestApiKey>
     */
    public function getIngestApiKeys(string $channelId, ?\Synchra\Query\IngestApiKeysQuery $query = null): \Synchra\Pagination\Page
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/ingest-api-keys', ['channel_id' => $channelId]),
            query: [...($query?->toArray() ?? [])],
        );

        return \Synchra\Pagination\Page::ofModel($this->client->send($request)->object(), \Synchra\Model\IngestApiKey::class);
    }

    /**
     * Create Ingest Api Key.
     *
     * `POST /api/2/channels/{channel_id}/ingest-api-keys`
     *
     * Requires the `ingest_api_key:write` scope.
     *
     * @param \Synchra\Model\IngestApiKeyCreate $payload The request body.
     */
    public function createIngestApiKey(string $channelId, \Synchra\Model\IngestApiKeyCreate $payload): \Synchra\Model\IngestApiKey
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/ingest-api-keys', ['channel_id' => $channelId]),
            body: $payload,
        );

        return \Synchra\Model\IngestApiKey::fromArray($this->client->send($request)->object());
    }

    /**
     * Delete Ingest Api Key.
     *
     * `DELETE /api/2/channels/{channel_id}/ingest-api-keys/{ingest_api_key_id}`
     *
     * Requires the `ingest_api_key:write` scope.
     */
    public function deleteIngestApiKey(string $channelId, string $ingestApiKeyId): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'DELETE',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/ingest-api-keys/{ingest_api_key_id}', ['channel_id' => $channelId, 'ingest_api_key_id' => $ingestApiKeyId]),
        );

        $this->client->send($request);
    }

    /**
     * Get Ingest Api Key.
     *
     * `GET /api/2/channels/{channel_id}/ingest-api-keys/{ingest_api_key_id}`
     *
     * Requires the `ingest_api_key:read` scope.
     */
    public function getIngestApiKey(string $channelId, string $ingestApiKeyId): \Synchra\Model\IngestApiKey
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/ingest-api-keys/{ingest_api_key_id}', ['channel_id' => $channelId, 'ingest_api_key_id' => $ingestApiKeyId]),
        );

        return \Synchra\Model\IngestApiKey::fromArray($this->client->send($request)->object());
    }

    /**
     * Update Ingest Api Key.
     *
     * `PUT /api/2/channels/{channel_id}/ingest-api-keys/{ingest_api_key_id}`
     *
     * Requires the `ingest_api_key:write` scope.
     *
     * @param \Synchra\Model\IngestApiKeyUpdate $payload The request body.
     */
    public function updateIngestApiKey(string $channelId, string $ingestApiKeyId, \Synchra\Model\IngestApiKeyUpdate $payload): \Synchra\Model\IngestApiKey
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'PUT',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/ingest-api-keys/{ingest_api_key_id}', ['channel_id' => $channelId, 'ingest_api_key_id' => $ingestApiKeyId]),
            body: $payload,
        );

        return \Synchra\Model\IngestApiKey::fromArray($this->client->send($request)->object());
    }
}
