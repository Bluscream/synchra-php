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

namespace Synchra\WebSocket;

use Synchra\Model\Activity;
use Synchra\Model\ChannelProviderPublic;
use Synchra\Model\ChannelProviderStream;
use Synchra\Model\ChatEvent;
use Synchra\Model\ChatMessage;
use Synchra\Model\GiveawayEntry;
use Synchra\Model\ObsRemoteCommand;
use Synchra\Model\Union\WidgetUnion;
use Synchra\Serialization\DataModel;
use Synchra\WebSocket\Payload\GiveawayPointer;
use Synchra\WebSocket\Payload\QueueEvent;
use Synchra\WebSocket\Payload\WidgetValue;

/**
 * Maps a gateway event onto the model its payload carries.
 *
 * Event types whose payload the API description does not define return null; read those
 * with Event::dataObject() instead.
 */
final class EventPayloads
{
    /**
     * @return DataModel|list<DataModel>|null
     */
    public static function hydrate(Event $event): DataModel|array|null
    {
        return match ($event->type) {
            'activity' => Activity::fromArray($event->dataObject()),
            'channel_giveaway_entries' => \array_map(GiveawayEntry::fromArray(...), $event->dataObjects()),
            'channel_giveaways' => GiveawayPointer::fromArray($event->dataObject()),
            'channel_provider' => ChannelProviderPublic::fromArray($event->dataObject()),
            'channel_provider_stream' => ChannelProviderStream::fromArray($event->dataObject()),
            'channel_queue' => QueueEvent::fromArray($event->dataObject()),
            'chat_event' => ChatEvent::fromArray($event->dataObject()),
            'chat_message' => ChatMessage::fromArray($event->dataObject()),
            'obs_remote_command' => ObsRemoteCommand::fromArray($event->dataObject()),
            'widget' => WidgetUnion::fromArray($event->dataObject()),
            'widget_value' => WidgetValue::fromArray($event->dataObject()),
            default => null,
        };
    }
}
