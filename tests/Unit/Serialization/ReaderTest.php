<?php

declare(strict_types=1);

namespace Synchra\Tests\Unit\Serialization;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Synchra\Enum\Provider;
use Synchra\Exception\SerializationException;
use Synchra\Model\UserPublic;
use Synchra\Serialization\Reader;

#[CoversClass(Reader::class)]
final class ReaderTest extends TestCase
{
    public function testRequiredScalarsAreReadByName(): void
    {
        $reader = new Reader([
            'name' => 'bleichi',
            'count' => 7,
            'ratio' => 0.5,
            'live' => true,
        ], 'Example');

        self::assertSame('bleichi', $reader->requiredString('name'));
        self::assertSame(7, $reader->requiredInt('count'));
        self::assertSame(0.5, $reader->requiredFloat('ratio'));
        self::assertTrue($reader->requiredBool('live'));
    }

    public function testAnIntegerIsAcceptedWhereAFloatIsExpected(): void
    {
        // JSON has one number type, so a whole number arrives as an int even for a float field.
        $reader = new Reader(['ratio' => 2], 'Example');

        self::assertSame(2.0, $reader->requiredFloat('ratio'));
    }

    public function testOptionalScalarsAreNullWhenAbsentOrNull(): void
    {
        $reader = new Reader(['present' => null], 'Example');

        self::assertNull($reader->optionalString('present'));
        self::assertNull($reader->optionalString('missing'));
        self::assertNull($reader->optionalInt('missing'));
        self::assertNull($reader->optionalBool('missing'));
        self::assertNull($reader->optionalDateTime('missing'));
    }

    public function testAMissingRequiredFieldNamesTheModelAndTheField(): void
    {
        $reader = new Reader([], 'Channel');

        $this->expectException(SerializationException::class);
        $this->expectExceptionMessage('Channel');
        $this->expectExceptionMessage('display_name');

        $reader->requiredString('display_name');
    }

    public function testAWrongTypeIsReportedRatherThanCoerced(): void
    {
        $reader = new Reader(['total' => 'not a number'], 'Channel');

        $this->expectException(SerializationException::class);

        $reader->requiredInt('total');
    }

    public function testDateTimesKeepTheirInstantAndSubSecondPrecision(): void
    {
        $reader = new Reader(['created_at' => '2026-10-04T19:31:44.355000Z'], 'Example');
        $at = $reader->requiredDateTime('created_at');

        self::assertSame('2026-10-04T19:31:44.355000+00:00', $at->format('Y-m-d\TH:i:s.uP'));
    }

    public function testAnUnparsableDateTimeIsReported(): void
    {
        $reader = new Reader(['created_at' => 'the day before yesterday'], 'Example');

        $this->expectException(SerializationException::class);

        $reader->requiredDateTime('created_at');
    }

    public function testEnumsAreHydratedFromTheirWireValue(): void
    {
        $reader = new Reader(['provider' => 'tiktok'], 'Example');

        self::assertSame(Provider::Tiktok, $reader->requiredEnum('provider', Provider::class));
    }

    public function testAnUnknownEnumValueFailsLoudlyAndSaysHowToFixIt(): void
    {
        // Accepting an unknown value silently would hand the caller an enum that is not in the
        // type, so the SDK stops and points at the regeneration step instead.
        $reader = new Reader(['provider' => 'some_new_platform'], 'Example');

        $this->expectException(SerializationException::class);
        $this->expectExceptionMessage('fetch-spec.sh');

        $reader->requiredEnum('provider', Provider::class);
    }

    public function testNestedModelsAreHydrated(): void
    {
        $reader = new Reader([
            'user' => [
                'id' => '019d49d2-0891-70e5-b791-c94fd76ca590',
                'username' => 'example',
                'display_name' => 'Example',
            ],
        ], 'Example');

        $user = $reader->requiredModel('user', UserPublic::class);

        self::assertSame('example', $user->username);
    }

    public function testScalarListsRejectAMixedBag(): void
    {
        $reader = new Reader(['ids' => ['a', 2]], 'Example');

        $this->expectException(SerializationException::class);

        $reader->requiredStringList('ids');
    }

    public function testListsReadViaAFactoryHydrateEveryItem(): void
    {
        $reader = new Reader([
            'records' => [
                ['id' => '1', 'username' => 'a', 'display_name' => 'A'],
                ['id' => '2', 'username' => 'b', 'display_name' => 'B'],
            ],
        ], 'Example');

        $users = $reader->requiredListVia('records', UserPublic::fromArray(...));

        self::assertCount(2, $users);
        self::assertSame('b', $users[1]->username);
    }

    public function testAnObjectWhereAListWasExpectedIsReported(): void
    {
        $reader = new Reader(['records' => ['keyed' => 'value']], 'Example');

        $this->expectException(SerializationException::class);

        $reader->requiredModelList('records', UserPublic::class);
    }

    public function testRawReturnsTheUntouchedPayload(): void
    {
        $data = ['a' => 1, 'unknown_future_field' => ['nested' => true]];

        self::assertSame($data, (new Reader($data, 'Example'))->raw());
    }
}
