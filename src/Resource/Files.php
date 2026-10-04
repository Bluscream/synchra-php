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
 * The `Files` endpoints.
 *
 * Reach this group with `$synchra->files()`.
 */
final class Files extends AbstractResource
{
    /**
     * Get Files Route.
     *
     * `GET /api/2/files`
     *
     * Requires the `file.read` scope.
     *
     * @param ?\Synchra\Query\FilesQuery $query Optional filters.
     * @return \Synchra\Pagination\Page<\Synchra\Model\File>
     */
    public function getFiles(string $ownerId, string $ownerModule = 'channel', ?\Synchra\Query\FilesQuery $query = null): \Synchra\Pagination\Page
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: '/files',
            query: [...($query?->toArray() ?? []), 'owner_module' => $ownerModule, 'owner_id' => $ownerId],
        );

        return \Synchra\Pagination\Page::ofModel($this->client->send($request)->object(), \Synchra\Model\File::class);
    }

    /**
     * Upload File Route.
     *
     * `POST /api/2/files`
     *
     * Requires the `file.edit` scope.
     *
     * @param string $contents The raw bytes to upload.
     * @param ?\Synchra\Query\UploadFileQuery $query Optional filters.
     */
    public function uploadFile(string $ownerId, string $filename, string $contents, string $ownerModule = 'channel', ?\Synchra\Query\UploadFileQuery $query = null): \Synchra\Model\File
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: '/files',
            query: [...($query?->toArray() ?? []), 'owner_module' => $ownerModule, 'owner_id' => $ownerId, 'filename' => $filename],
            headers: ['Content-Type' => 'application/octet-stream'],
            rawBody: $contents,
        );

        return \Synchra\Model\File::fromArray($this->client->send($request)->object());
    }

    /**
     * Get File Storage Usage Route.
     *
     * `GET /api/2/files/usage`
     *
     * Requires the `file.read` scope.
     */
    public function getFileStorageUsage(string $ownerId, string $ownerModule = 'channel'): \Synchra\Model\FileStorageUsage
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: '/files/usage',
            query: ['owner_module' => $ownerModule, 'owner_id' => $ownerId],
        );

        return \Synchra\Model\FileStorageUsage::fromArray($this->client->send($request)->object());
    }

    /**
     * Delete File Route.
     *
     * `DELETE /api/2/files/{file_id}`
     *
     * Requires the `file.delete` scope.
     */
    public function deleteFile(string $fileId): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'DELETE',
            path: \Synchra\Http\Path::expand('/files/{file_id}', ['file_id' => $fileId]),
        );

        $this->client->send($request);
    }
}
