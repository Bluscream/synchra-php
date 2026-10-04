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
 * The `ChatProfileFilters` schema.
 */
final readonly class ChatProfileFilters implements DataModel
{
    public function __construct(
        public ?ChatProfileFlagFilter $mentions_me = null,
        public ?ChatProfileKeywordFilter $viewer_names = null,
        public ?ChatProfileAccessLevelFilter $access_levels = null,
        public ?ChatProfileProviderFilter $providers = null,
        public ?ChatProfileMessageTypeFilter $message_types = null,
        public ?ChatProfileKeywordFilter $keywords = null,
        public ?ChatProfileChatterTypeFilter $chatter_types = null,
        public ?ChatProfileFlagFilter $has_links = null,
        public ?ChatProfileFlagFilter $has_replies = null,
        public ?ChatProfileFlagFilter $deleted_messages = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            mentions_me: $reader->optionalModel('mentions_me', ChatProfileFlagFilter::class),
            viewer_names: $reader->optionalModel('viewer_names', ChatProfileKeywordFilter::class),
            access_levels: $reader->optionalModel('access_levels', ChatProfileAccessLevelFilter::class),
            providers: $reader->optionalModel('providers', ChatProfileProviderFilter::class),
            message_types: $reader->optionalModel('message_types', ChatProfileMessageTypeFilter::class),
            keywords: $reader->optionalModel('keywords', ChatProfileKeywordFilter::class),
            chatter_types: $reader->optionalModel('chatter_types', ChatProfileChatterTypeFilter::class),
            has_links: $reader->optionalModel('has_links', ChatProfileFlagFilter::class),
            has_replies: $reader->optionalModel('has_replies', ChatProfileFlagFilter::class),
            deleted_messages: $reader->optionalModel('deleted_messages', ChatProfileFlagFilter::class),
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
