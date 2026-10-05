<?php

declare(strict_types=1);

namespace Synchra\Tests\Support;

use Synchra\Model\ChatMessage;

/**
 * Builds a {@see ChatMessage} from the fields a test actually cares about.
 *
 * `ChatMessage` has thirty-odd required fields, nearly all of them irrelevant to any given
 * assertion, so without this every test that needs one buries its point under a wall of nulls.
 */
final class Messages
{
    /** @param array<string, mixed> $overrides Merged over the defaults, in the API's own shape. */
    public static function chat(array $overrides = []): ChatMessage
    {
        return ChatMessage::fromArray([
            'id' => 'm1',
            'type' => 'message',
            'sub_type' => null,
            'created_at' => '2026-10-05T12:00:00Z',
            'updated_at' => null,
            'channel_id' => 'channel',
            'outgoing_group_id' => null,
            'channel_provider_chat_id' => null,
            'channel_provider_stream_id' => null,
            'provider_logo_variant' => null,
            'provider' => 'twitch',
            'provider_channel_id' => 'pc',
            'provider_message_id' => 'pm',
            'provider_viewer_id' => '1',
            'viewer_name' => 'someone',
            'viewer_display_name' => 'Someone',
            'viewer_profile_picture_url' => null,
            'viewer_created_at' => null,
            'viewer_color' => null,
            'message_parts' => [],
            'badges' => [],
            'access_level' => 0,
            'notice_message_parts' => [],
            'source_provider_channel_id' => null,
            'source_provider_channel_name' => null,
            'source_provider_channel_display_name' => null,
            'deleted_at' => null,
            'deleted_by_provider_viewer_id' => null,
            'deleted_by_name' => null,
            'deleted_by_display_name' => null,
            'parent_provider_thread_id' => null,
            'parent' => null,
            ...$overrides,
        ]);
    }
}
