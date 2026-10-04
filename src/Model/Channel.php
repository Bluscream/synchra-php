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
 * The `Channel` schema.
 */
final readonly class Channel implements DataModel
{
    /**
     * @param list<ChannelProviderPublic>|null $channel_providers
     * @param list<ChannelProviderStream>|null $channel_provider_streams
     */
    public function __construct(
        public string $id,
        public string $display_name,
        public \DateTimeImmutable $created_at,
        public ChannelPlan $plan,
        public ?bool $show_on_landing_page = null,
        public ?ChannelUserAccessLevel $user_access_level = null,
        public ?array $channel_providers = null,
        public ?array $channel_provider_streams = null,
        public ?AdminChannelSubscription $subscription = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $reader = new Reader($data, self::class);

        return new self(
            id: $reader->requiredString('id'),
            display_name: $reader->requiredString('display_name'),
            created_at: $reader->requiredDateTime('created_at'),
            plan: $reader->requiredModel('plan', ChannelPlan::class),
            show_on_landing_page: $reader->optionalBool('show_on_landing_page'),
            user_access_level: $reader->optionalModel('user_access_level', ChannelUserAccessLevel::class),
            channel_providers: $reader->optionalModelList('channel_providers', ChannelProviderPublic::class),
            channel_provider_streams: $reader->optionalModelList('channel_provider_streams', ChannelProviderStream::class),
            subscription: $reader->optionalModel('subscription', AdminChannelSubscription::class),
        );
    }

    public function jsonSerialize(): array
    {
        return Writer::payload([
            'id' => [$this->id, true],
            'display_name' => [$this->display_name, true],
            'created_at' => [$this->created_at, true],
            'plan' => [$this->plan, true],
            'show_on_landing_page' => [$this->show_on_landing_page, false],
            'user_access_level' => [$this->user_access_level, true],
            'channel_providers' => [$this->channel_providers, true],
            'channel_provider_streams' => [$this->channel_provider_streams, true],
            'subscription' => [$this->subscription, true],
        ]);
    }
}
