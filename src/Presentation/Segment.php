<?php

declare(strict_types=1);

namespace Synchra\Presentation;

/**
 * One drawable piece of a chat message or activity, after {@see MessageContent} has resolved it.
 *
 * A message is an ordered list of these. A renderer walks the list once and switches on {@see kind}:
 * draw {@see text} as text, draw an `<img>` from {@see imageUrl} (with {@see text} as its alt), or
 * draw an `<a>` to {@see href}. {@see text} is always set and always safe to show on its own, so a
 * renderer that does not care about images can ignore every other field and still read correctly —
 * which is exactly what the old text-only rendering did.
 */
final readonly class Segment implements \JsonSerializable
{
    public const KIND_TEXT = 'text';
    public const KIND_EMOTE = 'emote';
    public const KIND_GIFT = 'gift';
    public const KIND_MENTION = 'mention';
    public const KIND_LINK = 'link';

    public function __construct(
        public string $kind,
        public string $text,
        public ?string $imageUrl = null,
        public bool $animated = false,
        public ?string $href = null,
    ) {}

    /**
     * @return array<string, scalar>
     */
    public function jsonSerialize(): array
    {
        // Only the keys this segment actually uses, so the JSON a page receives stays small and a
        // consumer can tell an emote (has imageUrl) from a link (has href) without a kind switch.
        $out = ['kind' => $this->kind, 'text' => $this->text];

        if ($this->imageUrl !== null) {
            $out['imageUrl'] = $this->imageUrl;
            $out['animated'] = $this->animated;
        }

        if ($this->href !== null) {
            $out['href'] = $this->href;
        }

        return $out;
    }
}
