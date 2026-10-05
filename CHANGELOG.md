# Changelog

All notable changes to this project are documented here.

The format follows [Keep a Changelog](https://keepachangelog.com/en/1.1.0/), and this project
adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [0.4.0] — 2026-10-05

### Added

- **`MessageContent::contentParts()` and `MessageContent::isNotice()`** — a chat message puts its
  content in `message_parts` except when it is a notice, which puts everything in
  `notice_message_parts` and leaves `message_parts` empty. A TikTok gift is the common case, and a
  renderer reading only `message_parts` draws every one of them as a blank row: on a live channel
  that was 35 of 200 messages silently disappearing. `contentParts()` returns whichever list carries
  the content.
- **`Synchra\Presentation\ProfileUrl`** — a viewer's public profile url on the platform they wrote
  from. The API identifies a viewer by handle and provider id and carries no public url, so a chat
  log that wants to link a name has to build one; this is that mapping in one place, including that
  YouTube goes by channel id while everyone else goes by handle. A provider that is not somewhere
  people have profiles (an emote host, a TTS voice) answers null rather than a guess.

### Changed

- A gift segment's `text` is now the gift's own name (`Popular Vote`) rather than the part's count
  text (`1 diamond`). That string is the image's alt text and the fallback for a renderer that draws
  no images, and the name is what the image actually shows.

## [0.3.0] — 2026-10-05

### Added

- **`Synchra\Presentation\ViewerAvatars`** — fills in the viewer avatars a chat message does not
  carry. Synchra sets `viewer_profile_picture_url` for some providers and not others: a TikTok
  message arrives with a picture, a Twitch or YouTube one arrives with null, so a chat log rendered
  straight from the API shows avatars for some people and blanks for the rest. The picture does
  exist — `GET /channels/{id}/viewers/{provider}/{id}/info` has it for every provider — but that is
  one request per viewer, so this is opt-in: nothing happens unless you construct it. Answers are
  cached per viewer rather than per message (including "this viewer has none", so a miss is not
  retried every refresh) and each batch only looks up so many new viewers, which keeps a cold start
  off a single page view.
  - `AvatarSource` — where a lookup goes. `SynchraAvatarSource` asks Synchra and is the one to
    prefer; `HttpAvatarSource` asks a service you name, for when the token cannot read the channel's
    viewers. Nothing is built in, so the library never contacts a third party you did not configure.
  - `AvatarStore` — where answers are kept, with `InMemoryAvatarStore` as the default. A web
    application should pass the cache it already has; expiry is the store's business, so it can hold
    a hit for a day and a miss for half an hour.

## [0.2.0] — 2026-10-05

### Added

- **`Synchra\Presentation\MessageContent`** — resolves a chat message's or activity's rich content
  into drawable pieces. Synchra pre-resolves emotes, gifts, mentions, links and viewer badges
  server-side (an emote arrives carrying its CDN urls at three sizes), and this collapses the typed
  parts into an ordered list of `Segment`s plus a list of `Badge`s so a caller can render the images
  instead of the bare names — the difference between showing `KPOPvictory` and showing the emote. It
  returns data, not HTML, so it is the same helper for a web page, a terminal or a desktop app.
  `examples/04-render-chat.php` renders chat to HTML with it.
- **`Synchra::anonymous()`** — a client that sends no credentials, for the public read endpoints: a
  channel's providers, provider-streams (live state, titles, viewer counts), chat messages and
  chat-events, plus the global reference lists (currencies, activity types, stream categories,
  subscription plans, link-tracking config). The README's _Anonymous access_ section lists what is
  and is not public, verified against the live API. `withToken(null)` already behaved this way; the
  factory names the intent.
- Live integration tests for the anonymous path, gated on `SYNCHRA_PUBLIC_CHANNEL_ID` rather than a
  token, including that a token-only endpoint still answers 401 anonymously.

## [0.1.0] — 2026-10-05

First release. Complete coverage of the Synchra API v2 as described by
`https://api.synchra.net/openapi.json`, vendored in `spec/openapi.json`.

### Added

- **Full REST coverage** — 240 operations across 41 endpoint groups, each reachable as a method on
  `Synchra\Synchra`. 395 models, 64 enums, 48 filter objects and 13 discriminated unions, all
  generated from the API description by `tools/generate.php`.
- **Realtime gateway** — `Synchra\WebSocket\EventStream`, covering all 13 event types with one
  `subscribe*()` helper each. Subscriptions survive a reconnect; the loop backs off exponentially,
  keeps the socket alive, and logs a throwing handler rather than dying with it. Usable blocking
  (`run()`) or from an existing event loop (`connect()` + `poll()`).
- **Pluggable credentials** — `StaticToken`, `CallableToken` or any `TokenProvider`. The API has no
  token endpoint, so tokens come from the dashboard; `CallableToken` covers rotation.
- **Cursor pagination** — `Page` (countable, iterable) and `Paginator`, which fetches lazily and
  refuses to loop on a repeated cursor.
- **Typed errors** — one exception per status (400, 401, 403, 404, 409, 413, 422, 429, 5xx), each
  carrying the API's error envelope and its per-field validation problems. A non-envelope error body
  still produces the right status rather than a parse failure.
- **Retries** — exponential backoff on 429 and 5xx for idempotent methods only, honouring
  `Retry-After`. `POST` and `PATCH` are opt-in.
- **Swappable transports** — `Synchra\Http\Transport` for HTTP (default: any PSR-18 client via
  `php-http/discovery`) and `Synchra\WebSocket\WebSocketTransport` for the gateway (default:
  `phrity/websocket`).
- **Committed generator** — `./tools/fetch-spec.sh && composer generate` regenerates the whole
  typed surface from a fresh description. Generated directories are wiped first, so a removed
  endpoint disappears instead of lingering.
- **Tests** — 365 unit tests with no network access, run against sanitised recordings of real API
  responses in `tests/Fixtures`, plus a read-only live suite gated on `SYNCHRA_TOKEN`. Structural
  tests assert that every operation in the description is reachable and that hand-written files stay
  inside the project's size limits.

### Notes

- PHPStan runs at `level: max` over `src`, `tests`, `tools` and `examples` with no baseline and no
  suppressions.
- Model properties use the API's own `snake_case` names. See **Deliberate tradeoffs** in the README
  for this and the other decisions that might look like oversights.

[Unreleased]: https://github.com/Bluscream/synchra-php/compare/v0.4.0...HEAD
[0.1.0]: https://github.com/Bluscream/synchra-php/releases/tag/v0.1.0
