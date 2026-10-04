<?php

declare(strict_types=1);

namespace Synchra\WebSocket;

/**
 * One active subscription, kept so it can be restored after a reconnect.
 */
final readonly class Subscription implements \JsonSerializable
{
    /** @param array<string, string> $data The subscription key, for example `['channel_id' => '…']`. */
    public function __construct(
        public string $type,
        public array $data,
        public ?string $nonce = null,
    ) {}

    /**
     * Whether this is the same subscription as another — same event type, same key.
     *
     * Keys are sorted before comparing so that `['channel_id' => $id, 'profile_id' => $p]` and the
     * same pair written the other way round count as one subscription rather than two.
     */
    public function matches(self $other): bool
    {
        return $this->type === $other->type && self::sorted($this->data) === self::sorted($other->data);
    }

    /**
     * @param array<string, string> $data
     *
     * @return array<string, string>
     */
    private static function sorted(array $data): array
    {
        \ksort($data);

        return $data;
    }

    /** @return array<string, mixed> */
    public function jsonSerialize(): array
    {
        $payload = [
            'command' => 'subscribe',
            'type' => $this->type,
            'data' => $this->data,
        ];

        if ($this->nonce !== null) {
            $payload['nonce'] = $this->nonce;
        }

        return $payload;
    }
}
