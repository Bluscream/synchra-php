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
 * Typed access to every endpoint group.
 *
 * @see AdminHttpProxies for the `Admin HTTP Proxies` endpoints.
 * @see AmazonPolly for the `Amazon Polly` endpoints.
 * @see Channel for the `Channel` endpoints.
 * @see ChannelActivity for the `Channel Activity` endpoints.
 * @see ChannelChatFilters for the `Channel Chat Filters` endpoints.
 * @see ChannelGambling for the `Channel Gambling` endpoints.
 * @see ChannelGiveaway for the `Channel Giveaway` endpoints.
 * @see ChannelIngest for the `Channel Ingest` endpoints.
 * @see ChannelLinks for the `Channel Links` endpoints.
 * @see ChannelPointSettings for the `Channel Point Settings` endpoints.
 * @see ChannelProvider for the `Channel Provider` endpoints.
 * @see ChannelQueue for the `Channel Queue` endpoints.
 * @see ChannelQuotes for the `Channel Quotes` endpoints.
 * @see ChannelStream for the `Channel Stream` endpoints.
 * @see ChannelSubscription for the `Channel Subscription` endpoints.
 * @see ChannelTimer for the `Channel Timer` endpoints.
 * @see ChannelUserInvite for the `Channel User Invite` endpoints.
 * @see ChannelViewer for the `Channel Viewer` endpoints.
 * @see ChannelWidget for the `Channel Widget` endpoints.
 * @see Chat for the `Chat` endpoints.
 * @see CommandTemplates for the `Command Templates` endpoints.
 * @see Commands for the `Commands` endpoints.
 * @see Currencies for the `Currencies` endpoints.
 * @see CustomScripts for the `Custom Scripts` endpoints.
 * @see ElevenLabs for the `ElevenLabs` endpoints.
 * @see Files for the `Files` endpoints.
 * @see Fourthwall for the `Fourthwall` endpoints.
 * @see Kick for the `Kick` endpoints.
 * @see KoFi for the `Ko-fi` endpoints.
 * @see LiveNotifications for the `Live Notifications` endpoints.
 * @see ObsRemote for the `OBS Remote` endpoints.
 * @see Owncast for the `Owncast` endpoints.
 * @see Patreon for the `Patreon` endpoints.
 * @see Rumble for the `Rumble` endpoints.
 * @see StreamElements for the `StreamElements` endpoints.
 * @see TtsMonster for the `TTSMonster` endpoints.
 * @see Twitch for the `Twitch` endpoints.
 * @see User for the `User` endpoints.
 * @see UserProfile for the `User Profile` endpoints.
 * @see Gateway for the `WebSocket` endpoints.
 * @see YouTube for the `YouTube` endpoints.
 */
trait ResourceAccessors
{
    /**
     * The `Admin HTTP Proxies` endpoints.
     */
    public function adminHttpProxies(): AdminHttpProxies
    {
        return $this->resource(AdminHttpProxies::class);
    }

    /**
     * The `Amazon Polly` endpoints.
     */
    public function amazonPolly(): AmazonPolly
    {
        return $this->resource(AmazonPolly::class);
    }

    /**
     * The `Channel` endpoints.
     */
    public function channel(): Channel
    {
        return $this->resource(Channel::class);
    }

    /**
     * The `Channel Activity` endpoints.
     */
    public function channelActivity(): ChannelActivity
    {
        return $this->resource(ChannelActivity::class);
    }

    /**
     * The `Channel Chat Filters` endpoints.
     */
    public function channelChatFilters(): ChannelChatFilters
    {
        return $this->resource(ChannelChatFilters::class);
    }

    /**
     * The `Channel Gambling` endpoints.
     */
    public function channelGambling(): ChannelGambling
    {
        return $this->resource(ChannelGambling::class);
    }

    /**
     * The `Channel Giveaway` endpoints.
     */
    public function channelGiveaway(): ChannelGiveaway
    {
        return $this->resource(ChannelGiveaway::class);
    }

    /**
     * The `Channel Ingest` endpoints.
     */
    public function channelIngest(): ChannelIngest
    {
        return $this->resource(ChannelIngest::class);
    }

    /**
     * The `Channel Links` endpoints.
     */
    public function channelLinks(): ChannelLinks
    {
        return $this->resource(ChannelLinks::class);
    }

    /**
     * The `Channel Point Settings` endpoints.
     */
    public function channelPointSettings(): ChannelPointSettings
    {
        return $this->resource(ChannelPointSettings::class);
    }

    /**
     * The `Channel Provider` endpoints.
     */
    public function channelProvider(): ChannelProvider
    {
        return $this->resource(ChannelProvider::class);
    }

