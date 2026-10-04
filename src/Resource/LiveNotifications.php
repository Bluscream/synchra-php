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
 * The `Live Notifications` endpoints.
 *
 * Reach this group with `$synchra->liveNotifications()`.
 */
final class LiveNotifications extends AbstractResource
{
    /**
     * Get Live Notification Webhooks Route.
     *
     * `GET /api/2/channels/{channel_id}/live-notifications`
     *
     * @param ?\Synchra\Query\LiveNotificationWebhooksQuery $query Optional filters.
     * @return \Synchra\Pagination\Page<\Synchra\Model\LiveNotificationWebhook>
     */
    public function getLiveNotificationWebhooks(string $channelId, ?\Synchra\Query\LiveNotificationWebhooksQuery $query = null): \Synchra\Pagination\Page
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/live-notifications', ['channel_id' => $channelId]),
            query: [...($query?->toArray() ?? [])],
        );

        return \Synchra\Pagination\Page::ofModel($this->client->send($request)->object(), \Synchra\Model\LiveNotificationWebhook::class);
    }

    /**
     * Create Live Notification Webhook Route.
     *
     * `POST /api/2/channels/{channel_id}/live-notifications`
     *
     * @param \Synchra\Model\LiveNotificationWebhookCreate $payload The request body.
     */
    public function createLiveNotificationWebhook(string $channelId, \Synchra\Model\LiveNotificationWebhookCreate $payload): \Synchra\Model\LiveNotificationWebhook
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/live-notifications', ['channel_id' => $channelId]),
            body: $payload,
        );

        return \Synchra\Model\LiveNotificationWebhook::fromArray($this->client->send($request)->object());
    }

    /**
     * Test Live Notification Message Route.
     *
     * `POST /api/2/channels/{channel_id}/live-notifications/test-message`
     *
     * @param \Synchra\Model\LiveNotificationMessageTest $payload The request body.
     */
    public function testLiveNotificationMessage(string $channelId, \Synchra\Model\LiveNotificationMessageTest $payload): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/live-notifications/test-message', ['channel_id' => $channelId]),
            body: $payload,
        );

        $this->client->send($request);
    }

    /**
     * Delete Live Notification Webhook Route.
     *
     * `DELETE /api/2/channels/{channel_id}/live-notifications/{live_notification_webhook_id}`
     */
    public function deleteLiveNotificationWebhook(string $channelId, string $liveNotificationWebhookId): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'DELETE',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/live-notifications/{live_notification_webhook_id}', ['channel_id' => $channelId, 'live_notification_webhook_id' => $liveNotificationWebhookId]),
        );

        $this->client->send($request);
    }

    /**
     * Get Live Notification Webhook Route.
     *
     * `GET /api/2/channels/{channel_id}/live-notifications/{live_notification_webhook_id}`
     */
    public function getLiveNotificationWebhook(string $channelId, string $liveNotificationWebhookId): \Synchra\Model\LiveNotificationWebhook
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/live-notifications/{live_notification_webhook_id}', ['channel_id' => $channelId, 'live_notification_webhook_id' => $liveNotificationWebhookId]),
        );

        return \Synchra\Model\LiveNotificationWebhook::fromArray($this->client->send($request)->object());
    }

    /**
     * Update Live Notification Webhook Route.
     *
     * `PUT /api/2/channels/{channel_id}/live-notifications/{live_notification_webhook_id}`
     *
     * @param \Synchra\Model\LiveNotificationWebhookUpdate $payload The request body.
     */
    public function updateLiveNotificationWebhook(string $channelId, string $liveNotificationWebhookId, \Synchra\Model\LiveNotificationWebhookUpdate $payload): \Synchra\Model\LiveNotificationWebhook
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'PUT',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/live-notifications/{live_notification_webhook_id}', ['channel_id' => $channelId, 'live_notification_webhook_id' => $liveNotificationWebhookId]),
            body: $payload,
        );

        return \Synchra\Model\LiveNotificationWebhook::fromArray($this->client->send($request)->object());
    }

    /**
     * Get Live Notification Webhook Services Route.
     *
     * `GET /api/2/live-notification-webhook-services`
     *
     * @return list<\Synchra\Model\LiveNotificationWebhookServiceInfo>
     */
    public function getLiveNotificationWebhookServices(): array
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: '/live-notification-webhook-services',
        );

        return \array_map(\Synchra\Model\LiveNotificationWebhookServiceInfo::fromArray(...), $this->client->send($request)->objects());
    }
}
