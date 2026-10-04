# synchra-php

[![Packagist](https://img.shields.io/packagist/v/bluscream/synchra.svg)](https://packagist.org/packages/bluscream/synchra)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)
[![PHP](https://img.shields.io/badge/php-%3E%3D8.2-777bb4.svg)](composer.json)

A PHP SDK for [Synchra](https://synchra.net) — the whole API, not a selection of it: **all 240
operations across 41 endpoint groups**, plus the realtime WebSocket gateway.

Everything below `src/Model`, `src/Enum`, `src/Query`, `src/Resource`, `src/Model/Union` and the
gateway's event types is generated from the API's own OpenAPI description, which is vendored in
`spec/`. When Synchra ships an endpoint, `composer generate` picks it up; nothing has to be
hand-written to keep up.

---

## Install

```bash
composer require bluscream/synchra
```

You also need a [PSR-18](https://www.php-fig.org/psr/psr-18/) HTTP client. Any one works — the SDK
finds it through [`php-http/discovery`](https://github.com/php-http/discovery) — and if your project
has none yet:

```bash
composer require guzzlehttp/guzzle nyholm/psr7
```

For the realtime gateway, add a WebSocket client:

```bash
composer require phrity/websocket
```

### What it builds on

The SDK deliberately owns as little infrastructure as possible:

| Concern | Library | Why not our own |
| :--- | :--- | :--- |
| HTTP requests | any PSR-18 client, found via `php-http/discovery` | Your app already has one, with its own proxy, timeout and retry configuration. |
| Requests and responses | `psr/http-message`, `psr/http-factory` | The standard interfaces, so middleware and mocks you already use keep working. |
| Logging | `psr/log` | Drop in Monolog or whatever you have; the default is a `NullLogger`. |
| WebSocket | `phrity/websocket` | A maintained client with ping/pong, close handshakes and timeouts handled. |
| Testing | PHPUnit, PHPStan, php-cs-fixer | — |

Only two things are hand-rolled, and both are because no library fits: the hydration layer
(`src/Serialization`) and the gateway's subscription bookkeeping (`src/WebSocket`). Both are
swappable — see [Bring your own transport](#bring-your-own-transport).

---

## Quick start

```php
use Synchra\Synchra;

$synchra = Synchra::withToken(getenv('SYNCHRA_TOKEN'));

$me = $synchra->user()->userInfo();
echo "Signed in as {$me->display_name}\n";

foreach ($synchra->channel()->getChannels() as $channel) {
    echo "- {$channel->display_name}\n";
}
```

Model properties keep the API's own names, in `snake_case`. That is on purpose: what you read in
a model is exactly what you see in the API reference, in a HAR capture or in a `var_dump`, and the
mapping both ways is the identity — there is no table of renames to get wrong.

---

## Authentication

Synchra issues tokens from the dashboard; the API itself has no token endpoint, so there is nothing
for the SDK to exchange credentials at. Get a token from
[dash.synchra.net](https://dash.synchra.net) and give it to the client:

```php
use Synchra\Auth\CallableToken;
use Synchra\Synchra;

// A fixed token.
$synchra = Synchra::withToken($token);

// Or from the SYNCHRA_TOKEN environment variable.
$synchra = Synchra::fromEnvironment();

// Or resolved per request — for a token refreshed in the background, or read from a rotating
// secret file or a secrets manager.
$synchra = new Synchra(CallableToken::of(fn (): ?string => $vault->current('synchra')));
```

### Anonymous access

Part of the API is public and answers without a token. For a bio page or an overlay that only
shows live state and chat, that is all you need:

```php
$synchra = Synchra::anonymous();

// Linked platforms, live state with viewer counts, and chat — no token involved.
$providers = $synchra->channelProvider()->getChannelProviders($channelId);
$streams   = $synchra->channelProvider()->getChannelProviderStreams($channelId);
$chat      = $synchra->chat()->getChatMessages($channelId);
```

Verified public on the live API: a channel's `providers`, `provider-streams` (status, title,
`viewer_count`, `peak_viewer_count`, `started_at`), `chat-messages`, `chat-events`,
`random-chat-messages`, and the global reference lists — `currencies.json`, `activity-types`,
`stream-categories`, `subscription/plans`, `link-tracking/config`. The channel record itself,
`streams`, `activities`, `links`, `widgets` and everything that writes need a token; an anonymous
call to one answers 401 as an `AuthenticationException`. A widget's own endpoints are public too,
but keyed by a `widget_id` that acts as the capability — pass it as the path parameter.

Tokens carry a fixed scope set, and the API rejects a call whose scope the token does not hold, so a
narrow token fails loudly rather than quietly doing less. Each generated method's docblock names the
scope it needs. The full set the API uses:

```
channel:read channel:write channel:delete
channel_activity:read channel_chat_message:read
channel_giveaway:read channel_giveaway:write
channel_link:read channel_link:write
channel_point_settings:read channel_point_settings:write
channel_providers:read channel_providers:write
channel_quote:read channel_quote:write
channel_stream:read channel_timer:read channel_timer:write
channel_user_access:read channel_user_access:write
channel_viewer:read channel_viewer_queue:read channel_viewer_queue:write
chat:read chat:write chat:moderate
chat_filter:read chat_filter:write
command:read command:write
file.read file.edit file.delete
ingest_api_key:read ingest_api_key:write
user:provider:read user:provider:write
user_profile:read user_profile:write
widget:read widget:write
```

Two other credentials exist and are supported where the endpoint needs them: channel **ingest API
keys** (passed as a normal parameter) and the widget **`x-kv-token`** header, which you can set
per request or client-wide:

```php
use Synchra\ClientOptions;

$synchra = Synchra::withToken($token, (new ClientOptions())->withHeaders([
    'X-Kv-Token' => $widgetToken,
]));
```

> Never commit a token. Read it from the environment or a secret store; this repository's
> `.gitignore` already excludes `.env`.

---

## Endpoint groups

Every group is a method on the client. All 240 operations are reachable; the counts are the
operations in each group.

| Accessor | API tag | Ops |
| :--- | :--- | --: |
| `adminHttpProxies()` | Admin HTTP Proxies | 7 |
| `amazonPolly()` | Amazon Polly | 1 |
| `channel()` | Channel | 5 |
| `channelActivity()` | Channel Activity | 5 |
| `channelChatFilters()` | Channel Chat Filters | 6 |
| `channelGambling()` | Channel Gambling | 4 |
| `channelGiveaway()` | Channel Giveaway | 8 |
| `channelIngest()` | Channel Ingest | 5 |
| `channelLinks()` | Channel Links | 9 |
| `channelPointSettings()` | Channel Point Settings | 2 |
| `channelProvider()` | Channel Provider | 10 |
| `channelQueue()` | Channel Queue | 10 |
| `channelQuotes()` | Channel Quotes | 6 |
| `channelStream()` | Channel Stream | 2 |
| `channelSubscription()` | Channel Subscription | 10 |
| `channelTimer()` | Channel Timer | 5 |
| `channelUserInvite()` | Channel User Invite | 10 |
| `channelViewer()` | Channel Viewer | 4 |
| `channelWidget()` | Channel Widget | 25 |
| `chat()` | Chat | 11 |
| `commandTemplates()` | Command Templates | 2 |
| `commands()` | Commands | 6 |
| `currencies()` | Currencies | 1 |
| `customScripts()` | Custom Scripts | 9 |
| `elevenLabs()` | ElevenLabs | 1 |
| `files()` | Files | 4 |
| `fourthwall()` | Fourthwall | 4 |
| `gateway()` | WebSocket | 2 |
| `kick()` | Kick | 2 |
| `koFi()` | Ko-fi | 4 |
| `liveNotifications()` | Live Notifications | 7 |
| `obsRemote()` | OBS Remote | 4 |
| `owncast()` | Owncast | 3 |
| `patreon()` | Patreon | 4 |
| `rumble()` | Rumble | 1 |
| `streamElements()` | StreamElements | 2 |
| `ttsMonster()` | TTSMonster | 1 |
| `twitch()` | Twitch | 11 |
| `user()` | User | 12 |
| `userProfile()` | User Profile | 9 |
| `youTube()` | YouTube | 6 |

Each method's docblock carries the operation's summary, its `METHOD /api/2/...` line and the scope
it requires, so your editor tells you what a call needs without a trip to the reference.

---

## Filters and pagination

Optional query parameters are grouped into one typed object per operation, so a call stays readable
however many filters it takes:

```php
use Synchra\Enum\Provider;
use Synchra\Query\ChatMessagesQuery;

$page = $synchra->chat()->getChatMessages($channelId, new ChatMessagesQuery(
    provider: Provider::Twitch,
    gte_created_at: new DateTimeImmutable('-1 hour'),
    per_page: 100,
));
```

Collections paginate with an opaque cursor. A `Page` is countable and iterable, and `Paginator`
walks the pages lazily — it fetches the next one only when you ask for an item past the end of the
current one, so breaking out of the loop early stops making requests:

```php
use Synchra\Pagination\Paginator;

foreach (Paginator::items(fn (?string $cursor) => $synchra->channelActivity()->getActivities(
    $channelId,
    new ActivitiesQuery(per_page: 100, cursor: $cursor),
)) as $activity) {
    echo $activity->type, "\n";
}
```

`Paginator` stops with an exception if the API ever returns the same cursor twice, rather than
looping against it forever.

---

## Realtime events

The gateway pushes chat, activity, stream, widget and queue events. Subscriptions are remembered, so
a dropped connection comes back with everything re-subscribed without your code noticing:

```php
use Synchra\WebSocket\Event;
use Synchra\WebSocket\EventType;

$events = $synchra->events();

$events->on(EventType::ChatMessage, function (Event $event): void {
    $message = $event->model();
    echo $message->viewer_display_name, ': ', $event->action->value, "\n";
});

$events->on(EventType::Activity, function (Event $event): void {
    echo "activity: ", $event->dataObject()['type'] ?? '?', "\n";
});

$events->subscribeChatMessage($channelId);
$events->subscribeActivity($channelId);

$events->run();          // blocks, reconnecting with backoff
```

There is one `subscribe*()` helper per event type, each taking exactly the keys that type needs.
To drive the socket from an existing event loop instead of blocking, use `connect()` and `poll()`:

```php
$events->connect();

while ($yourLoop->isRunning()) {
    $events->poll(0.25);        // returns the Event, or null if the window elapsed
    $yourLoop->tick();
}
```

`onAny()` sees every frame including `ok` acknowledgements and `error` frames; `onConnect()` and
`onDisconnect()` cover the lifecycle. A handler that throws is logged and the loop carries on, so
one bad handler cannot take the stream down.

---

## Rendering chat (emotes, gifts, mentions, badges)

Synchra resolves rich content server-side. A chat message or an activity arrives as an ordered list
of typed `message_parts`: an `emote` carries its CDN urls at three sizes (`sm`/`md`/`lg`), a `gift`
an image url, a `mention` the resolved display name, a `link` its url. A message also carries
`badges` (subscriber, moderator, VIP, …) with their own icon urls. Nothing needs a second lookup.

`MessageContent` collapses that into render-ready pieces so you draw the images rather than the
names — the difference between showing `KPOPvictory` and showing the emote:

```php
use Synchra\Presentation\MessageContent;
use Synchra\Presentation\Segment;

foreach (MessageContent::segments($message->message_parts) as $segment) {
    echo match ($segment->kind) {
        Segment::KIND_EMOTE, Segment::KIND_GIFT => "<img src=\"{$segment->imageUrl}\" alt=\"{$segment->text}\">",
        Segment::KIND_LINK                       => "<a href=\"{$segment->href}\">{$segment->text}</a>",
        default                                  => htmlspecialchars($segment->text),
    };
}

MessageContent::badges($message->badges);          // list<Badge> {name, type, imageUrl}
MessageContent::plainText($message->message_parts); // the text-only fallback
```

Each `Segment` always has a `text` fallback, so a renderer that ignores images still reads
correctly. It returns data, not HTML, so the same helper works for a page, a terminal or a desktop
app. `examples/04-render-chat.php` is a complete HTML renderer; it needs no token, because chat is
public.

---

## Errors

Every non-2xx response becomes a typed exception carrying the API's own error envelope:

```php
use Synchra\Exception\AuthorizationException;
use Synchra\Exception\RateLimitException;
use Synchra\Exception\ValidationException;

try {
    $synchra->chat()->sendChatMessage(new UserSendMessageCreate(
        user_provider_id: $userProviderId,
        channel_provider_id: $channelProviderId,
        message: 'Hello chat',
    ));
} catch (ValidationException $e) {
    foreach ($e->fieldErrors() as $error) {
        echo "{$error->field}: {$error->message}\n";
    }
} catch (AuthorizationException $e) {
    echo "The token is missing a scope: {$e->errorType()}\n";
} catch (RateLimitException $e) {
    // Already retried per the retry policy before reaching here.
}
```

| Status | Exception |
| :--- | :--- |
| 400 | `BadRequestException` |
| 401 | `AuthenticationException` |
| 403 | `AuthorizationException` |
| 404 | `NotFoundException` |
| 409 | `ConflictException` |
| 413 | `PayloadTooLargeException` |
| 422 | `ValidationException` |
| 429 | `RateLimitException` |
| 5xx | `ServerException` |

All of them implement `Synchra\Exception\SynchraException`, as do `ConfigurationException`,
`TransportException` and `SerializationException`, so one `catch` can cover the package.

### Retries

`GET`, `HEAD`, `OPTIONS`, `PUT` and `DELETE` are retried on 429 and 5xx with exponential backoff,
honouring `Retry-After` when the server sends it. `POST` and `PATCH` are **not** retried by default,
because resending one that already succeeded would do the thing twice:

```php
use Synchra\ClientOptions;
use Synchra\Http\RetryPolicy;

$synchra = Synchra::withToken($token, (new ClientOptions())->withRetry(new RetryPolicy(
    maxAttempts: 5,
    baseDelayMs: 1_000,
    retryUnsafeMethods: false,
)));
```

---

## Configuration

```php
use Synchra\ClientOptions;

$options = (new ClientOptions())
    ->withApiBaseUri('https://dash.synchra.net/api/2')   // same API, dashboard origin
    ->withWebSocketUri('wss://api.synchra.net/api/2/ws')
    ->withHeaders(['X-Kv-Token' => $widgetToken]);

$synchra = Synchra::withToken($token, $options);
```

Pass a logger to see every request's method, path, status and attempt number at debug level:

```php
$synchra = new Synchra(new StaticToken($token), $options, logger: $monolog);
```

Credentials are never logged — only the method, path and status.

### Bring your own transport

Both transports are interfaces. Implement `Synchra\Http\Transport` to route requests through
something that is not PSR-18, or to record and replay them in tests; implement
`Synchra\WebSocket\WebSocketTransport` to run the gateway inside an event loop such as ReactPHP or
Amp:

```php
$synchra = new Synchra(new StaticToken($token), transport: new MyTransport());
```

### Reaching an endpoint the SDK does not know yet

If Synchra ships something before the vendored description catches up, the HTTP client is public:

```php
use Synchra\Http\ApiRequest;

$response = $synchra->api()->send(new ApiRequest(
    method: 'POST',
    path: '/some/new/endpoint',
    body: ['hello' => 'world'],
));

$data = $response->object();
```

---

## Keeping up with the API

```bash
./tools/fetch-spec.sh      # refresh spec/openapi.json and spec/websocket.md
composer generate          # regenerate models, enums, queries, resources, unions, event types
composer check             # php-cs-fixer, PHPStan at level max, PHPUnit
```

`tools/fetch-spec.sh` honours `$SYNCHRA_API_HOST` if you are pointing at a different instance.
The generator wipes each generated directory before writing, so an endpoint Synchra removed
disappears instead of lingering as a stale class that still compiles.

A regeneration that lost something fails the test suite: `tests/Unit/CoverageTest.php` asserts that
every operation in the description is a method on some resource, that the method count matches, and
that every endpoint group is reachable from the client.

---

## Deliberate tradeoffs

Things that might look like oversights but are decisions:

- **`snake_case` properties.** The API's names, unchanged. A rename table is one more thing to get
  wrong, and it would make a HAR capture stop matching the code.
- **Strict enums.** An unknown enum value throws a `SerializationException` naming the field and
  telling you to regenerate, rather than silently handing you a value that is not in the type. Where
  the description models a field as a union of several platforms' enums, it maps to `string`, because
  that is genuinely what the field carries.
- **Open unions are `mixed`, documented in prose.** A handful of fields (`KvEntry::$value`,
  `DashboardProfileData::$layout`) are "any JSON value" in the description. Their `@param` says
  `mixed` and the docblock says in words what they carry, rather than claiming a union the hydrator
  cannot actually guarantee.
- **Optional nulls are omitted; nullable nulls are sent.** A field the schema marks nullable keeps
  its `null` on the wire; an optional non-nullable one is dropped when null. That is what makes a
  partial update leave untouched fields alone instead of clearing them.
- **Three gateway payloads are hand-written.** `KvEventData`, `ChannelGiveawaysEventData` and
  `QueueEvent` appear only in the WebSocket documentation, never in the OpenAPI document, so they
  live in `src/WebSocket/Payload/` with a note saying why. `ActivityAlertWidgetTest` is left
  unmodelled — it only exists as a JSON example.
- **`POST`/`PATCH` are not retried.** See above.

---

## Development

```bash
composer install
composer check                      # the full gate
composer test                       # unit tests only (no network)
vendor/bin/phpunit testsuite live   # live tests; needs SYNCHRA_TOKEN
```

The unit suite never touches the network. It runs against fixtures in `tests/Fixtures`, which are
real responses from `api.synchra.net` put through `tools/sanitise-fixtures.py`: shape, keys and enum
values are kept exactly, while ids, handles, display names, avatar URLs and anything a person typed
are replaced with placeholders.

The live suite is **read-only** — it never creates, updates or deletes anything, because the only
credentials anyone will run it with belong to a real channel with real viewers.

---

## License

MIT — see [LICENSE](LICENSE).

Not affiliated with or endorsed by Synchra.
