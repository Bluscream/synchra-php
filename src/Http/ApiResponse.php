<?php

declare(strict_types=1);

namespace Synchra\Http;

use Synchra\Exception\SerializationException;

/**
 * A successful response, with the decoded JSON body.
 */
final readonly class ApiResponse
{
    /**
     * @param array<string, list<string>> $headers
     * @param mixed $data Decoded body, or null for a 204.
     */
    public function __construct(
        public int $status,
        public array $headers,
        public mixed $data,
    ) {}

    /**
     * The body as a JSON object.
     *
     * @return array<string, mixed>
     */
    public function object(): array
    {
        if (!\is_array($this->data) || \array_is_list($this->data)) {
            throw new SerializationException(\sprintf(
                'Expected a JSON object in the %d response, got %s.',
                $this->status,
                \get_debug_type($this->data),
            ));
        }

        /** @var array<string, mixed> $data */
        $data = $this->data;

        return $data;
    }

    /**
     * The body as a JSON array.
     *
     * @return list<mixed>
     */
    public function list(): array
    {
        if (!\is_array($this->data) || !\array_is_list($this->data)) {
            throw new SerializationException(\sprintf(
                'Expected a JSON array in the %d response, got %s.',
                $this->status,
                \get_debug_type($this->data),
            ));
        }

        return $this->data;
    }

    /**
     * The body as a JSON object, or null when the endpoint answered with a bare `null`.
     *
     * @return array<string, mixed>|null
     */
    public function objectOrNull(): ?array
    {
        return $this->data === null ? null : $this->object();
    }

    /**
     * The body as a JSON array of objects.
     *
     * @return list<array<string, mixed>>
     */
    public function objects(): array
    {
        $out = [];

        foreach ($this->list() as $index => $item) {
            if (!\is_array($item) || \array_is_list($item)) {
                throw new SerializationException(\sprintf(
                    'Expected an object at index %d of the %d response, got %s.',
                    $index,
                    $this->status,
                    \get_debug_type($item),
                ));
            }

            /** @var array<string, mixed> $item */
            $out[] = $item;
        }

        return $out;
    }

    public function integer(): int
    {
        if (!\is_int($this->data)) {
            throw new SerializationException(\sprintf(
                'Expected an integer in the %d response, got %s.',
                $this->status,
                \get_debug_type($this->data),
            ));
        }

        return $this->data;
    }

    public function header(string $name): ?string
    {
        $values = $this->headers[\strtolower($name)] ?? [];

        return $values[0] ?? null;
    }
}
