<?php

declare(strict_types=1);

namespace Synchra\WebSocket;

use Synchra\Exception\SerializationException;
use Synchra\Serialization\DataModel;

/**
 * One event pushed by the gateway.
 *
 * `data` is kept as the decoded array so that an event type this package does not model yet is
 * still usable; call {@see self::model()} to get the typed value where one exists.
 */
final readonly class Event
{
    /** @param array<string, mixed> $raw The whole frame, including fields not listed here. */
    public function __construct(
        public string $type,
        public EventAction $action,
        public mixed $data,
        public ?string $nonce,
        public array $raw,
    ) {}

    /**
     * @param array<string, mixed> $frame
     */
    public static function fromArray(array $frame): self
    {
        $type = $frame['type'] ?? null;

        if (!\is_string($type)) {
            throw new SerializationException('A gateway frame arrived without a string "type".');
        }

        $action = \is_string($frame['action'] ?? null)
            ? EventAction::tryFrom($frame['action'])
            : null;

        $nonce = $frame['nonce'] ?? null;

        return new self(
            $type,
            // `ok` acknowledgements carry no action; treat an unknown one as a new event rather
            // than discarding the frame.
            $action ?? EventAction::New,
            $frame['data'] ?? null,
            \is_string($nonce) ? $nonce : null,
            $frame,
        );
    }

    public function is(EventType|string $type): bool
    {
        return $this->type === ($type instanceof EventType ? $type->value : $type);
    }

    public function isError(): bool
    {
        return $this->type === 'error';
    }

    public function isAcknowledgement(): bool
    {
        return $this->type === 'ok';
    }

    /**
     * The event type as an enum case, or null for a type this package does not know.
     */
    public function eventType(): ?EventType
    {
        return EventType::tryFrom($this->type);
    }

    /**
     * `data` as a JSON object.
     *
     * @return array<string, mixed>
     */
    public function dataObject(): array
    {
        if (!\is_array($this->data) || \array_is_list($this->data)) {
            throw new SerializationException(\sprintf(
                'The "%s" event carries %s rather than an object.',
                $this->type,
                \get_debug_type($this->data),
            ));
        }

        /** @var array<string, mixed> $data */
        $data = $this->data;

        return $data;
    }

    /**
     * `data` as a JSON array of objects.
     *
     * @return list<array<string, mixed>>
     */
    public function dataObjects(): array
    {
        if (!\is_array($this->data) || !\array_is_list($this->data)) {
            throw new SerializationException(\sprintf(
                'The "%s" event carries %s rather than an array.',
                $this->type,
                \get_debug_type($this->data),
            ));
        }

        $out = [];

        foreach ($this->data as $index => $item) {
            if (!\is_array($item) || \array_is_list($item)) {
                throw new SerializationException(\sprintf(
                    'The "%s" event has %s at index %d rather than an object.',
                    $this->type,
                    \get_debug_type($item),
                    $index,
                ));
            }

            /** @var array<string, mixed> $item */
            $out[] = $item;
        }

        return $out;
    }

    /**
     * The typed payload, or null when this event type has no model (or carries a list).
     *
     * @return DataModel|list<DataModel>|null
     */
    public function model(): DataModel|array|null
    {
        return EventPayloads::hydrate($this);
    }

    /**
     * The error envelope on an `error` event.
     */
    public function error(): ?\Synchra\Model\Error
    {
        if (!$this->isError() || !\is_array($this->data)) {
            return null;
        }

        /** @var array<string, mixed> $data */
        $data = $this->data;

        return \Synchra\Model\Error::fromArray($data);
    }
}
