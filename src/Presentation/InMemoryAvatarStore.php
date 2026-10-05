<?php

declare(strict_types=1);

namespace Synchra\Presentation;

/**
 * An {@see AvatarStore} that lives for as long as the process does.
 *
 * The default, and the right one for a script or a long-running bot: a lookup is made once and then
 * reused, and nothing has to be configured to get that. A web page serving one request per visitor
 * gets nothing out of this — there, plug the cache the application already has into
 * {@see ViewerAvatars} instead, or the lookups happen again on every request.
 *
 * Nothing expires, because nothing outlives the process. The entry count is capped so that a bot
 * watching a busy chat for a week does not grow a map with an entry per viewer it has ever seen;
 * past the cap the oldest entries go first.
 */
final class InMemoryAvatarStore implements AvatarStore
{
    /** @var array<string, string> */
    private array $entries = [];

    public function __construct(private readonly int $maxEntries = 5_000) {}

    public function get(string $key): ?string
    {
        return $this->entries[$key] ?? null;
    }

    public function set(string $key, string $value): void
    {
        // Re-inserting moves the key to the end, so a viewer who keeps talking keeps their place.
        unset($this->entries[$key]);
        $this->entries[$key] = $value;

        while (\count($this->entries) > $this->maxEntries) {
            $oldest = \array_key_first($this->entries);

            if ($oldest === null) {
                return;
            }

            unset($this->entries[$oldest]);
        }
    }
}
