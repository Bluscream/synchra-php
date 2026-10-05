<?php

declare(strict_types=1);

namespace Synchra\Presentation;

use Synchra\Enum\Provider;

/**
 * Somewhere a viewer's avatar can be looked up.
 *
 * {@see ViewerAvatars} asks each of its sources in turn, so the ones that need no network or are
 * most authoritative go first. Two are shipped: {@see SynchraAvatarSource}, which asks Synchra, and
 * {@see HttpAvatarSource}, which asks whatever service the caller names.
 */
interface AvatarSource
{
    /**
     * The viewer's avatar url, or null when this source has no answer.
     *
     * Null covers both "this viewer has no picture" and "this source could not answer" — including
     * a network failure or a rejected request, which a source handles itself rather than throwing.
     * A missing avatar is never worth failing a chat render over.
     *
     * @param string $viewerId   The provider's own id for the viewer.
     * @param string $viewerName The provider's login/handle, which is what most services key on.
     */
    public function lookup(Provider $provider, string $viewerId, string $viewerName): ?string;
}