    /**
     * The `Channel Queue` endpoints.
     */
    public function channelQueue(): ChannelQueue
    {
        return $this->resource(ChannelQueue::class);
    }

    /**
     * The `Channel Quotes` endpoints.
     */
    public function channelQuotes(): ChannelQuotes
    {
        return $this->resource(ChannelQuotes::class);
    }

    /**
     * The `Channel Stream` endpoints.
     */
    public function channelStream(): ChannelStream
    {
        return $this->resource(ChannelStream::class);
    }

    /**
     * The `Channel Subscription` endpoints.
     */
    public function channelSubscription(): ChannelSubscription
    {
        return $this->resource(ChannelSubscription::class);
    }

    /**
     * The `Channel Timer` endpoints.
     */
    public function channelTimer(): ChannelTimer
    {
        return $this->resource(ChannelTimer::class);
    }

    /**
     * The `Channel User Invite` endpoints.
     */
    public function channelUserInvite(): ChannelUserInvite
    {
        return $this->resource(ChannelUserInvite::class);
    }

    /**
     * The `Channel Viewer` endpoints.
     */
    public function channelViewer(): ChannelViewer
    {
        return $this->resource(ChannelViewer::class);
    }

    /**
     * The `Channel Widget` endpoints.
     */
    public function channelWidget(): ChannelWidget
    {
        return $this->resource(ChannelWidget::class);
    }

    /**
     * The `Chat` endpoints.
     */
    public function chat(): Chat
    {
        return $this->resource(Chat::class);
    }

    /**
     * The `Command Templates` endpoints.
     */
    public function commandTemplates(): CommandTemplates
    {
        return $this->resource(CommandTemplates::class);
    }

    /**
     * The `Commands` endpoints.
     */
    public function commands(): Commands
    {
        return $this->resource(Commands::class);
    }

    /**
     * The `Currencies` endpoints.
     */
    public function currencies(): Currencies
    {
        return $this->resource(Currencies::class);
    }

    /**
     * The `Custom Scripts` endpoints.
     */
    public function customScripts(): CustomScripts
    {
        return $this->resource(CustomScripts::class);
    }

    /**
     * The `ElevenLabs` endpoints.
     */
    public function elevenLabs(): ElevenLabs
    {
        return $this->resource(ElevenLabs::class);
    }

    /**
     * The `Files` endpoints.
     */
    public function files(): Files
    {
        return $this->resource(Files::class);
    }

    /**
     * The `Fourthwall` endpoints.
     */
    public function fourthwall(): Fourthwall
    {
        return $this->resource(Fourthwall::class);
    }

    /**
     * The `Kick` endpoints.
     */
    public function kick(): Kick
    {
        return $this->resource(Kick::class);
    }

    /**
     * The `Ko-fi` endpoints.
     */
    public function koFi(): KoFi
    {
        return $this->resource(KoFi::class);
    }

    /**
     * The `Live Notifications` endpoints.
     */
    public function liveNotifications(): LiveNotifications
    {
        return $this->resource(LiveNotifications::class);
    }

    /**
     * The `OBS Remote` endpoints.
     */
    public function obsRemote(): ObsRemote
    {
        return $this->resource(ObsRemote::class);
    }

    /**
     * The `Owncast` endpoints.
     */
    public function owncast(): Owncast
    {
        return $this->resource(Owncast::class);
    }

    /**
     * The `Patreon` endpoints.
     */
    public function patreon(): Patreon
    {
        return $this->resource(Patreon::class);
    }

    /**
     * The `Rumble` endpoints.
     */
    public function rumble(): Rumble
    {
        return $this->resource(Rumble::class);
    }

    /**
     * The `StreamElements` endpoints.
     */
    public function streamElements(): StreamElements
    {
        return $this->resource(StreamElements::class);
    }

    /**
     * The `TTSMonster` endpoints.
     */
    public function ttsMonster(): TtsMonster
    {
        return $this->resource(TtsMonster::class);
    }

    /**
     * The `Twitch` endpoints.
     */
    public function twitch(): Twitch
    {
        return $this->resource(Twitch::class);
    }

    /**
     * The `User` endpoints.
     */
    public function user(): User
    {
        return $this->resource(User::class);
    }

    /**
     * The `User Profile` endpoints.
     */
    public function userProfile(): UserProfile
    {
        return $this->resource(UserProfile::class);
    }

    /**
     * The `WebSocket` endpoints.
     */
    public function gateway(): Gateway
    {
        return $this->resource(Gateway::class);
    }

    /**
     * The `YouTube` endpoints.
     */
    public function youTube(): YouTube
    {
        return $this->resource(YouTube::class);
    }
}
