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
 * The `ChatProfileFiltersPayload` schema.
 */
final readonly class ChatProfileFiltersPayload implements DataModel
{
    public function __construct(
        public ?ChatProfileFlagFilterPayload $mentions_me = null,
        public ?ChatProfileKeywordFilterPayload $viewer_names = null,
        public ?ChatProfileAccessLevelFilterPayload $access_levels = null,
        public ?ChatProfileProviderFilterPayload $providers = null,
        public ?ChatProfileMessageTypeFilterPayload $message_types = null,
        public ?ChatProfileKeywordFilterPayload $keywords = null,
        public ?ChatProfileChatterTypeFilterPayload $chatter_types = null,
        public ?ChatProfileFlagFilterPayload $has_links = null,
        public ?ChatProfileFlagFilterPayload $has_replies = null,
        public ?ChatProfileFlagFilterPayload $deleted_messages = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            mentions_me: $reader->optionalModel('mentions_me', ChatProfileFlagFilterPayload::class),
            viewer_names: $reader->optionalModel('viewer_names', ChatProfileKeywordFilterPayload::class),
            access_levels: $reader->optionalModel('access_levels', ChatProfileAccessLevelFilterPayload::class),
            providers: $reader->optionalModel('providers', ChatProfileProviderFilterPayload::class),
            message_types: $reader->optionalModel('message_types', ChatProfileMessageTypeFilterPayload::class),
            keywords: $reader->optionalModel('keywords', ChatProfileKeywordFilterPayload::class),
            chatter_types: $reader->optionalModel('chatter_types', ChatProfileChatterTypeFilterPayload::class),
            has_links: $reader->optionalModel('has_links', ChatProfileFlagFilterPayload::class),
            has_replies: $reader->optionalModel('has_replies', ChatProfileFlagFilterPayload::class),
            deleted_messages: $reader->optionalModel('deleted_messages', ChatProfileFlagFilterPayload::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'mentions_me' => [$this->mentions_me, false],
            'viewer_names' => [$this->viewer_names, false],
            'access_levels' => [$this->access_levels, false],
            'providers' => [$this->providers, false],
            'message_types' => [$this->message_types, false],
            'keywords' => [$this->keywords, false],
            'chatter_types' => [$this->chatter_types, false],
            'has_links' => [$this->has_links, false],
            'has_replies' => [$this->has_replies, false],
            'deleted_messages' => [$this->deleted_messages, false],
        ]);
    }
}
