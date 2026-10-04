<?php

declare(strict_types=1);

namespace Synchra\Tests\Unit\Serialization;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Synchra\Enum\Provider;
use Synchra\Model\ChannelUpdate;
use Synchra\Model\UserPublic;
use Synchra\Serialization\Writer;

#[CoversClass(Writer::class)]
final class WriterTest extends TestCase
{
    public function testAnOptionalNullIsOmittedSoAPartialUpdateStaysPartial(): void
    {
        // This is the whole point of the `alwaysSend` flag: the API treats a present null as
        // "clear this field", so an untouched optional field must not appear in the body at all.
        $payload = Writer::payload([
            'display_name' => ['Bleichi', false],
            'description' => [null, false],
        ]);

        self::assertSame(['display_name' => 'Bleichi'], $payload);
        self::assertArrayNotHasKey('description', $payload);
    }

    public function testANullableFieldKeepsItsNullOnTheWire(): void
    {
        $payload = Writer::payload(['expires_at' => [null, true]]);

        self::assertSame(['expires_at' => null], $payload);
    }

    public function testEnumsAreWrittenAsTheirBackingValue(): void
    {
        self::assertSame('twitch', Writer::value(Provider::Twitch));
    }

    public function testDateTimesAreWrittenAsRfc3339WithMicroseconds(): void
    {
        $at = new \DateTimeImmutable('2026-10-04T19:31:44.355000+00:00');

        self::assertSame('2026-10-04T19:31:44.355000Z', Writer::value($at));
    }

    public function testANonUtcDateTimeKeepsItsOffsetRatherThanSilentlyShifting(): void
    {
        $at = new \DateTimeImmutable('2026-10-04T21:31:44.000000+02:00');

        self::assertSame('2026-10-04T21:31:44.000000+02:00', Writer::value($at));
    }

    public function testNestedModelsAreSerialisedRecursively(): void
    {
        $value = Writer::value([
            'user' => new UserPublic(id: 'u1', username: 'example', display_name: 'Example'),
            'providers' => [Provider::Twitch, Provider::Kick],
        ]);

        self::assertSame([
            'user' => [
                'id' => 'u1',
                'username' => 'example',
                'display_name' => 'Example',
                'default_channel_id' => null,
            ],
            'providers' => ['twitch', 'kick'],
        ], $value);
    }

    public function testScalarsPassThroughUntouched(): void
    {
        self::assertSame(7, Writer::value(7));
        self::assertSame(0.5, Writer::value(0.5));
        self::assertFalse(Writer::value(false));
        self::assertSame('', Writer::value(''));
        self::assertNull(Writer::value(null));
    }

    public function testAGeneratedUpdateModelSendsOnlyTheFieldsThatWereSet(): void
    {
        $update = new ChannelUpdate(display_name: 'New name');

        self::assertSame(['display_name' => 'New name'], $update->jsonSerialize());
    }
}
