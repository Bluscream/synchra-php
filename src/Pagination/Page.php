<?php

declare(strict_types=1);

namespace Synchra\Pagination;

use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * One page of a cursor-paginated collection.
 *
 * Synchra paginates with an opaque cursor rather than offsets: pass {@see self::$cursor} back as
 * the next request's `cursor` to continue, or let {@see Paginator} walk the pages for you.
 *
 * @template T of DataModel
 *
 * @implements \IteratorAggregate<int, T>
 */
final readonly class Page implements \Countable, \IteratorAggregate, \JsonSerializable
{
    /**
     * @param list<T> $records
     * @param array<string, array<string, mixed>> $lookupData Shared side data the records refer
     *                                                        to, keyed by lookup table then id.
     * @param string|null $cursor Cursor for the next page, or null on the last page.
     * @param int|null $total Total matching records, when the endpoint reports one.
     */
    public function __construct(
        public array $records,
        public array $lookupData = [],
        public ?string $cursor = null,
        public ?int $total = null,
    ) {}

    /**
     * @template TModel of DataModel
     *
     * @param array<string, mixed> $data
     * @param class-string<TModel> $class
     *
     * @return self<TModel>
     */
    public static function ofModel(array $data, string $class): self
    {
        $reader = new Reader($data, \sprintf('Page<%s>', $class));

        /** @var array<string, array<string, mixed>> $lookup */
        $lookup = $reader->optionalMap('lookup_data') ?? [];

        return new self(
            $reader->requiredModelList('records', $class),
            $lookup,
            $reader->optionalString('cursor'),
            $reader->optionalInt('total'),
        );
    }

    /**
     * Whether the API reported a further page.
     */
    public function hasMore(): bool
    {
        return $this->cursor !== null && $this->cursor !== '';
    }

    /** @return T|null */
    public function first(): ?DataModel
    {
        return $this->records[0] ?? null;
    }

    public function count(): int
    {
        return \count($this->records);
    }

    /** @return \Traversable<int, T> */
    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->records);
    }

    /** @return array<string, mixed> */
    public function jsonSerialize(): array
    {
        return [
            'records' => Writer::value($this->records),
            'lookup_data' => $this->lookupData,
            'cursor' => $this->cursor,
            'total' => $this->total,
        ];
    }
}
