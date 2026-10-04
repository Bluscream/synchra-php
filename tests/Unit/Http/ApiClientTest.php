<?php

declare(strict_types=1);

namespace Synchra\Tests\Unit\Http;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Synchra\Auth\StaticToken;
use Synchra\ClientOptions;
use Synchra\Exception\ApiException;
use Synchra\Exception\AuthenticationException;
use Synchra\Exception\AuthorizationException;
use Synchra\Exception\BadRequestException;
use Synchra\Exception\ConflictException;
use Synchra\Exception\NotFoundException;
use Synchra\Exception\PayloadTooLargeException;
use Synchra\Exception\RateLimitException;
use Synchra\Exception\SerializationException;
use Synchra\Exception\ServerException;
use Synchra\Exception\ValidationException;
use Synchra\Http\ApiClient;
use Synchra\Http\ApiRequest;
use Synchra\Http\RetryPolicy;
use Synchra\Synchra;
use Synchra\Tests\Support\FakeTransport;
use Synchra\Tests\Support\Fixture;

#[CoversClass(ApiClient::class)]
final class ApiClientTest extends TestCase
{
    private function client(FakeTransport $transport, ?ClientOptions $options = null, ?string $token = 'test-token'): ApiClient
    {
        return new ApiClient(new StaticToken($token), $options ?? new ClientOptions(), $transport);
    }

    public function testTheRequestIsBuiltFromTheBaseUriPathAndQuery(): void
    {
        $transport = (new FakeTransport())->queueJson(200, ['ok' => true]);

        $this->client($transport)->send(new ApiRequest(
            method: 'get',
            path: '/channels',
            query: ['per_page' => 2, 'cursor' => null],
        ));

        self::assertSame('GET', $transport->lastRequest()['method']);
        self::assertSame('https://api.synchra.net/api/2/channels?per_page=2', $transport->lastRequest()['uri']);
        self::assertNull($transport->lastRequest()['body']);
    }

    public function testTheTokenIsSentAsABearerHeader(): void
    {
        $transport = (new FakeTransport())->queueJson(200, []);

        $this->client($transport, token: 'abc123')->send(new ApiRequest('GET', '/user'));

        self::assertSame('Bearer abc123', $transport->lastHeader('authorization'));
    }

    public function testNoAuthorizationHeaderIsSentWithoutAToken(): void
    {
        // Sending `Bearer ` would turn a clear "no credentials configured" into a confusing 401.
        $transport = (new FakeTransport())->queueJson(200, []);

        $this->client($transport, token: null)->send(new ApiRequest('GET', '/user'));

        self::assertNull($transport->lastHeader('authorization'));
    }

    public function testTheUserAgentIdentifiesTheSdkAndItsVersion(): void
    {
        $transport = (new FakeTransport())->queueJson(200, []);

        $this->client($transport)->send(new ApiRequest('GET', '/user'));

        self::assertSame(
            \sprintf('synchra-php/%s (+https://github.com/Bluscream/synchra-php)', Synchra::VERSION),
            $transport->lastHeader('user-agent'),
        );
    }

    public function testAJsonBodyIsEncodedAndTypedWithoutEscapingSlashesOrUnicode(): void
    {
        $transport = (new FakeTransport())->queueJson(201, []);

        $this->client($transport)->send(new ApiRequest(
            method: 'POST',
            path: '/chat/messages',
            body: ['message' => 'héllo https://example.com/a'],
        ));

        self::assertSame('{"message":"héllo https://example.com/a"}', $transport->lastRequest()['body']);
        self::assertSame('application/json', $transport->lastHeader('content-type'));
    }

    public function testARawBodyIsSentVerbatimAndKeepsTheCallersContentType(): void
    {
        $transport = (new FakeTransport())->queueJson(201, []);

        $this->client($transport)->send(new ApiRequest(
            method: 'POST',
            path: '/files',
            headers: ['Content-Type' => 'application/octet-stream'],
            rawBody: "\x00\x01binary",
        ));

        self::assertSame("\x00\x01binary", $transport->lastRequest()['body']);
        self::assertSame('application/octet-stream', $transport->lastHeader('content-type'));
    }

    public function testPerRequestHeadersOverrideTheClientWideOnes(): void
    {
        $transport = (new FakeTransport())->queueJson(200, []);
        $options = (new ClientOptions())->withHeaders(['X-Kv-Token' => 'wide']);

        $this->client($transport, $options)->send(new ApiRequest(
            method: 'GET',
            path: '/kv/a',
            headers: ['X-Kv-Token' => 'narrow'],
        ));

        self::assertSame('narrow', $transport->lastHeader('x-kv-token'));
    }

    public function testA204DecodesToNullRatherThanFailingOnAnEmptyBody(): void
    {
        $transport = (new FakeTransport())->queue(204);

        $response = $this->client($transport)->send(new ApiRequest('DELETE', '/channels/x'));

        self::assertSame(204, $response->status);
        self::assertNull($response->data);
    }

    public function testA200WithAnEmptyBodyAlsoDecodesToNull(): void
    {
        $transport = (new FakeTransport())->queue(200, '   ');

        self::assertNull($this->client($transport)->send(new ApiRequest('GET', '/x'))->data);
    }

    public function testASuccessBodyThatIsNotJsonIsReportedAsASerialisationProblem(): void
    {
        $transport = (new FakeTransport())->queue(200, '<html>proxy says hello</html>');

        $this->expectException(SerializationException::class);

        $this->client($transport)->send(new ApiRequest('GET', '/x'));
    }

