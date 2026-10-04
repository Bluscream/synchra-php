<?php

declare(strict_types=1);

namespace Synchra\Serialization;

/**
 * A value object mirroring one schema from the Synchra API description.
 *
 * Every model in {@see \Synchra\Model} implements this. Models are immutable: build a new one
 * rather than mutating an existing instance.
 */
interface DataModel extends \JsonSerializable
{
    /**
     * Hydrates the model from a decoded JSON object.
     *
     * @param array<string, mixed> $data
     *
     * @throws \Synchra\Exception\SerializationException When a required field is missing or has
     *                                                  a type the schema does not allow.
     */
    public static function fromArray(array $data): static;

    /**
     * The wire representation, using the API's own field names.
     *
     * Optional fields that were never set are omitted so that partial-update payloads do not
     * clear values the caller did not mention. Fields the schema declares nullable are always
     * present, because for those `null` is a value rather than an absence.
     *
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array;
}
