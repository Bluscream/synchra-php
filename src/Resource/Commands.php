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
 * The `Commands` endpoints.
 *
 * Reach this group with `$synchra->commands()`.
 */
final class Commands extends AbstractResource
{
    /**
     * Get Commands.
     *
     * `GET /api/2/channels/{channel_id}/commands`
     *
     * Requires the `command:read` scope.
     *
     * @param ?\Synchra\Query\CommandsQuery $query Optional filters.
     * @return \Synchra\Pagination\Page<\Synchra\Model\Command>
     */
    public function getCommands(string $channelId, ?\Synchra\Query\CommandsQuery $query = null): \Synchra\Pagination\Page
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/commands', ['channel_id' => $channelId]),
            query: [...($query?->toArray() ?? [])],
        );

        return \Synchra\Pagination\Page::ofModel($this->client->send($request)->object(), \Synchra\Model\Command::class);
    }

    /**
     * Create Command.
     *
     * `POST /api/2/channels/{channel_id}/commands`
     *
     * Requires the `command:write` scope.
     *
     * @param \Synchra\Model\CommandCreate $payload The request body.
     */
    public function createCommand(string $channelId, \Synchra\Model\CommandCreate $payload): \Synchra\Model\Command
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/commands', ['channel_id' => $channelId]),
            body: $payload,
        );

        return \Synchra\Model\Command::fromArray($this->client->send($request)->object());
    }

    /**
     * Test Command Script.
     *
     * `POST /api/2/channels/{channel_id}/commands/script-test`
     *
     * Requires the `command:write` scope.
     *
     * @param \Synchra\Model\CommandScriptTestRequest $payload The request body.
     */
    public function testCommandScript(string $channelId, \Synchra\Model\CommandScriptTestRequest $payload): \Synchra\Model\CustomScriptRunResult
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/commands/script-test', ['channel_id' => $channelId]),
            body: $payload,
        );

        return \Synchra\Model\CustomScriptRunResult::fromArray($this->client->send($request)->object());
    }

    /**
     * Delete Command.
     *
     * `DELETE /api/2/channels/{channel_id}/commands/{command_id}`
     *
     * Requires the `command:write` scope.
     */
    public function deleteCommand(string $channelId, string $commandId): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'DELETE',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/commands/{command_id}', ['channel_id' => $channelId, 'command_id' => $commandId]),
        );

        $this->client->send($request);
    }

    /**
     * Get Command.
     *
     * `GET /api/2/channels/{channel_id}/commands/{command_id}`
     *
     * Requires the `command:read` scope.
     */
    public function getCommand(string $channelId, string $commandId): \Synchra\Model\Command
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/commands/{command_id}', ['channel_id' => $channelId, 'command_id' => $commandId]),
        );

        return \Synchra\Model\Command::fromArray($this->client->send($request)->object());
    }

    /**
     * Update Command.
     *
     * `PUT /api/2/channels/{channel_id}/commands/{command_id}`
     *
     * Requires the `command:write` scope.
     *
     * @param \Synchra\Model\CommandUpdate $payload The request body.
     */
    public function updateCommand(string $channelId, string $commandId, \Synchra\Model\CommandUpdate $payload): \Synchra\Model\Command
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'PUT',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/commands/{command_id}', ['channel_id' => $channelId, 'command_id' => $commandId]),
            body: $payload,
        );

        return \Synchra\Model\Command::fromArray($this->client->send($request)->object());
    }
}
