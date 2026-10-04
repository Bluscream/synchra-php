<?php

/*
 * This file is generated — do not edit it by hand.
 *
 * Source:    spec/openapi.json (and spec/websocket.md for the gateway)
 * Generator: tools/generate.php
 *
 * To pick up an API change: ./tools/fetch-spec.sh && composer generate
 */

declare(strict_types=1);

namespace Synchra\Query;

use Synchra\Enum\FilesQueryKind;
use Synchra\Enum\Sort;

/**
 * Optional filters for `GET /api/2/files`.
 *
 * Every field defaults to null, which means the filter is not sent.
 */
final readonly class FilesQuery implements \JsonSerializable
{
    /**
     * @param ?string $cursor
     * @param ?int $per_page
     * @param ?string $search
     * @param ?FilesQueryKind $kind
     * @param ?Sort $sort
     */
    public function __construct(
        public ?string $cursor = null,
        public ?int $per_page = null,
        public ?string $search = null,
        public ?FilesQueryKind $kind = null,
        public ?Sort $sort = null,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'cursor' => $this->cursor,
            'per_page' => $this->per_page,
            'search' => $this->search,
            'kind' => $this->kind,
            'sort' => $this->sort,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return \array_filter($this->toArray(), static fn(mixed $v): bool => $v !== null);
    }
}
