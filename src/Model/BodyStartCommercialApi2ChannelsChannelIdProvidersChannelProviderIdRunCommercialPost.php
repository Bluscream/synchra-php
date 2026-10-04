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

namespace Synchra\Model;

use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `Body_Start_Commercial_api_2_channels__channel_id__providers__channel_provider_id__run_commercial_post` schema.
 * Named `Body_Start_Commercial_api_2_channels__channel_id__providers__channel_provider_id__run_commercial_post` in the API description.
 */
final readonly class BodyStartCommercialApi2ChannelsChannelIdProvidersChannelProviderIdRunCommercialPost implements DataModel
{
    /**
     * @param ?int $length Length of the commercial in seconds.
     */
    public function __construct(
        public ?int $length = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            length: $reader->optionalInt('length'),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'length' => [$this->length, false],
        ]);
    }
}