    /** @param class-string<ApiException> $expected */
    #[DataProvider('errorStatuses')]
    public function testEachErrorStatusMapsToItsOwnException(int $status, string $expected): void
    {
        $transport = (new FakeTransport())->queueJson($status, [
            'code' => $status,
            'message' => 'Something went wrong.',
            'type' => 'example_error',
            'errors' => [],
        ]);

        try {
            $this->client($transport, (new ClientOptions())->withRetry(RetryPolicy::disabled()))
                ->send(new ApiRequest('GET', '/x'));
            self::fail("Expected {$expected}.");
        } catch (ApiException $e) {
            self::assertInstanceOf($expected, $e);
            self::assertSame($status, $e->status);
            self::assertSame('example_error', $e->errorType());
        }
    }

    /** @return iterable<string, array{int, class-string<ApiException>}> */
    public static function errorStatuses(): iterable
    {
        yield '400' => [400, BadRequestException::class];
        yield '401' => [401, AuthenticationException::class];
        yield '403' => [403, AuthorizationException::class];
        yield '404' => [404, NotFoundException::class];
        yield '409' => [409, ConflictException::class];
        yield '413' => [413, PayloadTooLargeException::class];
        yield '422' => [422, ValidationException::class];
        yield '429' => [429, RateLimitException::class];
        yield '500' => [500, ServerException::class];
        yield '503' => [503, ServerException::class];
    }

    public function testTheRecordedValidationEnvelopeIsParsedIntoFieldErrors(): void
    {
        $transport = (new FakeTransport())->queue(400, Fixture::raw('error-validation.json'));

        try {
            $this->client($transport)->send(new ApiRequest('POST', '/chat/messages', body: []));
            self::fail('Expected a BadRequestException.');
        } catch (BadRequestException $e) {
            self::assertSame('no_youtube_stream_chat', $e->errorType());
            self::assertSame([], $e->fieldErrors());
            self::assertStringContainsString('POST', $e->getMessage());
        }
    }

    public function testPerFieldValidationProblemsAreExposed(): void
    {
        $transport = (new FakeTransport())->queueJson(422, [
            'code' => 422,
            'message' => 'Validation failed.',
            'type' => 'validation_error',
            'errors' => [
                ['field' => 'message', 'message' => 'Field required', 'type' => 'missing'],
            ],
        ]);

        try {
            $this->client($transport)->send(new ApiRequest('POST', '/chat/messages', body: []));
            self::fail('Expected a ValidationException.');
        } catch (ValidationException $e) {
            self::assertCount(1, $e->fieldErrors());
            self::assertSame('message', $e->fieldErrors()[0]->field);
        }
    }

    public function testAnErrorBodyThatIsNotTheEnvelopeStillProducesTheRightStatus(): void
    {
        // An nginx error page must not be allowed to mask the status behind a parse failure.
        $transport = (new FakeTransport())->queue(502, '<html><h1>502 Bad Gateway</h1></html>');
        $options = (new ClientOptions())->withRetry(RetryPolicy::disabled());

        try {
            $this->client($transport, $options)->send(new ApiRequest('GET', '/x'));
            self::fail('Expected a ServerException.');
        } catch (ServerException $e) {
            self::assertSame(502, $e->status);
            self::assertNull($e->errorType());
        }
    }

    public function testARetryableStatusIsRetriedUpToTheLimitAndThenReported(): void
    {
        $transport = (new FakeTransport())
            ->queueJson(503, [])
            ->queueJson(503, [])
            ->queueJson(503, []);

        $options = (new ClientOptions())->withRetry(new RetryPolicy(
            maxAttempts: 3,
            baseDelayMs: 1,
            sleeper: static function (int $ms): void {},
        ));

        try {
            $this->client($transport, $options)->send(new ApiRequest('GET', '/x'));
            self::fail('Expected a ServerException.');
        } catch (ServerException) {
            self::assertSame(3, $transport->callCount());
        }
    }

    public function testASucceedingRetryReturnsTheSecondResponse(): void
    {
        $transport = (new FakeTransport())
            ->queueJson(503, [])
            ->queueJson(200, ['id' => 'ok']);

        $slept = [];
        $options = (new ClientOptions())->withRetry(new RetryPolicy(
            baseDelayMs: 10,
            sleeper: static function (int $ms) use (&$slept): void {
                $slept[] = $ms;
            },
        ));

        $response = $this->client($transport, $options)->send(new ApiRequest('GET', '/x'));

        self::assertSame(['id' => 'ok'], $response->object());
        self::assertSame([10], $slept);
    }

    public function testAPostIsNotRetriedEvenOnAServerError(): void
    {
        $transport = (new FakeTransport())->queueJson(503, []);

        try {
            $this->client($transport)->send(new ApiRequest('POST', '/x', body: []));
            self::fail('Expected a ServerException.');
        } catch (ServerException) {
            self::assertSame(1, $transport->callCount());
        }
    }

    public function testARetryAfterHeaderIsHonouredOverTheBackoff(): void
    {
        $transport = (new FakeTransport())
            ->queueJson(429, [], ['retry-after' => ['2']])
            ->queueJson(200, []);

        $slept = [];
        $options = (new ClientOptions())->withRetry(new RetryPolicy(
            baseDelayMs: 10,
            sleeper: static function (int $ms) use (&$slept): void {
                $slept[] = $ms;
            },
        ));

        $this->client($transport, $options)->send(new ApiRequest('GET', '/x'));

        self::assertSame([2_000], $slept);
    }

    public function testADifferentBaseUriIsUsedVerbatim(): void
    {
        $transport = (new FakeTransport())->queueJson(200, []);
        $options = (new ClientOptions())->withApiBaseUri('https://dash.synchra.net/api/2/');

        $this->client($transport, $options)->send(new ApiRequest('GET', '/user'));

        self::assertSame('https://dash.synchra.net/api/2/user', $transport->lastRequest()['uri']);
    }
}
