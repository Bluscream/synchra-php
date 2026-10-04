<?php

declare(strict_types=1);

namespace Synchra\Generator;

/**
 * One endpoint from the API description, with the parts the generator needs pulled out.
 */
final class Operation
{
    public readonly string $tag;
    public readonly string $summary;
    public readonly string $operationId;

    /** @var list<array<string, mixed>> */
    public readonly array $pathParameters;

    /** @var list<array<string, mixed>> */
    public readonly array $queryParameters;

    /** @var list<array<string, mixed>> */
    public readonly array $headerParameters;

    /** @var list<string> */
    public readonly array $scopes;

    /** @param array<string, mixed> $definition */
    public function __construct(
        public readonly string $path,
        public readonly string $method,
        public readonly array $definition,
    ) {
        /** @var list<string> $tags */
        $tags = $definition['tags'] ?? [];
        $this->tag = $tags[0] ?? 'Misc';
        $this->summary = \is_string($definition['summary'] ?? null) ? $definition['summary'] : '';
        $this->operationId = \is_string($definition['operationId'] ?? null) ? $definition['operationId'] : '';

        $byLocation = ['path' => [], 'query' => [], 'header' => []];

        /** @var list<array<string, mixed>> $parameters */
        $parameters = $definition['parameters'] ?? [];

        foreach ($parameters as $parameter) {
            $in = $parameter['in'] ?? null;

            if (\is_string($in) && isset($byLocation[$in])) {
                $byLocation[$in][] = $parameter;
            }
        }

        $this->pathParameters = $byLocation['path'];
        $this->queryParameters = $byLocation['query'];
        $this->headerParameters = $byLocation['header'];
        $this->scopes = $this->collectScopes();
    }

    public function phpName(): string
    {
        return Names::operationMethod($this->method, $this->path, $this->summary !== '' ? $this->summary : $this->operationId);
    }

    /**
     * The path with the API version prefix removed, since the client holds that in its base URI.
     */
    public function relativePath(): string
    {
        return \preg_replace('#^/api/2#', '', $this->path) ?? $this->path;
    }

    /** @return array<string, mixed>|null */
    public function requestBodySchema(): ?array
    {
        return Spec::objectAt($this->definition, 'requestBody', 'content', 'application/json', 'schema');
    }

    public function requestBodyRequired(): bool
    {
        return Spec::dig($this->definition, 'requestBody', 'required') === true;
    }

    /**
     * The schema of the success response, plus its status. Null schema means an empty body.
     *
     * @return array{int, array<string, mixed>|null}
     */
    public function successResponse(): array
    {
        foreach (['200', '201', '202', '204'] as $status) {
            if (Spec::dig($this->definition, 'responses', $status) === null) {
                continue;
            }

            return [
                (int) $status,
                Spec::objectAt($this->definition, 'responses', $status, 'content', 'application/json', 'schema'),
            ];
        }

        return [200, null];
    }

    /** @return list<string> */
    private function collectScopes(): array
    {
        /** @var list<array<string, list<string>>> $security */
        $security = $this->definition['security'] ?? [];
        $scopes = [];

        foreach ($security as $requirement) {
            foreach ($requirement as $granted) {
                foreach ($granted as $scope) {
                    $scopes[] = $scope;
                }
            }
        }

        return \array_values(\array_unique($scopes));
    }
}
