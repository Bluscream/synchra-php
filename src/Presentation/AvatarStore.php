<?php

declare(strict_types=1);

namespace Synchra\Presentation;

/**
 * Where {@see ViewerAvatars} remembers what it has already looked up.
 *
 * Looking a viewer's avatar up costs one API call per viewer, so a chat log of forty messages would
 * otherwise cost forty calls every time it refreshed. The store is an interface rather than a
 * concrete cache because the right answer depends entirely on the caller: a one-off script wants
 * {@see InMemoryAvatarStore}, a web page wants whatever cache it already has, and a bot wants
 * something that survives a restart.
 *
 * Two conventions the implementation has to honour:
 *
 * - **An empty string means "this viewer has no avatar"**, which is a real answer and worth
 *   remembering — otherwise every refresh retries every viewer who has not set a picture.
 * - **Expiry is the store's business.** {@see get()} returning null means "ask again", whether that
 *   is because nothing was ever stored or because what was stored has aged out. A store that wants
 *   to keep a hit for a day and a miss for half an hour decides that itself.
 */
interface AvatarStore
{
    /**
     * The stored avatar url, an empty string for a viewer known not to have one, or null when the
     * caller should look it up.
     */
    public function get(string $key): ?string;

    /**
     * Stores an avatar url, or an empty string to record that this viewer has none.
     */
    public function set(string $key, string $value): void;
}
