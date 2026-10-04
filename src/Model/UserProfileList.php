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

use Synchra\Model\Union\UserProfileUnion;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `UserProfiles_Annotated_Union_DashboardUserProfile__ChatUserProfile__ActivityFeedUserProfile__ControlsUserProfile___FieldInfo_annotation_NoneType__required_True__discriminator__type____` schema.
 * Named `UserProfiles_Annotated_Union_DashboardUserProfile__ChatUserProfile__ActivityFeedUserProfile__ControlsUserProfile___FieldInfo_annotation_NoneType__required_True__discriminator__type____` in the API description.
 */
final readonly class UserProfileList implements DataModel
{
    /**
     * @param list<ActivityFeedUserProfile|ChatUserProfile|ControlsUserProfile|DashboardUserProfile> $records
     */
    public function __construct(
        public array $records,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            records: $reader->requiredListVia('records', UserProfileUnion::fromArray(...)),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'records' => [$this->records, true],
        ]);
    }
}
