<?php

declare(strict_types=1);

namespace Synchra\Tests\Unit\Http;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Synchra\Http\RetryPolicy;

#[CoversClass(RetryPolicy::class)]
final class RetryPolicyTest extends TestCase
{
    public function testUnsafeMethodsAreNotRetriedByDefault(): void
    {
        // Resending a POST that already created something would create it twice, so the default
        // is to give the caller the error rather than guess.
        $policy = new RetryPolicy();

        self::assertFalse($policy->allowsMethod('POST'));
        self::assertFalse($policy->allowsMethod('PATCH'));
        self::assertTrue($policy->allowsMethod('GET'));
        self::assertTrue($policy->allowsMethod('DELETE'));
        self::assertTrue($policy->allowsMethod('put'));
    }

    public function testUnsafeMethodsAreRetriedOnceOptedIn(): void
    {
        self::assertTrue((new RetryPolicy(retryUnsafeMethods: true))->allowsMethod('POST'));
    }

    #[DataProvider('retryableStatuses')]
    public function testRetryableStatusesAreRetriedWhileAttemptsRemain(int $status): void
    {
        $policy = new RetryPolicy(maxAttempts: 3);

        self::assertTrue($policy->shouldRetry('GET', $status, 1));
        self::assertTrue($policy->shouldRetry('GET', $status, 2));
        self::assertFalse($policy->shouldRetry('GET', $status, 3));
    }

    /** @return iterable<string, array{int}> */
    public static function retryableStatuses(): iterable
    {
        yield 'rate limited' => [429];
        yield 'server error' => [500];
        yield 'bad gateway' => [502];
        yield 'unavailable' => [503];
        yield 'gateway timeout' => [504];
    }

    #[DataProvider('finalStatuses')]
    public function testClientErrorsAreNeverRetried(int $status): void
    {
        self::assertFalse((new RetryPolicy())->shouldRetry('GET', $status, 1));
    }

    /** @return iterable<string, array{int}> */
    public static function finalStatuses(): iterable
    {
        yield 'bad request' => [400];
        yield 'unauthenticated' => [401];
        yield 'forbidden' => [403];
        yield 'not found' => [404];
        yield 'unprocessable' => [422];
        yield 'success' => [200];
    }

    public function testDisabledNeverRetries(): void
    {
        self::assertFalse(RetryPolicy::disabled()->shouldRetry('GET', 503, 1));
    }

    public function testBackoffDoublesAndStopsAtTheCeiling(): void
    {
        $policy = new RetryPolicy(baseDelayMs: 500, maxDelayMs: 2_000);

        self::assertSame(500, $policy->delayMs(1, null));
        self::assertSame(1_000, $policy->delayMs(2, null));
        self::assertSame(2_000, $policy->delayMs(3, null));
        self::assertSame(2_000, $policy->delayMs(9, null));
    }

    public function testASecondsRetryAfterHeaderWinsOverTheComputedBackoff(): void
    {
        $policy = new RetryPolicy(baseDelayMs: 500, maxDelayMs: 30_000);

        self::assertSame(3_000, $policy->delayMs(1, '3'));
    }

    public function testADateRetryAfterHeaderIsHonoured(): void
    {
        $policy = new RetryPolicy(maxDelayMs: 60_000);
        $at = (new \DateTimeImmutable('+5 seconds'))->format(\DateTimeInterface::RFC7231);

        // Allow a second of slack: the clock moves between formatting and parsing.
        self::assertGreaterThanOrEqual(3_000, $policy->delayMs(1, $at));
        self::assertLessThanOrEqual(6_000, $policy->delayMs(1, $at));
    }

    public function testARetryAfterHeaderIsStillCappedSoAServerCannotParkTheClient(): void
    {
        $policy = new RetryPolicy(maxDelayMs: 5_000);

        self::assertSame(5_000, $policy->delayMs(1, '3600'));
    }

    public function testAnUnparsableRetryAfterFallsBackToTheBackoff(): void
    {
        $policy = new RetryPolicy(baseDelayMs: 250);

        self::assertSame(250, $policy->delayMs(1, 'soon'));
        self::assertSame(250, $policy->delayMs(1, ''));
    }

    public function testSleepGoesThroughTheInjectedSleeperAndSkipsZero(): void
    {
        $slept = [];
        $policy = new RetryPolicy(sleeper: static function (int $ms) use (&$slept): void {
            $slept[] = $ms;
        });

        $policy->sleep(0);
        $policy->sleep(-1);
        $policy->sleep(120);

        self::assertSame([120], $slept);
    }
}
