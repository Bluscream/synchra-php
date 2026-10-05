<?php

declare(strict_types=1);

namespace Synchra\Presentation;

use Synchra\Enum\Provider;
use Synchra\Exception\SynchraException;
use Synchra\Synchra;

/**
 * Looks a viewer's avatar up through Synchra itself.
 *
 * Synchra puts `viewer_profile_picture_url` on a chat message for some providers and not others —
 * TikTok messages carry one, Twitch and YouTube messages do not — but
 * `GET /channels/{id}/viewers/{provider}/{id}/info` has it for all of them. That is one call per
 * viewer, which is why {@see ViewerAvatars} caches and rations it rather than calling it per
 * message.
 *
 * This is the source to prefer: it is first-party, it needs no extra configuration, and the url it
 * returns is the one Synchra itself would show. It does need a token that can read the channel's
 * viewers; without that the endpoint answers 403 and this returns null, so a caller who sees no
 * Twitch avatars should check the token before reaching for {@see HttpAvatarSource}.
 */
final readonly class SynchraAvatarSource implements AvatarSource
{
    public function __construct(
        private Synchra $synchra,
        private string $channelId,
    ) {}

    public function lookup(Provider $provider, string $viewerId, string $viewerName): ?string
    {
        try {
            $viewer = $this->synchra->channelViewer()->providerViewerInfo($this->channelId, $provider, $viewerId);
        } catch (SynchraException) {
            // A token without access to this channel's viewers, a viewer the channel has never
            // seen, a transport hiccup: all the same answer here. ViewerAvatars remembers the miss,
            // so a token that cannot do this is asked once per viewer per cache lifetime rather
            // than on every refresh.
            return null;
        }

        $url = $viewer->profile_picture_url;

        return $url === '' ? null : $url;
    }
}
