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
 * The `Chat` endpoints.
 *
 * Reach this group with `$synchra->chat()`.
 */
final class Chat extends AbstractResource
{
    /**
     * Get Chat Events.
     *
     * `GET /api/2/channels/{channel_id}/chat-events`
     *
     * Requires the `channel_chat_message:read` scope.
     *
     * @param ?\Synchra\Query\ChatEventsQuery $query Optional filters.
     * @return \Synchra\Pagination\Page<\Synchra\Model\ChatEvent>
     */
    public function getChatEvents(string $channelId, ?\Synchra\Query\ChatEventsQuery $query = null): \Synchra\Pagination\Page
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/chat-events', ['channel_id' => $channelId]),
            query: [...($query?->toArray() ?? [])],
        );

        return \Synchra\Pagination\Page::ofModel($this->client->send($request)->object(), \Synchra\Model\ChatEvent::class);
    }

    /**
     * Pin Chat Message.
     *
     * `POST /api/2/channels/{channel_id}/chat-events/pinned-message`
     *
     * Requires the `chat:moderate` scope.
     *
     * @param \Synchra\Model\ChatMessagePinCreateRequest $payload The request body.
     */
    public function pinChatMessage(string $channelId, \Synchra\Model\ChatMessagePinCreateRequest $payload): \Synchra\Model\ChatEvent
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/chat-events/pinned-message', ['channel_id' => $channelId]),
            body: $payload,
        );

        return \Synchra\Model\ChatEvent::fromArray($this->client->send($request)->object());
    }

    /**
     * Unpin Chat Message.
     *
     * `DELETE /api/2/channels/{channel_id}/chat-events/pinned-message/{provider_message_id}`
     *
     * Requires the `chat:moderate` scope.
     */
    public function unpinChatMessage(string $channelId, string $providerMessageId, string $channelProviderId): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'DELETE',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/chat-events/pinned-message/{provider_message_id}', ['channel_id' => $channelId, 'provider_message_id' => $providerMessageId]),
            query: ['channel_provider_id' => $channelProviderId],
        );

        $this->client->send($request);
    }

    /**
     * Update Pinned Chat Message.
     *
     * `PATCH /api/2/channels/{channel_id}/chat-events/pinned-message/{provider_message_id}`
     *
     * Requires the `chat:moderate` scope.
     *
     * @param \Synchra\Model\ChatMessagePinUpdateRequest $payload The request body.
     */
    public function updatePinnedChatMessage(string $channelId, string $providerMessageId, \Synchra\Model\ChatMessagePinUpdateRequest $payload): \Synchra\Model\ChatEvent
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'PATCH',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/chat-events/pinned-message/{provider_message_id}', ['channel_id' => $channelId, 'provider_message_id' => $providerMessageId]),
            body: $payload,
        );

        return \Synchra\Model\ChatEvent::fromArray($this->client->send($request)->object());
    }

    /**
     * Get Chat Messages.
     *
     * `GET /api/2/channels/{channel_id}/chat-messages`
     *
     * Requires the `channel_chat_message:read` scope.
     *
     * @param ?\Synchra\Query\ChatMessagesQuery $query Optional filters.
     * @return \Synchra\Pagination\Page<\Synchra\Model\ChatMessage>
     */
    public function getChatMessages(string $channelId, ?\Synchra\Query\ChatMessagesQuery $query = null): \Synchra\Pagination\Page
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/chat-messages', ['channel_id' => $channelId]),
            query: [...($query?->toArray() ?? [])],
        );

        return \Synchra\Pagination\Page::ofModel($this->client->send($request)->object(), \Synchra\Model\ChatMessage::class);
    }

    /**
     * Delete Chat Message.
     *
     * `DELETE /api/2/channels/{channel_id}/chat-messages/{provider_message_id}`
     *
     * Requires the `chat:moderate` scope.
     */
    public function deleteChatMessage(string $channelId, string $providerMessageId, \Synchra\Enum\Provider $provider, string $providerChannelId): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'DELETE',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/chat-messages/{provider_message_id}', ['channel_id' => $channelId, 'provider_message_id' => $providerMessageId]),
            query: ['provider' => $provider, 'provider_channel_id' => $providerChannelId],
        );

        $this->client->send($request);
    }

    /**
     * Get Badges For Chat Preview.
     *
     * `GET /api/2/channels/{channel_id}/chat-preview-badges`
     *
     * Requires the `channel_chat_message:read` scope.
     *
     * @return list<\Synchra\Model\ChatMessageBadgeRequest>
     */
    public function getBadgesForChatPreview(string $channelId, \Synchra\Enum\Provider $provider): array
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/chat-preview-badges', ['channel_id' => $channelId]),
            query: ['provider' => $provider],
        );

        return \array_map(\Synchra\Model\ChatMessageBadgeRequest::fromArray(...), $this->client->send($request)->objects());
    }

    /**
     * Moderate Automod Message.
     *
     * `POST /api/2/channels/{channel_id}/providers/{channel_provider_id}/automod-action`
     *
     * Requires the `chat:moderate` scope.
     *
     * @param \Synchra\Model\BodyModerateAutoModMessageApi2ChannelsChannelIdProvidersChannelProviderIdAutomodActionPost $payload The request body.
     */
    public function moderateAutomodMessage(string $channelId, string $channelProviderId, \Synchra\Model\BodyModerateAutoModMessageApi2ChannelsChannelIdProvidersChannelProviderIdAutomodActionPost $payload): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/providers/{channel_provider_id}/automod-action', ['channel_id' => $channelId, 'channel_provider_id' => $channelProviderId]),
            body: $payload,
        );

        $this->client->send($request);
    }

    /**
     * Get Random Chat Messages For Chat Preview.
     *
     * `GET /api/2/channels/{channel_id}/random-chat-messages`
     *
     * Requires the `channel_chat_message:read` scope.
     *
     * @param ?\Synchra\Query\RandomChatMessagesForChatPreviewQuery $query Optional filters.
     * @return list<\Synchra\Model\ChatMessage>
     */
    public function getRandomChatMessagesForChatPreview(string $channelId, ?\Synchra\Query\RandomChatMessagesForChatPreviewQuery $query = null): array
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/random-chat-messages', ['channel_id' => $channelId]),
            query: [...($query?->toArray() ?? [])],
        );

        return \array_map(\Synchra\Model\ChatMessage::fromArray(...), $this->client->send($request)->objects());
    }

    /**
     * Get Emotes.
     *
     * `GET /api/2/chat/emotes`
     *
     * Requires the `chat:read` scope.
     *
     * @return list<\Synchra\Model\Emote>
     */
    public function getEmotes(string $channelProviderId): array
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: '/chat/emotes',
            query: ['channel_provider_id' => $channelProviderId],
        );

        return \array_map(\Synchra\Model\Emote::fromArray(...), $this->client->send($request)->objects());
    }

    /**
     * Send Chat Message.
     *
     * `POST /api/2/chat/messages`
     *
     * Requires the `chat:write` scope.
     *
     * @param \Synchra\Model\UserSendMessageCreate $payload The request body.
     */
    public function sendChatMessage(\Synchra\Model\UserSendMessageCreate $payload): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: '/chat/messages',
            body: $payload,
        );

        $this->client->send($request);
    }
}
