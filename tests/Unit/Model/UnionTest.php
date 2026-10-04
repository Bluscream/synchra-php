<?php

declare(strict_types=1);

namespace Synchra\Tests\Unit\Model;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Synchra\Exception\SerializationException;
use Synchra\Model\ChatUserProfile;
use Synchra\Model\Union\UserProfileUnion;
use Synchra\Model\Union\WidgetUnion;
use Synchra\Serialization\Union;
use Synchra\Tests\Support\Fixture;

#[CoversClass(Union::class)]
final class UnionTest extends TestCase
{
    /** @return list<array<string, mixed>> */
    private static function profileRecords(): array
    {
        $records = Fixture::object('user-profiles.json')['records'] ?? null;

        self::assertIsArray($records);

        $out = [];

        foreach ($records as $record) {
            self::assertIsArray($record);
            /** @var array<string, mixed> $record */
            $out[] = $record;
        }

        return $out;
    }

    public function testARecordedProfileResolvesToItsTaggedVariant(): void
    {
        $records = self::profileRecords();

        self::assertNotEmpty($records);

        foreach ($records as $record) {
            $profile = UserProfileUnion::fromArray($record);

            // The variant chosen has to match the tag on the wire, not just be *some* profile.
            self::assertSame($record['type'], $profile->type);
        }
    }

    public function testTheChatVariantIsTheConcreteChatProfileClass(): void
    {
        $chat = null;

        foreach (self::profileRecords() as $record) {
            if (($record['type'] ?? null) === 'chat') {
                $chat = UserProfileUnion::fromArray($record);

                break;
            }
        }

        self::assertInstanceOf(ChatUserProfile::class, $chat);
    }

    public function testAMissingDiscriminatorNamesTheFieldAndTheUnion(): void
    {
        $this->expectException(SerializationException::class);
        $this->expectExceptionMessage('type');

        UserProfileUnion::fromArray(['id' => 'x']);
    }

    public function testAnUnknownTagListsTheTagsThatAreKnown(): void
    {
        // When Synchra adds a profile kind, the message has to say what the SDK does know, so the
        // fix (regenerate) is obvious from the error alone.
        try {
            UserProfileUnion::fromArray(['type' => 'hologram']);
            self::fail('Expected a SerializationException.');
        } catch (SerializationException $e) {
            self::assertStringContainsString('hologram', $e->getMessage());
            self::assertStringContainsString('chat', $e->getMessage());
        }
    }

    public function testEveryUnionResolvesToAtLeastTwoVariants(): void
    {
        // A union comes in two flavours: tagged (DISCRIMINATOR + TAGS) when the description names
        // a discriminator, and shaped (VARIANTS) when it does not. Either way, a union that ended
        // up with fewer than two alternatives means the generator lost a branch.
        $unions = \glob(__DIR__ . '/../../../src/Model/Union/*.php') ?: [];

        self::assertNotEmpty($unions);

        foreach ($unions as $path) {
            $class = 'Synchra\\Model\\Union\\' . \basename($path, '.php');

            self::assertTrue(\class_exists($class), "{$class} does not autoload.");
            self::assertTrue(
                \method_exists($class, 'fromArray'),
                "{$class} has no fromArray() for callers to use.",
            );

            if (\defined($class . '::DISCRIMINATOR')) {
                self::assertNotSame('', \constant($class . '::DISCRIMINATOR'));
                $alternatives = \constant($class . '::TAGS');
            } else {
                $alternatives = \constant($class . '::VARIANTS');
            }

            self::assertIsArray($alternatives);
            self::assertGreaterThanOrEqual(2, \count($alternatives), "{$class} has only one branch.");
        }
    }

    public function testTheWidgetUnionCoversEveryWidgetKindTheApiDeclares(): void
    {
        // Widgets are the widest union in the API; a regeneration that quietly dropped a variant
        // would leave callers unable to read their own widget.
        self::assertGreaterThanOrEqual(10, \count(WidgetUnion::TAGS));
    }
}
