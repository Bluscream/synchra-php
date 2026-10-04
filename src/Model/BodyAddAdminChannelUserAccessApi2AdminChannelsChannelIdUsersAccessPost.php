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

use Synchra\Enum\AccessLevel;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `Body_Add_Admin_Channel_User_Access_api_2_admin_channels__channel_id__users_access_post` schema.
 * Named `Body_Add_Admin_Channel_User_Access_api_2_admin_channels__channel_id__users_access_post` in the API description.
 */
final readonly class BodyAddAdminChannelUserAccessApi2AdminChannelsChannelIdUsersAccessPost implements DataModel
{
    public function __construct(
        public string $user_id,
        public AccessLevel $access_level,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            user_id: $reader->requiredString('user_id'),
            access_level: $reader->requiredEnum('access_level', AccessLevel::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'user_id' => [$this->user_id, true],
            'access_level' => [$this->access_level, true],
        ]);
    }
}
