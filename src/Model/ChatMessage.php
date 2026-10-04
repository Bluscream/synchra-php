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

use Synchra\Enum\ChatMessageType;
use Synchra\Enum\Provider;
use Synchra\Enum\TAccessLevel;
use Synchra\Serialization\DataModel;
use Synchra\Serialization\Reader;
use Synchra\Serialization\Writer;

/**
 * The `ChatMessage` schema.
 */
final readonly class ChatMessage implements DataModel
{
    /**
     * @param list<ChatMessagePart> $message_parts
     * @param list<ChatMessageBadge> $badges
     * @param list<ChatMessagePart> $notice_message_parts
     */
    public function __construct(
        public string $id,
        public ChatMessageType $type,
        public ?string $sub_type,
        public \DateTimeImmutable $created_at,
        public ?\DateTimeImmutable $updated_at,
        public string $channel_id,
        public ?string $outgoing_group_id,
        public ?string $channel_provider_chat_id,
        public ?string $channel_provider_stream_id,
        public ?string $provider_logo_variant,
        public Provider $provider,
        public string $provider_channel_id,
        public string $provider_message_id,
        public string $provider_viewer_id,
        public string $viewer_name,
        public string $viewer_display_name,
        public ?string $viewer_profile_picture_url,
        public ?\DateTimeImmutable $viewer_created_at,
        public ?string $viewer_color,
        public array $message_parts,
        public array $badges,
        public TAccessLevel $access_level,
        public array $notice_message_parts,
        public ?string $source_provider_channel_id,
        public ?string $source_provider_channel_name,
        public ?string $source_provider_channel_display_name,
        public ?\DateTimeImmutable $deleted_at,
        public ?string $deleted_by_provider_viewer_id,
        public ?string $deleted_by_name,
        public ?string $deleted_by_display_name,
        public ?string $parent_provider_thread_id,
        public ?ChatMessageParent $parent,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            id: $reader->requiredString('id'),
            type: $reader->requiredEnum('type', ChatMessageType::class),
            sub_type: $reader->optionalString('sub_type'),
            created_at: $reader->requiredDateTime('created_at'),
            updated_at: $reader->optionalDateTime('updated_at'),
            channel_id: $reader->requiredString('channel_id'),
            outgoing_group_id: $reader->optionalString('outgoing_group_id'),
            channel_provider_chat_id: $reader->optionalString('channel_provider_chat_id'),
            channel_provider_stream_id: $reader->optionalString('channel_provider_stream_id'),
            provider_logo_variant: $reader->optionalString('provider_logo_variant'),
            provider: $reader->requiredEnum('provider', Provider::class),
            provider_channel_id: $reader->requiredString('provider_channel_id'),
            provider_message_id: $reader->requiredString('provider_message_id'),
            provider_viewer_id: $reader->requiredString('provider_viewer_id'),
            viewer_name: $reader->requiredString('viewer_name'),
            viewer_display_name: $reader->requiredString('viewer_display_name'),
            viewer_profile_picture_url: $reader->optionalString('viewer_profile_picture_url'),
            viewer_created_at: $reader->optionalDateTime('viewer_created_at'),
            viewer_color: $reader->optionalString('viewer_color'),
            message_parts: $reader->requiredModelList('message_parts', ChatMessagePart::class),
            badges: $reader->requiredModelList('badges', ChatMessageBadge::class),
            access_level: $reader->requiredEnum('access_level', TAccessLevel::class),
            notice_message_parts: $reader->requiredModelList('notice_message_parts', ChatMessagePart::class),
            source_provider_channel_id: $reader->optionalString('source_provider_channel_id'),
            source_provider_channel_name: $reader->optionalString('source_provider_channel_name'),
            source_provider_channel_display_name: $reader->optionalString('source_provider_channel_display_name'),
            deleted_at: $reader->optionalDateTime('deleted_at'),
            deleted_by_provider_viewer_id: $reader->optionalString('deleted_by_provider_viewer_id'),
            deleted_by_name: $reader->optionalString('deleted_by_name'),
            deleted_by_display_name: $reader->optionalString('deleted_by_display_name'),
            parent_provider_thread_id: $reader->optionalString('parent_provider_thread_id'),
            parent: $reader->optionalModel('parent', ChatMessageParent::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'id' => [$this->id, true],
            'type' => [$this->type, true],
            'sub_type' => [$this->sub_type, true],
            'created_at' => [$this->created_at, true],
            'updated_at' => [$this->updated_at, true],
            'channel_id' => [$this->channel_id, true],
            'outgoing_group_id' => [$this->outgoing_group_id, true],
            'channel_provider_chat_id' => [$this->channel_provider_chat_id, true],
            'channel_provider_stream_id' => [$this->channel_provider_stream_id, true],
            'provider_logo_variant' => [$this->provider_logo_variant, true],
            'provider' => [$this->provider, true],
            'provider_channel_id' => [$this->provider_channel_id, true],
            'provider_message_id' => [$this->provider_message_id, true],
            'provider_viewer_id' => [$this->provider_viewer_id, true],
            'viewer_name' => [$this->viewer_name, true],
            'viewer_display_name' => [$this->viewer_display_name, true],
            'viewer_profile_picture_url' => [$this->viewer_profile_picture_url, true],
            'viewer_created_at' => [$this->viewer_created_at, true],
            'viewer_color' => [$this->viewer_color, true],
            'message_parts' => [$this->message_parts, true],
            'badges' => [$this->badges, true],
            'access_level' => [$this->access_level, true],
            'notice_message_parts' => [$this->notice_message_parts, true],
            'source_provider_channel_id' => [$this->source_provider_channel_id, true],
            'source_provider_channel_name' => [$this->source_provider_channel_name, true],
            'source_provider_channel_display_name' => [$this->source_provider_channel_display_name, true],
            'deleted_at' => [$this->deleted_at, true],
            'deleted_by_provider_viewer_id' => [$this->deleted_by_provider_viewer_id, true],
            'deleted_by_name' => [$this->deleted_by_name, true],
            'deleted_by_display_name' => [$this->deleted_by_display_name, true],
            'parent_provider_thread_id' => [$this->parent_provider_thread_id, true],
            'parent' => [$this->parent, true],
        ]);
    }
}
