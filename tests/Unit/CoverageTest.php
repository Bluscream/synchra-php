<?php

declare(strict_types=1);

namespace Synchra\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Synchra\Auth\StaticToken;
use Synchra\Http\Transport;
use Synchra\Http\TransportResponse;
use Synchra\Resource\AbstractResource;
use Synchra\Synchra;

/**
 * Guards the promise that the SDK reaches the whole API.
 *
 * Every operation in `spec/openapi.json` must be a method on some resource, and every resource
 * must be reachable from {@see Synchra}. A regeneration that silently dropped an endpoint group
 * or an operation fails here rather than being discovered by whoever needed that endpoint.
 */
final class CoverageTest extends TestCase
{
    /** @return array<string, mixed> */
    private static function spec(): array
    {
        $raw = \file_get_contents(__DIR__ . '/../../spec/openapi.json');
        self::assertIsString($raw);

        /** @var array<string, mixed> $decoded */
        $decoded = \json_decode($raw, true, 512, \JSON_THROW_ON_ERROR);

        return $decoded;
    }

    /** @return list<string> */
    private static function specOperations(): array
    {
        /** @var array<string, array<string, mixed>> $paths */
        $paths = self::spec()['paths'] ?? [];
        $out = [];

        foreach ($paths as $path => $item) {
            foreach ($item as $method => $operation) {
                if (\in_array($method, ['get', 'post', 'put', 'patch', 'delete'], true) && \is_array($operation)) {
                    $out[] = \strtoupper($method) . ' ' . $path;
                }
            }
        }

        return $out;
    }

    /** @return list<class-string<AbstractResource>> */
    private static function resourceClasses(): array
    {
        $out = [];

        foreach (\glob(__DIR__ . '/../../src/Resource/*.php') ?: [] as $path) {
            $short = \basename($path, '.php');

            if ($short === 'AbstractResource' || $short === 'ResourceAccessors') {
                continue;
            }

            /** @var class-string<AbstractResource> $class */
            $class = 'Synchra\\Resource\\' . $short;
            $out[] = $class;
        }

        return $out;
    }

    public function testEveryOperationInTheSpecIsReachableAsAMethod(): void
    {
        $documented = [];

        foreach (self::resourceClasses() as $class) {
            foreach ((new \ReflectionClass($class))->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
                $doc = $method->getDocComment();

                if ($doc === false) {
                    continue;
                }

                // Each generated method documents the operation it calls as `GET /api/2/...`.
                if (\preg_match('/`(GET|POST|PUT|PATCH|DELETE) (\S+)`/', $doc, $matches) === 1) {
                    $documented[$matches[1] . ' ' . $matches[2]] = true;
                }
            }
        }

        $missing = \array_values(\array_diff(self::specOperations(), \array_keys($documented)));

        self::assertSame([], $missing, 'Operations with no SDK method.');
    }

    public function testTheOperationCountMatchesTheSpec(): void
    {
        $methods = 0;

        foreach (self::resourceClasses() as $class) {
            foreach ((new \ReflectionClass($class))->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
                if ($method->getDeclaringClass()->getName() === $class) {
                    ++$methods;
                }
            }
        }

        self::assertSame(\count(self::specOperations()), $methods);
    }

    public function testEveryEndpointGroupIsReachableFromTheClient(): void
    {
        $synchra = new Synchra(new StaticToken('test'), transport: new class implements Transport {
            public function send(string $method, string $uri, array $headers, ?string $body): TransportResponse
            {
                throw new \LogicException('No request should be made while listing accessors.');
            }
        });

        $returned = [];

        foreach ((new \ReflectionClass(Synchra::class))->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
            $type = $method->getReturnType();

            if (!$type instanceof \ReflectionNamedType || $method->getNumberOfParameters() > 0) {
                continue;
            }

            if (!\str_starts_with($type->getName(), 'Synchra\\Resource\\')) {
                continue;
            }

            $resource = $synchra->{$method->getName()}();

            self::assertSame($type->getName(), \get_debug_type($resource));
            // The accessor memoises, so two calls must give the same object rather than a fresh
            // client per call.
            self::assertSame($resource, $synchra->{$method->getName()}());

            $returned[] = $type->getName();
        }

        self::assertSame([], \array_values(\array_diff(self::resourceClasses(), $returned)));
    }

    public function testEveryTagInTheSpecHasAResource(): void
    {
        /** @var array<string, array<string, mixed>> $paths */
        $paths = self::spec()['paths'] ?? [];
        $tags = [];

        foreach ($paths as $item) {
            foreach ($item as $method => $operation) {
                if (!\in_array($method, ['get', 'post', 'put', 'patch', 'delete'], true) || !\is_array($operation)) {
                    continue;
                }

                $operationTags = $operation['tags'] ?? [];

                self::assertIsArray($operationTags);

                foreach ($operationTags as $tag) {
                    self::assertIsString($tag);
                    $tags[$tag] = true;
                }
            }
        }

        self::assertCount(\count(self::resourceClasses()), $tags);
    }
}
