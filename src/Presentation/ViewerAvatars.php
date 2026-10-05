<?php

declare(strict_types=1);

namespace Synchra\Presentation;

use Synchra\Enum\Provider;
use Synchra\Model\ChatMessage;

/**
 * Fills in the viewer avatars a chat message does not carry.
 *
 * Synchra puts `viewer_profile_picture_url` on a message for some providers and leaves it null for
 * others — a TikTok message arrives with a picture, a Twitch or YouTube one does not — so a chat
 * log rendered straight from the API shows avatars for some people and blanks for the rest. The
 * picture does exist; it just takes a second request per viewer to get, which is why this is a
 * separate opt-in step rather than something {@see MessageContent} does for you. Nothing here runs
 * unless the caller constructs it:
 *
 * ```php
 * $avatars = new ViewerAvatars([new SynchraAvatarSource($synchra, $channelId)]);
 *
 * foreach ($avatars->forMessages($messages) as $messageId => $url) {
 *     // …
 * }
 * ```
 *
 * Two things keep that from turning a forty-message chat log into forty requests per refresh. Every
 * answer, including "this viewer has no picture", goes into an {@see AvatarStore} keyed by viewer
 * rather than by message, so a chatter is looked up once however much they talk. And each
 * {@see forMessages()} call will only look up so many viewers it has never seen before; the rest
 * keep whatever they already had and are picked up by the following call, so the cost of a cold
 * start is spread over a few refreshes instead of landing on one.
 */
final class ViewerAvatars
{
    /**
     * @param list<AvatarSource> $sources         Asked in order, first answer wins. With none, this
     *                                            does nothing but pass through what messages carry.
     * @param AvatarStore        $store           Where answers are remembered. The default lives
     *                                            only as long as the process; a web application
     *                                            should pass its own cache.
     * @param int                $lookupsPerBatch How many unknown viewers one {@see forMessages()}
     *                                            call may look up.
     */
    public function __construct(
        private readonly array $sources,
        private readonly AvatarStore $store = new InMemoryAvatarStore(),
        private readonly int $lookupsPerBatch = 6,
    ) {}

    /**
     * The avatar url for each of the given messages that has one, keyed by message id.
     *
     * A message whose viewer has no avatar — or whose avatar has not been looked up yet, because
     * this call ran out of its lookup budget — is absent from the result rather than present with a
     * null, so a caller can merge it over what it already has.
     *
     * @param iterable<ChatMessage> $messages
     *
     * @return array<string, string>
     */
    public function forMessages(iterable $messages): array
    {
        $avatars = [];
        $budget = $this->lookupsPerBatch;

        foreach ($messages as $message) {
            $carried = $message->viewer_profile_picture_url;

            if ($carried !== null && $carried !== '') {
                $avatars[$message->id] = $carried;

                continue;
            }

            if ($message->provider_viewer_id === '') {
                continue;
            }

            $url = $this->resolve($message->provider, $message->provider_viewer_id, $message->viewer_name, $budget);

            if ($url !== null) {
                $avatars[$message->id] = $url;
            }
        }

        return $avatars;
    }

    /**
     * One viewer's avatar, from the store or from the sources.
     *
     * Unlike {@see forMessages()} this has no budget: it is the single-viewer call, for when
     * something other than a page of chat needs one picture.
     */
    public function forViewer(Provider $provider, string $viewerId, string $viewerName): ?string
    {
        $budget = 1;

        return $this->resolve($provider, $viewerId, $viewerName, $budget);
    }

    /**
     * The cache key for a viewer, which is `provider:id` — a viewer, not a message, because the
     * same person talking twenty times is one lookup.
     */
    public static function key(Provider $provider, string $viewerId): string
    {
        return $provider->value . ':' . $viewerId;
    }

    private function resolve(Provider $provider, string $viewerId, string $viewerName, int &$budget): ?string
    {
        $key = self::key($provider, $viewerId);
        $cached = $this->store->get($key);

        if ($cached !== null) {
            // The empty string is the store's "already asked, this viewer has none".
            return $cached === '' ? null : $cached;
        }

        if ($budget <= 0) {
            return null;
        }

        --$budget;

        $url = null;

        foreach ($this->sources as $source) {
            $url = $source->lookup($provider, $viewerId, $viewerName);

            if ($url !== null && $url !== '') {
                break;
            }

            $url = null;
        }

        // The miss is stored too, so a viewer with no picture is not retried on every refresh.
        $this->store->set($key, $url ?? '');

        return $url;
    }
}
