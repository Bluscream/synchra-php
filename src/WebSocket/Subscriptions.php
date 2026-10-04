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

namespace Synchra\WebSocket;

/**
 * Typed subscribe and unsubscribe calls, one pair per event type.
 *
 * These only spell out the subscription key each event needs; EventStream::subscribe()
 * takes the same thing untyped if the gateway gains an event before this is regenerated.
 */
trait Subscriptions
{
    /**
     * @param array<string, string> $data
     */
    abstract public function subscribe(EventType|string $type, array $data, ?string $nonce = null): self;

    /**
     * @param array<string, string> $data
     */
    abstract public function unsubscribe(EventType|string $type, array $data): self;

    /**
     * Subscribes to Activity events.
     */
    public function subscribeActivity(string $channelId, ?string $nonce = null): self
    {
        return $this->subscribe(EventType::Activity, ['channel_id' => $channelId], $nonce);
    }

    /**
     * Stops receiving Activity events.
     */
    public function unsubscribeActivity(string $channelId): self
    {
        return $this->unsubscribe(EventType::Activity, ['channel_id' => $channelId]);
    }

    /**
     * Subscribes to Activity alert test events.
     */
    public function subscribeActivityAlertTest(string $widgetId, ?string $nonce = null): self
    {
        return $this->subscribe(EventType::ActivityAlertTest, ['widget_id' => $widgetId], $nonce);
    }

    /**
     * Stops receiving Activity alert test events.
     */
    public function unsubscribeActivityAlertTest(string $widgetId): self
    {
        return $this->unsubscribe(EventType::ActivityAlertTest, ['widget_id' => $widgetId]);
    }

    /**
     * Subscribes to Channel giveaway events.
     */
    public function subscribeChannelGiveaway(string $giveawayId, ?string $nonce = null): self
    {
        return $this->subscribe(EventType::ChannelGiveaway, ['giveaway_id' => $giveawayId], $nonce);
    }

    /**
     * Stops receiving Channel giveaway events.
     */
    public function unsubscribeChannelGiveaway(string $giveawayId): self
    {
        return $this->unsubscribe(EventType::ChannelGiveaway, ['giveaway_id' => $giveawayId]);
    }

    /**
     * Subscribes to Channel giveaway entries events.
     */
    public function subscribeChannelGiveawayEntries(string $giveawayId, ?string $nonce = null): self
    {
        return $this->subscribe(EventType::ChannelGiveawayEntries, ['giveaway_id' => $giveawayId], $nonce);
    }

    /**
     * Stops receiving Channel giveaway entries events.
     */
    public function unsubscribeChannelGiveawayEntries(string $giveawayId): self
    {
        return $this->unsubscribe(EventType::ChannelGiveawayEntries, ['giveaway_id' => $giveawayId]);
    }

    /**
     * Subscribes to Channel giveaways events.
     */
    public function subscribeChannelGiveaways(string $channelId, ?string $nonce = null): self
    {
        return $this->subscribe(EventType::ChannelGiveaways, ['channel_id' => $channelId], $nonce);
    }

    /**
     * Stops receiving Channel giveaways events.
     */
    public function unsubscribeChannelGiveaways(string $channelId): self
    {
        return $this->unsubscribe(EventType::ChannelGiveaways, ['channel_id' => $channelId]);
    }

    /**
     * Subscribes to Channel provider events.
     */
    public function subscribeChannelProvider(string $channelId, ?string $nonce = null): self
    {
        return $this->subscribe(EventType::ChannelProvider, ['channel_id' => $channelId], $nonce);
    }

    /**
     * Stops receiving Channel provider events.
     */
    public function unsubscribeChannelProvider(string $channelId): self
    {
        return $this->unsubscribe(EventType::ChannelProvider, ['channel_id' => $channelId]);
    }

    /**
     * Subscribes to Channel provider stream events.
     */
    public function subscribeChannelProviderStream(string $channelId, ?string $nonce = null): self
    {
        return $this->subscribe(EventType::ChannelProviderStream, ['channel_id' => $channelId], $nonce);
    }

    /**
     * Stops receiving Channel provider stream events.
     */
    public function unsubscribeChannelProviderStream(string $channelId): self
    {
        return $this->unsubscribe(EventType::ChannelProviderStream, ['channel_id' => $channelId]);
    }

    /**
     * Subscribes to Channel queue events.
     */
    public function subscribeChannelQueue(string $channelQueueId, ?string $nonce = null): self
    {
        return $this->subscribe(EventType::ChannelQueue, ['channel_queue_id' => $channelQueueId], $nonce);
    }

    /**
     * Stops receiving Channel queue events.
     */
    public function unsubscribeChannelQueue(string $channelQueueId): self
    {
        return $this->unsubscribe(EventType::ChannelQueue, ['channel_queue_id' => $channelQueueId]);
    }

    /**
     * Subscribes to Chat event events.
     */
    public function subscribeChatEvent(string $channelId, ?string $nonce = null): self
    {
        return $this->subscribe(EventType::ChatEvent, ['channel_id' => $channelId], $nonce);
    }

    /**
     * Stops receiving Chat event events.
     */
    public function unsubscribeChatEvent(string $channelId): self
    {
        return $this->unsubscribe(EventType::ChatEvent, ['channel_id' => $channelId]);
    }

    /**
     * Subscribes to Chat message events.
     */
    public function subscribeChatMessage(string $channelId, ?string $nonce = null): self
    {
        return $this->subscribe(EventType::ChatMessage, ['channel_id' => $channelId], $nonce);
    }

    /**
     * Stops receiving Chat message events.
     */
    public function unsubscribeChatMessage(string $channelId): self
    {
        return $this->unsubscribe(EventType::ChatMessage, ['channel_id' => $channelId]);
    }

    /**
     * Subscribes to Obs remote command events.
     */
    public function subscribeObsRemoteCommand(string $obsRemoteId, ?string $nonce = null): self
    {
        return $this->subscribe(EventType::ObsRemoteCommand, ['obs_remote_id' => $obsRemoteId], $nonce);
    }

    /**
     * Stops receiving Obs remote command events.
     */
    public function unsubscribeObsRemoteCommand(string $obsRemoteId): self
    {
        return $this->unsubscribe(EventType::ObsRemoteCommand, ['obs_remote_id' => $obsRemoteId]);
    }

    /**
     * Subscribes to Widget events.
     */
    public function subscribeWidget(string $widgetId, ?string $nonce = null): self
    {
        return $this->subscribe(EventType::Widget, ['widget_id' => $widgetId], $nonce);
    }

    /**
     * Stops receiving Widget events.
     */
    public function unsubscribeWidget(string $widgetId): self
    {
        return $this->unsubscribe(EventType::Widget, ['widget_id' => $widgetId]);
    }

    /**
     * Subscribes to Widget value events.
     */
    public function subscribeWidgetValue(string $widgetId, string $channelId, string $key, ?string $nonce = null): self
    {
        return $this->subscribe(EventType::WidgetValue, ['widget_id' => $widgetId, 'channel_id' => $channelId, 'key' => $key], $nonce);
    }

    /**
     * Stops receiving Widget value events.
     */
    public function unsubscribeWidgetValue(string $widgetId, string $channelId, string $key): self
    {
        return $this->unsubscribe(EventType::WidgetValue, ['widget_id' => $widgetId, 'channel_id' => $channelId, 'key' => $key]);
    }
}
