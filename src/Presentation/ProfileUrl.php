<?php

declare(strict_types=1);

namespace Synchra\Presentation;

use Synchra\Enum\Provider;
use Synchra\Model\ChatMessage;

/**
 * Where a viewer's public profile lives on the platform they wrote from.
 *
 * Synchra identifies a viewer by the provider's own handle and id and does not carry a public url,
 * because the url is a property of the platform rather than of the API — so building one is left to
 * whoever is rendering. This is that mapping, in one place, so a chat log can turn a name into a
 * link without every caller rediscovering that YouTube goes by channel id while everyone else goes
 * by handle.
 *
 * ```php
 * $href = ProfileUrl::forMessage($message);   // null for a provider with no public profile page
 * ```
 *
 * A provider that is not a place people have profiles — an emote host like 7TV, a TTS service, an
 * alert integration — returns null rather than a guess.
 */
final class ProfileUrl
{
    /**
     * `sprintf` templates taking the viewer's handle.
     *
     * Deliberately not a complete list of the `Provider` enum: most of its cases are integrations
     * (emote hosts, TTS voices, alert services) that have no viewer profiles at all.
     */
    private const BY_NAME = [
        'twitch' => 'https://www.twitch.tv/%s',
        'tiktok' => 'https://www.tiktok.com/@%s',
        'kick' => 'https://kick.com/%s',
        'rumble' => 'https://rumble.com/user/%s',
        'x' => 'https://x.com/%s',
    ];

    /**
     * Providers addressed by the provider's own id instead of the handle. YouTube's canonical
     * profile url is the channel id; the handle form exists but is not what the API gives us.
     */
    private const BY_ID = [
        'youtube' => 'https://www.youtube.com/channel/%s',
    ];

    /**
     * The profile url of whoever wrote this message, or null when the platform has no public one.
     */
    public static function forMessage(ChatMessage $message): ?string
    {
        return self::for($message->provider, $message->viewer_name, $message->provider_viewer_id);
    }

    /**
     * @param string  $viewerName The provider's handle/login for the viewer.
     * @param ?string $viewerId   The provider's own id, which is what YouTube's url needs.
     */
    public static function for(Provider $provider, string $viewerName, ?string $viewerId = null): ?string
    {
        $byId = self::BY_ID[$provider->value] ?? null;

        if ($byId !== null) {
            return $viewerId === null || $viewerId === '' ? null : \sprintf($byId, \rawurlencode($viewerId));
        }

        $byName = self::BY_NAME[$provider->value] ?? null;

        if ($byName === null || $viewerName === '') {
            return null;
        }

        return \sprintf($byName, \rawurlencode($viewerName));
    }
}
