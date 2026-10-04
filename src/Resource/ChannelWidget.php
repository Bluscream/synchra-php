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
 * The `Channel Widget` endpoints.
 *
 * Reach this group with `$synchra->channelWidget()`.
 */
final class ChannelWidget extends AbstractResource
{
    /**
     * Activity Alert Control Action.
     *
     * `POST /api/2/channels/{channel_id}/activity-alerts/action`
     *
     * Requires the `widget:write` scope.
     *
     * @param \Synchra\Model\ActivityAlertControlActionCreate $payload The request body.
     */
    public function activityAlertControlAction(string $channelId, \Synchra\Model\ActivityAlertControlActionCreate $payload): \Synchra\Model\ActivityAlertControlState
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/activity-alerts/action', ['channel_id' => $channelId]),
            body: $payload,
        );

        return \Synchra\Model\ActivityAlertControlState::fromArray($this->client->send($request)->object());
    }

    /**
     * Replay Activity Alert.
     *
     * `POST /api/2/channels/{channel_id}/activity-alerts/replay/{activity_id}`
     *
     * Requires the `widget:write` scope.
     */
    public function replayActivityAlert(string $channelId, string $activityId): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/activity-alerts/replay/{activity_id}', ['channel_id' => $channelId, 'activity_id' => $activityId]),
        );

        $this->client->send($request);
    }

    /**
     * Get Activity Alert Control State.
     *
     * `GET /api/2/channels/{channel_id}/activity-alerts/state`
     *
     * Requires the `widget:read` scope.
     */
    public function getActivityAlertControlState(string $channelId): \Synchra\Model\ActivityAlertControlState
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/activity-alerts/state', ['channel_id' => $channelId]),
        );

        return \Synchra\Model\ActivityAlertControlState::fromArray($this->client->send($request)->object());
    }

    /**
     * Get Widgets.
     *
     * `GET /api/2/channels/{channel_id}/widgets`
     *
     * Requires the `widget:read` scope.
     *
     * @param ?\Synchra\Query\WidgetsQuery $query Optional filters.
     * @return \Synchra\Pagination\Page<\Synchra\Model\WidgetBase>
     */
    public function getWidgets(string $channelId, ?\Synchra\Query\WidgetsQuery $query = null): \Synchra\Pagination\Page
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/widgets', ['channel_id' => $channelId]),
            query: [...($query?->toArray() ?? [])],
        );

        return \Synchra\Pagination\Page::ofModel($this->client->send($request)->object(), \Synchra\Model\WidgetBase::class);
    }

    /**
     * Create Widget.
     *
     * `POST /api/2/channels/{channel_id}/widgets`
     *
     * Requires the `widget:write` scope.
     *
     * @param \Synchra\Model\ChatWidgetCreate|\Synchra\Model\CustomWidgetCreate|\Synchra\Model\ActivityAlertWidgetCreate|\Synchra\Model\GoalWidgetCreate|\Synchra\Model\GiveawayWidgetCreate|\Synchra\Model\LeaderboardWidgetCreate|\Synchra\Model\StreamathonWidgetCreate|\Synchra\Model\VersusWidgetCreate|\Synchra\Model\ViewerCountWidgetCreate|\Synchra\Model\ValueWidgetCreate $payload The request body.
     */
    public function createWidget(string $channelId, \Synchra\Model\ChatWidgetCreate|\Synchra\Model\CustomWidgetCreate|\Synchra\Model\ActivityAlertWidgetCreate|\Synchra\Model\GoalWidgetCreate|\Synchra\Model\GiveawayWidgetCreate|\Synchra\Model\LeaderboardWidgetCreate|\Synchra\Model\StreamathonWidgetCreate|\Synchra\Model\VersusWidgetCreate|\Synchra\Model\ViewerCountWidgetCreate|\Synchra\Model\ValueWidgetCreate $payload): \Synchra\Model\ChatWidget|\Synchra\Model\CustomWidget|\Synchra\Model\ActivityAlertWidget|\Synchra\Model\GoalWidget|\Synchra\Model\GiveawayWidget|\Synchra\Model\LeaderboardWidget|\Synchra\Model\StreamathonWidget|\Synchra\Model\VersusWidget|\Synchra\Model\ViewerCountWidget|\Synchra\Model\ValueWidget
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/widgets', ['channel_id' => $channelId]),
            body: $payload,
        );

        return \Synchra\Model\Union\WidgetUnion::fromArray($this->client->send($request)->object());
    }

    /**
     * Delete Widget.
     *
     * `DELETE /api/2/channels/{channel_id}/widgets/{widget_id}`
     *
     * Requires the `widget:write` scope.
     */
    public function deleteWidget(string $channelId, string $widgetId): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'DELETE',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/widgets/{widget_id}', ['channel_id' => $channelId, 'widget_id' => $widgetId]),
        );

        $this->client->send($request);
    }

    /**
     * Patch Widget.
     *
     * `PATCH /api/2/channels/{channel_id}/widgets/{widget_id}`
     *
     * Requires the `widget:write` scope.
     *
     * @param \Synchra\Model\ChatWidgetUpdate|\Synchra\Model\CustomWidgetUpdate|\Synchra\Model\ActivityAlertWidgetUpdate|\Synchra\Model\GoalWidgetUpdate|\Synchra\Model\GiveawayWidgetUpdate|\Synchra\Model\LeaderboardWidgetUpdate|\Synchra\Model\StreamathonWidgetUpdate|\Synchra\Model\VersusWidgetUpdate|\Synchra\Model\ViewerCountWidgetUpdate|\Synchra\Model\ValueWidgetUpdate $payload The request body.
     */
    public function patchWidget(string $channelId, string $widgetId, \Synchra\Model\ChatWidgetUpdate|\Synchra\Model\CustomWidgetUpdate|\Synchra\Model\ActivityAlertWidgetUpdate|\Synchra\Model\GoalWidgetUpdate|\Synchra\Model\GiveawayWidgetUpdate|\Synchra\Model\LeaderboardWidgetUpdate|\Synchra\Model\StreamathonWidgetUpdate|\Synchra\Model\VersusWidgetUpdate|\Synchra\Model\ViewerCountWidgetUpdate|\Synchra\Model\ValueWidgetUpdate $payload): \Synchra\Model\ChatWidget|\Synchra\Model\CustomWidget|\Synchra\Model\ActivityAlertWidget|\Synchra\Model\GoalWidget|\Synchra\Model\GiveawayWidget|\Synchra\Model\LeaderboardWidget|\Synchra\Model\StreamathonWidget|\Synchra\Model\VersusWidget|\Synchra\Model\ViewerCountWidget|\Synchra\Model\ValueWidget
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'PATCH',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/widgets/{widget_id}', ['channel_id' => $channelId, 'widget_id' => $widgetId]),
            body: $payload,
        );

        return \Synchra\Model\Union\WidgetUnion::fromArray($this->client->send($request)->object());
    }

    /**
     * Put Widget.
     *
     * `PUT /api/2/channels/{channel_id}/widgets/{widget_id}`
     *
     * Requires the `widget:write` scope.
     *
     * @param \Synchra\Model\ChatWidgetUpdate|\Synchra\Model\CustomWidgetUpdate|\Synchra\Model\ActivityAlertWidgetUpdate|\Synchra\Model\GoalWidgetUpdate|\Synchra\Model\GiveawayWidgetUpdate|\Synchra\Model\LeaderboardWidgetUpdate|\Synchra\Model\StreamathonWidgetUpdate|\Synchra\Model\VersusWidgetUpdate|\Synchra\Model\ViewerCountWidgetUpdate|\Synchra\Model\ValueWidgetUpdate $payload The request body.
     */
    public function putWidget(string $channelId, string $widgetId, \Synchra\Model\ChatWidgetUpdate|\Synchra\Model\CustomWidgetUpdate|\Synchra\Model\ActivityAlertWidgetUpdate|\Synchra\Model\GoalWidgetUpdate|\Synchra\Model\GiveawayWidgetUpdate|\Synchra\Model\LeaderboardWidgetUpdate|\Synchra\Model\StreamathonWidgetUpdate|\Synchra\Model\VersusWidgetUpdate|\Synchra\Model\ViewerCountWidgetUpdate|\Synchra\Model\ValueWidgetUpdate $payload): \Synchra\Model\ChatWidget|\Synchra\Model\CustomWidget|\Synchra\Model\ActivityAlertWidget|\Synchra\Model\GoalWidget|\Synchra\Model\GiveawayWidget|\Synchra\Model\LeaderboardWidget|\Synchra\Model\StreamathonWidget|\Synchra\Model\VersusWidget|\Synchra\Model\ViewerCountWidget|\Synchra\Model\ValueWidget
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'PUT',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/widgets/{widget_id}', ['channel_id' => $channelId, 'widget_id' => $widgetId]),
            body: $payload,
        );

        return \Synchra\Model\Union\WidgetUnion::fromArray($this->client->send($request)->object());
    }

    /**
     * Test Activity Alert Widget.
     *
     * `POST /api/2/channels/{channel_id}/widgets/{widget_id}/test-alert`
     *
     * Requires the `widget:write` scope.
     *
     * @param ?\Synchra\Model\ActivityAlertWidgetTestAlertCreate $payload The request body.
     * @param ?\Synchra\Query\TestActivityAlertWidgetQuery $query Optional filters.
     */
    public function testActivityAlertWidget(string $channelId, string $widgetId, ?\Synchra\Model\ActivityAlertWidgetTestAlertCreate $payload = null, ?\Synchra\Query\TestActivityAlertWidgetQuery $query = null): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/widgets/{widget_id}/test-alert', ['channel_id' => $channelId, 'widget_id' => $widgetId]),
            query: [...($query?->toArray() ?? [])],
            body: $payload,
        );

        $this->client->send($request);
    }

    /**
     * Get Widget.
     *
     * `GET /api/2/widgets/{widget_id}`
     */
    public function getWidget(string $widgetId): \Synchra\Model\ChatWidget|\Synchra\Model\CustomWidget|\Synchra\Model\ActivityAlertWidget|\Synchra\Model\GoalWidget|\Synchra\Model\GiveawayWidget|\Synchra\Model\LeaderboardWidget|\Synchra\Model\StreamathonWidget|\Synchra\Model\VersusWidget|\Synchra\Model\ViewerCountWidget|\Synchra\Model\ValueWidget
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/widgets/{widget_id}', ['widget_id' => $widgetId]),
        );

        return \Synchra\Model\Union\WidgetUnion::fromArray($this->client->send($request)->object());
    }

    /**
     * Get Custom Widget Activities.
     *
     * `GET /api/2/widgets/{widget_id}/activities`
     *
     * @param ?\Synchra\Query\CustomWidgetActivitiesQuery $query Optional filters.
     * @return \Synchra\Pagination\Page<\Synchra\Model\Activity>
     */
    public function getCustomWidgetActivities(string $widgetId, ?\Synchra\Query\CustomWidgetActivitiesQuery $query = null): \Synchra\Pagination\Page
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/widgets/{widget_id}/activities', ['widget_id' => $widgetId]),
            query: [...($query?->toArray() ?? [])],
        );

        return \Synchra\Pagination\Page::ofModel($this->client->send($request)->object(), \Synchra\Model\Activity::class);
    }

    /**
     * Get Widget Activity Alert Control State.
     *
     * `GET /api/2/widgets/{widget_id}/activity-alert-control-state`
     */
    public function getWidgetActivityAlertControlState(string $widgetId): \Synchra\Model\ActivityAlertControlState
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/widgets/{widget_id}/activity-alert-control-state', ['widget_id' => $widgetId]),
        );

        return \Synchra\Model\ActivityAlertControlState::fromArray($this->client->send($request)->object());
    }

    /**
     * Activity Alert Provider Tts.
     *
     * `GET /api/2/widgets/{widget_id}/activity-alert-provider-tts`
     *
     * @param ?\Synchra\Query\ActivityAlertProviderTtsQuery $query Optional filters.
     */
    public function activityAlertProviderTts(string $widgetId, string $channelProviderId, string $text, string $voiceId, ?\Synchra\Query\ActivityAlertProviderTtsQuery $query = null): mixed
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/widgets/{widget_id}/activity-alert-provider-tts', ['widget_id' => $widgetId]),
            query: [...($query?->toArray() ?? []), 'channel_provider_id' => $channelProviderId, 'text' => $text, 'voice_id' => $voiceId],
        );

        return $this->client->send($request)->data;
    }

    /**
     * Save Widget Activity Checkpoint.
     *
     * `PUT /api/2/widgets/{widget_id}/activity-checkpoint`
     *
     * @param \Synchra\Model\ActivityCheckpointRemainingSecondsPayload|\Synchra\Model\ActivityCheckpointValuePayload|\Synchra\Model\ActivityCheckpointOptionValuesPayload $payload The request body.
     */
    public function saveWidgetActivityCheckpoint(string $widgetId, \Synchra\Model\ActivityCheckpointRemainingSecondsPayload|\Synchra\Model\ActivityCheckpointValuePayload|\Synchra\Model\ActivityCheckpointOptionValuesPayload $payload): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'PUT',
            path: \Synchra\Http\Path::expand('/widgets/{widget_id}/activity-checkpoint', ['widget_id' => $widgetId]),
            body: $payload,
        );

        $this->client->send($request);
    }

    /**
     * Get Widget Channel Activities.
     *
     * `GET /api/2/widgets/{widget_id}/channel-activities`
     *
     * @param list<string> $type
     * @param ?\Synchra\Query\WidgetChannelActivitiesQuery $query Optional filters.
     * @return \Synchra\Pagination\Page<\Synchra\Model\Activity>
     */
    public function getWidgetChannelActivities(string $widgetId, array $type, ?\Synchra\Query\WidgetChannelActivitiesQuery $query = null): \Synchra\Pagination\Page
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/widgets/{widget_id}/channel-activities', ['widget_id' => $widgetId]),
            query: [...($query?->toArray() ?? []), 'type' => $type],
        );

        return \Synchra\Pagination\Page::ofModel($this->client->send($request)->object(), \Synchra\Model\Activity::class);
    }

    /**
     * Get Custom Widget Chat Messages.
     *
     * `GET /api/2/widgets/{widget_id}/chat-messages`
     *
     * @param ?\Synchra\Query\CustomWidgetChatMessagesQuery $query Optional filters.
     * @return \Synchra\Pagination\Page<\Synchra\Model\ChatMessage>
     */
    public function getCustomWidgetChatMessages(string $widgetId, ?\Synchra\Query\CustomWidgetChatMessagesQuery $query = null): \Synchra\Pagination\Page
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/widgets/{widget_id}/chat-messages', ['widget_id' => $widgetId]),
            query: [...($query?->toArray() ?? [])],
        );

        return \Synchra\Pagination\Page::ofModel($this->client->send($request)->object(), \Synchra\Model\ChatMessage::class);
    }

    /**
     * Get Widget Current Channel Stream.
     *
     * `GET /api/2/widgets/{widget_id}/current-channel-stream`
     */
    public function getWidgetCurrentChannelStream(string $widgetId): ?\Synchra\Model\WidgetActivityPeriodStream
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/widgets/{widget_id}/current-channel-stream', ['widget_id' => $widgetId]),
        );

        return ($body = $this->client->send($request)->objectOrNull()) === null ? null : \Synchra\Model\WidgetActivityPeriodStream::fromArray($body);
    }

    /**
     * Get Widget Giveaway.
     *
     * `GET /api/2/widgets/{widget_id}/giveaway`
     *
     * @param ?\Synchra\Query\WidgetGiveawayQuery $query Optional filters.
     */
    public function getWidgetGiveaway(string $widgetId, ?\Synchra\Query\WidgetGiveawayQuery $query = null): \Synchra\Model\GiveawayWidgetSnapshot
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/widgets/{widget_id}/giveaway', ['widget_id' => $widgetId]),
            query: [...($query?->toArray() ?? [])],
        );

        return \Synchra\Model\GiveawayWidgetSnapshot::fromArray($this->client->send($request)->object());
    }

    /**
     * Delete Custom Widget Kv Value.
     *
     * `POST /api/2/widgets/{widget_id}/kv/delete`
     *
     * @param \Synchra\Model\KvDeleteRequest $payload The request body.
     * @return array<string, mixed>
     */
    public function deleteCustomWidgetKvValue(string $widgetId, \Synchra\Model\KvDeleteRequest $payload): array
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/widgets/{widget_id}/kv/delete', ['widget_id' => $widgetId]),
            body: $payload,
        );

        return $this->client->send($request)->object();
    }

    /**
     * Get Custom Widget Kv Value.
     *
     * `POST /api/2/widgets/{widget_id}/kv/get`
     *
     * @param \Synchra\Model\KvGetRequest $payload The request body.
     */
    public function getCustomWidgetKvValue(string $widgetId, \Synchra\Model\KvGetRequest $payload): \Synchra\Model\KvValueState
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/widgets/{widget_id}/kv/get', ['widget_id' => $widgetId]),
            body: $payload,
        );

        return \Synchra\Model\KvValueState::fromArray($this->client->send($request)->object());
    }

    /**
     * Increment Custom Widget Kv Value.
     *
     * `POST /api/2/widgets/{widget_id}/kv/inc`
     *
     * @param \Synchra\Model\KvIncRequest $payload The request body.
     * @return array<string, mixed>
     */
    public function incrementCustomWidgetKvValue(string $widgetId, \Synchra\Model\KvIncRequest $payload): array
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/widgets/{widget_id}/kv/inc', ['widget_id' => $widgetId]),
            body: $payload,
        );

        return $this->client->send($request)->object();
    }

    /**
     * Set Custom Widget Kv Value.
     *
     * `POST /api/2/widgets/{widget_id}/kv/set`
     *
     * @param \Synchra\Model\KvSetRequest $payload The request body.
     * @return array<string, mixed>
     */
    public function setCustomWidgetKvValue(string $widgetId, \Synchra\Model\KvSetRequest $payload): array
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/widgets/{widget_id}/kv/set', ['widget_id' => $widgetId]),
            body: $payload,
        );

        return $this->client->send($request)->object();
    }

    /**
     * Mark Widget Used.
     *
     * `POST /api/2/widgets/{widget_id}/last-used`
     */
    public function markWidgetUsed(string $widgetId): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/widgets/{widget_id}/last-used', ['widget_id' => $widgetId]),
        );

        $this->client->send($request);
    }

    /**
     * Streamathon Widget Action.
     *
     * `POST /api/2/widgets/{widget_id}/streamathon/action`
     *
     * Requires the `widget:write` scope.
     *
     * @param \Synchra\Model\StreamathonWidgetActionPayload $payload The request body.
     */
    public function streamathonWidgetAction(string $widgetId, \Synchra\Model\StreamathonWidgetActionPayload $payload): \Synchra\Model\StreamathonWidget
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/widgets/{widget_id}/streamathon/action', ['widget_id' => $widgetId]),
            body: $payload,
        );

        return \Synchra\Model\StreamathonWidget::fromArray($this->client->send($request)->object());
    }

    /**
     * Get Widget Value.
     *
     * `GET /api/2/widgets/{widget_id}/value`
     */
    public function getWidgetValue(string $widgetId): \Synchra\Model\KvValueState
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/widgets/{widget_id}/value', ['widget_id' => $widgetId]),
        );

        return \Synchra\Model\KvValueState::fromArray($this->client->send($request)->object());
    }
}
