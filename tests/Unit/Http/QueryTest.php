<?php

declare(strict_types=1);

namespace Synchra\Tests\Unit\Http;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Synchra\Enum\Provider;
use Synchra\Http\Query;

#[CoversClass(Query::class)]
final class QueryTest extends TestCase
{
    public function testNullParametersAreDroppedRatherThanSentEmpty(): void
    {
        self::assertSame('per_page=50', Query::build(['per_page' => 50, 'cursor' => null]));
    }

    public function testBooleansUseTheWordsTheApiExpects(): void
    {
        // PHP's own http_build_query would emit `1` and an empty string here, which the API
        // reads as a string rather than a boolean.
        self::assertSame('live=true&muted=false', Query::build(['live' => true, 'muted' => false]));
    }

    public function testAListBecomesARepeatedParameter(): void
    {
        self::assertSame(
            'status=pending&status=live',
            Query::build(['status' => ['pending', 'live']]),
        );
    }

    public function testEnumsAreSentAsTheirWireValue(): void
    {
        self::assertSame('provider=twitch', Query::build(['provider' => Provider::Twitch]));
    }

    public function testValuesAndNamesAreEncoded(): void
    {
        self::assertSame(
            'q=a%20b%26c%3Dd',
            Query::build(['q' => 'a b&c=d']),
        );
    }

    public function testAnEmptyStringIsSentBecauseItIsNotTheSameAsAbsent(): void
    {
        self::assertSame('q=', Query::build(['q' => '']));
    }

    public function testNoParametersProducesAnEmptyString(): void
    {
        self::assertSame('', Query::build([]));
        self::assertSame('', Query::build(['cursor' => null]));
    }

    public function testAnEmptyListProducesNoPairsAtAll(): void
    {
        self::assertSame('per_page=1', Query::build(['status' => [], 'per_page' => 1]));
    }

    public function testADateTimeIsSentInTheFormatTheApiParses(): void
    {
        $at = new \DateTimeImmutable('2026-10-04T19:31:44.000000+00:00');

        self::assertSame('since=2026-10-04T19%3A31%3A44.000000Z', Query::build(['since' => $at]));
    }
}
