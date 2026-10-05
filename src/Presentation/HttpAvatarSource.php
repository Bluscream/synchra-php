<?php

declare(strict_types=1);

namespace Synchra\Presentation;

use Synchra\Enum\Provider;
use Synchra\Exception\SynchraException;
use Synchra\Http\PsrTransport;
use Synchra\Http\Transport;

/**
 * Looks a viewer's avatar up at a service the caller names.
 *
 * For when {@see SynchraAvatarSource} cannot answer — most often because the token cannot read the
 * channel's viewers. Nothing is built in: a provider with no template configured is simply not
 * looked up, so this library never contacts a third party that the application did not ask it to.
 *
 * The response body is taken as the avatar url, or, when a pattern is given for that provider, the
 * pattern's first capture group is. Two shapes that covers:
 *
 * ```php
 * new HttpAvatarSource(
 *     templates: [
 *         // Answers with the url as plain text.
 *         'twitch'  => 'https://decapi.me/twitch/avatar/{name}',
 *         // Answers with a whole page, so a pattern picks the url out of it.
 *         'youtube' => 'https://www.youtube.com/channel/{id}',
 *     ],
 *     patterns: [
 *         'youtube' => '#"avatar":\{"thumbnails":\[\{"url":"([^"]+)"#',
 *     ],
 * );
 * ```
 *
 * The lookup happens where this code runs, not in a browser: what a caller renders afterwards is
 * the url the service resolved to — a `static-cdn.jtvnw.net` or `googleusercontent.com` address —
 * so a page built from this sends its visitors to the platform's own CDN and not to the service in
 * the middle. The service does see this application's requests, one per viewer per cache lifetime,
 * which is the trade being made by configuring one.
 */
final class HttpAvatarSource implements AvatarSource
{
    private ?Transport $resolvedTransport;

    /**
     * @param array<string, string> $templates Provider value (`twitch`, `youtube`, …) to a url
     *                                         template. `{name}` is the viewer's login and `{id}`
     *                                         the provider's id for them; both are url-encoded.
     * @param array<string, string> $patterns  Provider value to a regular expression whose first
     *                                         capture group is the avatar url. Without one for a
     *                                         provider, the whole response body is used.
     * @param array<string, string> $headers   Sent with every request, for a service that wants an
     *                                         API key.
     */
    public function __construct(
        private readonly array $templates,
        private readonly array $patterns = [],
        private readonly array $headers = [],
        ?Transport $transport = null,
    ) {
        $this->resolvedTransport = $transport;
    }

    public function lookup(Provider $provider, string $viewerId, string $viewerName): ?string
    {
        $template = $this->templates[$provider->value] ?? null;

        if ($template === null || $template === '') {
            return null;
        }

        $url = \str_replace(
            ['{name}', '{id}'],
            [\rawurlencode($viewerName), \rawurlencode($viewerId)],
            $template,
        );

        try {
            $response = $this->transport()->send('GET', $url, $this->headers, null);
        } catch (SynchraException) {
            // Including the configuration error from having no PSR-18 client installed: a missing
            // avatar is not worth failing a chat render over.
            return null;
        }

        if ($response->status < 200 || $response->status >= 300) {
            return null;
        }

        return self::extract($response->body, $this->patterns[$provider->value] ?? null);
    }

    private static function extract(string $body, ?string $pattern): ?string
    {
        $candidate = \trim($body);

        if ($pattern !== null) {
            // An invalid pattern is the caller's bug, but it is still not worth an exception from
            // inside a chat render; it reads here as "this source has no answer".
            if (@\preg_match($pattern, $body, $matches) !== 1 || !isset($matches[1])) {
                return null;
            }

            $candidate = \trim($matches[1]);
        }

        // A service that answers "user not found" with 200 and a sentence should not have that
        // sentence end up in an <img src>.
        return \preg_match('#^https://[^\s<>"\']+$#', $candidate) === 1 ? $candidate : null;
    }

    private function transport(): Transport
    {
        return $this->resolvedTransport ??= PsrTransport::discover();
    }
}
