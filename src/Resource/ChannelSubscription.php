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
 * The `Channel Subscription` endpoints.
 *
 * Reach this group with `$synchra->channelSubscription()`.
 */
final class ChannelSubscription extends AbstractResource
{
    /**
     * Get Admin Channel Plan.
     *
     * `GET /api/2/admin/channels/{channel_id}/plan`
     */
    public function getAdminChannelPlan(string $channelId): \Synchra\Model\ChannelPlanSettings
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/admin/channels/{channel_id}/plan', ['channel_id' => $channelId]),
        );

        return \Synchra\Model\ChannelPlanSettings::fromArray($this->client->send($request)->object());
    }

    /**
     * Set Admin Channel Plan.
     *
     * `PUT /api/2/admin/channels/{channel_id}/plan`
     *
     * @param \Synchra\Model\ChannelPlanSettings $payload The request body.
     */
    public function setAdminChannelPlan(string $channelId, \Synchra\Model\ChannelPlanSettings $payload): \Synchra\Model\ChannelPlanSettings
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'PUT',
            path: \Synchra\Http\Path::expand('/admin/channels/{channel_id}/plan', ['channel_id' => $channelId]),
            body: $payload,
        );

        return \Synchra\Model\ChannelPlanSettings::fromArray($this->client->send($request)->object());
    }

    /**
     * Get Subscription Events.
     *
     * `GET /api/2/admin/subscription-events`
     *
     * @param ?\Synchra\Query\SubscriptionEventsQuery $query Optional filters.
     * @return \Synchra\Pagination\Page<\Synchra\Model\SubscriptionEvent>
     */
    public function getSubscriptionEvents(?\Synchra\Query\SubscriptionEventsQuery $query = null): \Synchra\Pagination\Page
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: '/admin/subscription-events',
            query: [...($query?->toArray() ?? [])],
        );

        return \Synchra\Pagination\Page::ofModel($this->client->send($request)->object(), \Synchra\Model\SubscriptionEvent::class);
    }

    /**
     * Get Admin Subscription Count.
     *
     * `GET /api/2/admin/subscriptions/count`
     */
    public function getAdminSubscriptionCount(): int
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: '/admin/subscriptions/count',
        );

        return $this->client->send($request)->integer();
    }

    /**
     * Create Channel Subscription Change Session.
     *
     * `POST /api/2/channels/{channel_id}/subscription/change-session`
     *
     * Requires the `channel:write` scope.
     *
     * @param \Synchra\Model\ChannelSubscriptionChangeSessionCreate $payload The request body.
     */
    public function createChannelSubscriptionChangeSession(string $channelId, \Synchra\Model\ChannelSubscriptionChangeSessionCreate $payload): \Synchra\Model\ChannelSubscriptionSession
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/subscription/change-session', ['channel_id' => $channelId]),
            body: $payload,
        );

        return \Synchra\Model\ChannelSubscriptionSession::fromArray($this->client->send($request)->object());
    }

    /**
     * Create Channel Subscription Checkout Session.
     *
     * `POST /api/2/channels/{channel_id}/subscription/checkout-session`
     *
     * Requires the `channel:write` scope.
     *
     * @param \Synchra\Model\ChannelSubscriptionCheckoutSessionCreate $payload The request body.
     */
    public function createChannelSubscriptionCheckoutSession(string $channelId, \Synchra\Model\ChannelSubscriptionCheckoutSessionCreate $payload): \Synchra\Model\ChannelSubscriptionSession
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/subscription/checkout-session', ['channel_id' => $channelId]),
            body: $payload,
        );

        return \Synchra\Model\ChannelSubscriptionSession::fromArray($this->client->send($request)->object());
    }

    /**
     * Get Channel Subscription Plans.
     *
     * `GET /api/2/channels/{channel_id}/subscription/plans`
     *
     * Requires the `channel:read` scope.
     */
    public function getChannelSubscriptionPlans(string $channelId): \Synchra\Model\ChannelSubscriptionPlans
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/subscription/plans', ['channel_id' => $channelId]),
        );

        return \Synchra\Model\ChannelSubscriptionPlans::fromArray($this->client->send($request)->object());
    }

    /**
     * Create Channel Subscription Portal Session.
     *
     * `POST /api/2/channels/{channel_id}/subscription/portal-session`
     *
     * Requires the `channel:write` scope.
     */
    public function createChannelSubscriptionPortalSession(string $channelId): \Synchra\Model\ChannelSubscriptionSession
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: \Synchra\Http\Path::expand('/channels/{channel_id}/subscription/portal-session', ['channel_id' => $channelId]),
        );

        return \Synchra\Model\ChannelSubscriptionSession::fromArray($this->client->send($request)->object());
    }

    /**
     * Stripe Subscription Event.
     *
     * `POST /api/2/stripe/events`
     */
    public function stripeSubscriptionEvent(string $stripeSignature): void
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'POST',
            path: '/stripe/events',
            headers: ['Stripe-Signature' => $stripeSignature],
        );

        $this->client->send($request);
    }

    /**
     * Get Subscription Plans.
     *
     * `GET /api/2/subscription/plans`
     */
    public function getSubscriptionPlans(): \Synchra\Model\SubscriptionPlans
    {
        $request = new \Synchra\Http\ApiRequest(
            method: 'GET',
            path: '/subscription/plans',
        );

        return \Synchra\Model\SubscriptionPlans::fromArray($this->client->send($request)->object());
    }
}
