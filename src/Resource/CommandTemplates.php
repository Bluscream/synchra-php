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
 * The `Command Templates` endpoints.
 *
 * Reach this group with `$synchra->commandTemplates()`.
 */
final class CommandTemplates extends AbstractResource
{
    /**
     * Get Command Templates.
     *
     * `GET /api/2/command-templates`
     *
     * Requires the `command:read` scope.
     *
     * @param ?\Synchra\Query\CommandTemplatesQuery $query Optional filters.
     * @return \Synchra\Pagination\Page<\Synchra\Model\CommandTemplate>
     */
    public function getCommandTemplates(?\Synchra\Query\CommandTemplatesQuery $query = null): \Synchra\Pagination\Page
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: '/command-templates',
            query: [...($query?->toArray() ?? [])],
        );

        return \Synchra\Pagination\Page::ofModel($this->client->send($request)->object(), \Synchra\Model\CommandTemplate::class);
    }

    /**
     * Get Command Template.
     *
     * `GET /api/2/command-templates/{command_template_id}`
     *
     * Requires the `command:read` scope.
     */
    public function getCommandTemplate(string $commandTemplateId): \Synchra\Model\CommandTemplate
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/command-templates/{command_template_id}', ['command_template_id' => $commandTemplateId]),
        );

        return \Synchra\Model\CommandTemplate::fromArray($this->client->send($request)->object());
    }
}
