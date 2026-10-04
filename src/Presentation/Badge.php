<?php

declare(strict_types=1);

namespace Synchra\Presentation;

/**
 * A viewer badge (subscriber, moderator, VIP, …) resolved to a drawable icon.
 *
 * {@see imageUrl} is null when the provider gave Synchra no icon for the badge; {@see name} and
 * {@see type} are always present, so a badge with no icon can still be shown as a text chip or a
 * title tooltip rather than vanishing.
 */
final readonly class Badge implements \JsonSerializable
{
    public function __construct(
        public string $name,
        public string $type,
        public ?string $imageUrl = null,
    ) {}

    /**
     * @return array<string, string>
     */
    public function jsonSerialize(): array
    {
        $out = ['name' => $this->name, 'type' => $this->type];

        if ($this->imageUrl !== null) {
            $out['imageUrl'] = $this->imageUrl;
        }

        return $out;
    }
}
