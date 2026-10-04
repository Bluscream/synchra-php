<?php

declare(strict_types=1);

namespace Synchra\Generator;

/**
 * Works out the PHP signature, docblock and body for one endpoint.
 *
 * Arguments come out in a fixed order — path, required query, required header, body, then the
 * optional-filter object — so a regeneration never reshuffles a published signature.
 */
final class MethodSignature
{
    private const RAW_BODY_CONTENT_TYPE = 'application/octet-stream';

    /** @var list<array{php: string, type: string, doc: string, default: string|null, description: string}> */
    private array $parameters = [];

    /** @var list<string> */
    private array $pathEntries = [];

    /** @var list<string> */
    private array $queryEntries = [];

    /** @var list<string> */
    private array $headerEntries = [];

    private bool $optionalHeaders = false;
    private ?string $queryClass = null;
    private string $queryArgument = 'query';
    private ?string $bodyArgument = null;
    private ?string $rawBodyArgument = null;

    public function __construct(
        private readonly Operation $operation,
        private readonly Spec $spec,
        private readonly TypeMapper $types,
        private readonly UnionRegistry $unions,
        QueryGenerator $queries,
    ) {
        $this->collectPathParameters();
        $this->collectQueryParameters();
        $this->collectHeaderParameters();
        $this->collectBody();
        $this->queryClass = $queries->register($operation);

        if ($this->queryClass !== null) {
            // A few operations take a query parameter literally called `query`, which would
            // collide with the filter object's own argument name.
            $this->queryArgument = $this->freeParameterName('query', 'filters', 'queryFilters');

            $this->parameters[] = [
                'php' => $this->queryArgument,
                'type' => '?\\Synchra\\Query\\' . $this->queryClass,
                'doc' => '?\\Synchra\\Query\\' . $this->queryClass,
                'default' => 'null',
                'description' => 'Optional filters.',
            ];
        }
    }

    public function parameterList(): string
    {
        $parts = [];

        foreach ($this->sortedParameters() as $parameter) {
            $parts[] = \sprintf(
                '%s $%s%s',
                $parameter['type'],
                $parameter['php'],
                $parameter['default'] === null ? '' : ' = ' . $parameter['default'],
            );
        }

        return \implode(', ', $parts);
    }

    /** @return list<string> */
    public function docLines(): array
    {
        $lines = [];

        if ($this->operation->summary !== '') {
            $lines[] = \rtrim($this->operation->summary, '.') . '.';
            $lines[] = '';
        }

        $lines[] = \sprintf('`%s %s`', $this->operation->method, $this->operation->path);

        if ($this->operation->scopes !== []) {
            $lines[] = '';
            $lines[] = \sprintf('Requires the `%s` scope.', \implode('`, `', $this->operation->scopes));
        }

        $paramDocs = [];

        foreach ($this->sortedParameters() as $parameter) {
            if ($parameter['doc'] === $parameter['type'] && $parameter['description'] === '') {
                continue;
            }

            $paramDocs[] = \sprintf(
                '@param %s $%s%s',
                $parameter['doc'],
                $parameter['php'],
                $parameter['description'] === '' ? '' : ' ' . $parameter['description'],
            );
        }

        $returnDoc = $this->returnDoc();

        if ($paramDocs !== [] || $returnDoc !== null) {
            $lines[] = '';
            $lines = [...$lines, ...$paramDocs];

            if ($returnDoc !== null) {
                $lines[] = $returnDoc;
            }
        }

        return $lines;
    }

    public function returnType(): string
    {
        return $this->response()['native'];
    }

    public function methodBody(): string
    {
        $arguments = [
            \sprintf("            method: '%s',", $this->operation->method),
            \sprintf('            path: %s,', $this->pathExpression()),
        ];

        if ($this->queryExpression() !== null) {
            $arguments[] = \sprintf('            query: %s,', $this->queryExpression());
        }

        if ($this->bodyArgument !== null) {
            $arguments[] = \sprintf('            body: %s,', $this->bodyArgument);
        }

        if ($this->headerEntries !== []) {
            $arguments[] = \sprintf('            headers: %s,', $this->headerExpression());
        }

        if ($this->rawBodyArgument !== null) {
            $arguments[] = \sprintf('            rawBody: %s,', $this->rawBodyArgument);
        }

        $request = \sprintf(
            "        \$request = new \\Synchra\\Http\\ApiRequest(\n%s\n        );\n",
            \implode("\n", $arguments),
        );

        $response = $this->response();

        if ($response['native'] === 'void') {
            return $request . "\n        \$this->client->send(\$request);";
        }

        return $request . \sprintf("\n        return %s;", $response['expression']);
    }

    /** @return list<array{php: string, type: string, doc: string, default: string|null, description: string}> */
    private function sortedParameters(): array
    {
        $required = [];
        $optional = [];

        foreach ($this->parameters as $parameter) {
            if ($parameter['default'] === null) {
                $required[] = $parameter;
            } else {
                $optional[] = $parameter;
            }
        }

        return [...$required, ...$optional];
    }

    private function collectPathParameters(): void
    {
        foreach ($this->operation->pathParameters as $parameter) {
            /** @var string $wire */
            $wire = $parameter['name'];
            /** @var array<string, mixed> $schema */
            $schema = $parameter['schema'] ?? [];
            $mapped = $this->types->map($schema, $wire, true, 'Path', $wire);
            $php = Names::camel($wire);

            // Three webhook ingest routes declare a path parameter as `string | None`, which is an
            // artefact of the handler's annotation: a URL segment always carries a value, and
            // there is no request a null could produce. Path parameters are therefore never
            // nullable here, whatever the schema says.
            $native = \ltrim($this->qualify($mapped->native, $mapped->imports), '?');

            $this->parameters[] = [
                'php' => $php,
                'type' => $native,
                'doc' => $native,
                'default' => null,
                'description' => $this->describe($parameter),
            ];
            $this->pathEntries[] = \sprintf("'%s' => \$%s", \addcslashes($wire, "'\\"), $php);
        }
    }

    private function collectQueryParameters(): void
    {
        foreach ($this->operation->queryParameters as $parameter) {
            if (($parameter['required'] ?? false) !== true) {
                continue;
            }

            /** @var string $wire */
            $wire = $parameter['name'];
            /** @var array<string, mixed> $schema */
            $schema = $parameter['schema'] ?? [];
            $mapped = $this->types->map($schema, $wire, true, 'Query', $wire);
            $php = Names::camel($wire);

            $this->parameters[] = [
                'php' => $php,
                'type' => $this->qualify($mapped->native, $mapped->imports),
                'doc' => $this->qualify($mapped->doc, $mapped->imports),
                'default' => $mapped->default,
                'description' => $this->describe($parameter),
            ];
            $this->queryEntries[] = \sprintf("'%s' => \$%s", \addcslashes($wire, "'\\"), $php);
        }
    }

    private function collectHeaderParameters(): void
    {
        foreach ($this->operation->headerParameters as $parameter) {
            /** @var string $wire */
            $wire = $parameter['name'];
            $lower = \strtolower($wire);

            // The upload endpoint declares its content type as a header constant; the raw body
            // argument below carries that meaning in PHP, so the header is set for the caller.
            if ($lower === 'content-type' || $lower === 'content-length') {
                continue;
            }

            /** @var array<string, mixed> $schema */
            $schema = $parameter['schema'] ?? [];
            $required = ($parameter['required'] ?? false) === true;
            $mapped = $this->types->map($schema, $wire, $required, 'Header', $wire);
            $php = Names::camel($wire);

            $this->parameters[] = [
                'php' => $php,
                'type' => $required
                    ? $this->qualify($mapped->native, $mapped->imports)
                    : '?' . \ltrim($this->qualify($mapped->native, $mapped->imports), '?'),
                'doc' => $this->qualify($mapped->doc, $mapped->imports),
                'default' => $required ? null : 'null',
                'description' => $this->describe($parameter),
            ];
            $this->headerEntries[] = \sprintf("'%s' => \$%s", \addcslashes($wire, "'\\"), $php);
            $this->optionalHeaders = $this->optionalHeaders || !$required;
        }
    }

    private function collectBody(): void
    {
        if ($this->expectsRawBody()) {
            $this->parameters[] = [
                'php' => 'contents',
                'type' => 'string',
                'doc' => 'string',
                'default' => null,
                'description' => 'The raw bytes to upload.',
            ];
            $this->rawBodyArgument = '$contents';
            $this->headerEntries[] = \sprintf("'Content-Type' => '%s'", self::RAW_BODY_CONTENT_TYPE);

            return;
        }

        $schema = $this->operation->requestBodySchema();

        if ($schema === null) {
            return;
        }

        $required = $this->operation->requestBodyRequired();
        $mapped = $this->bodyType($schema, $required);

        $this->parameters[] = [
            'php' => 'payload',
            'type' => $mapped['native'],
            'doc' => $mapped['native'],
            'default' => $required ? null : 'null',
            'description' => 'The request body.',
        ];
        $this->bodyArgument = '$payload';
    }

    private function expectsRawBody(): bool
    {
        foreach ($this->operation->headerParameters as $parameter) {
            if (Spec::dig($parameter, 'schema', 'const') === self::RAW_BODY_CONTENT_TYPE) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param array<string, mixed> $schema
     *
     * @return array{native: string}
     */
    private function bodyType(array $schema, bool $required): array
    {
        $nullable = false;
        $branches = $schema['anyOf'] ?? $schema['oneOf'] ?? null;

        if (\is_array($branches) && !isset($schema['discriminator'])) {
            /** @var list<array<string, mixed>> $branches */
            $nonNull = \array_values(\array_filter(
                $branches,
                static fn(array $branch): bool => ($branch['type'] ?? null) !== 'null',
            ));
            $nullable = \count($nonNull) !== \count($branches);

            if (\count($nonNull) === 1) {
                $schema = $nonNull[0];
            } else {
                $variants = [];

                foreach ($nonNull as $branch) {
                    $ref = $branch['$ref'] ?? null;
                    $variants[] = \is_string($ref)
                        ? '\\Synchra\\Model\\' . Names::schemaClass(Spec::refName($ref))
                        : 'array';
                }

                $type = \implode('|', \array_unique($variants));

                return ['native' => $nullable || !$required ? $type . '|null' : $type];
            }
        }

        if (Spec::dig($schema, 'discriminator', 'propertyName') !== null) {
            $union = $this->unions->registerTagged($schema);
            $variants = \array_map(
                static fn(string $variant): string => '\\Synchra\\Model\\' . $variant,
                $this->unions->variants($union),
            );
            $type = \implode('|', $variants);

            return ['native' => $required && !$nullable ? $type : $type . '|null'];
        }

        $class = $this->types->modelClassFor($schema);

        if ($class !== null) {
            $type = '\\Synchra\\Model\\' . $class;

            return ['native' => $required && !$nullable ? $type : '?' . $type];
        }

        return ['native' => 'mixed'];
    }

    private function pathExpression(): string
    {
        $template = TypeMapper::literal($this->operation->relativePath());

        if ($this->pathEntries === []) {
            return $template;
        }

        return \sprintf('\\Synchra\\Http\\Path::expand(%s, [%s])', $template, \implode(', ', $this->pathEntries));
    }

    /**
     * The first of `$candidates` no parameter already uses, or the last one with a counter.
     */
    private function freeParameterName(string ...$candidates): string
    {
        $taken = \array_column($this->parameters, 'php');

        foreach ($candidates as $candidate) {
            if (!\in_array($candidate, $taken, true)) {
                return $candidate;
            }
        }

        $last = $candidates[\count($candidates) - 1];

        for ($suffix = 2; ; ++$suffix) {
            if (!\in_array($last . $suffix, $taken, true)) {
                return $last . $suffix;
            }
        }
    }

    private function queryExpression(): ?string
    {
        $fromObject = $this->queryClass === null
            ? null
            : \sprintf('...($%s?->toArray() ?? [])', $this->queryArgument);
        $explicit = $this->queryEntries;

        if ($fromObject === null && $explicit === []) {
            return null;
        }

        $parts = $fromObject === null ? $explicit : [$fromObject, ...$explicit];

        return '[' . \implode(', ', $parts) . ']';
    }

    private function headerExpression(): string
    {
        $literal = '[' . \implode(', ', $this->headerEntries) . ']';

        return $this->optionalHeaders ? \sprintf('self::headers(%s)', $literal) : $literal;
    }

    /**
     * @return array{native: string, expression: string, doc: string|null}
     */
    private function response(): array
    {
        [, $schema] = $this->operation->successResponse();

        if ($schema === null) {
            return ['native' => 'void', 'expression' => '', 'doc' => null];
        }

        return (new ResponseMapper($this->spec, $this->types, $this->unions))->map($schema);
    }

    private function returnDoc(): ?string
    {
        $response = $this->response();

        return $response['doc'] === null ? null : '@return ' . $response['doc'];
    }

    /**
     * Generated resources name classes in full, so a type coming from the shared mapper needs the
     * namespaces of its imports put back.
     *
     * @param list<string> $imports
     */
    private function qualify(string $type, array $imports = []): string
    {
        foreach ($imports as $fqcn) {
            $parts = \explode('\\', $fqcn);
            $short = \end($parts);
            $type = \preg_replace(
                '/(?<![\\\\\w])' . \preg_quote($short, '/') . '\b/',
                '\\\\' . $fqcn,
                $type,
            ) ?? $type;
        }

        return $type;
    }

    /** @param array<string, mixed> $parameter */
    private function describe(array $parameter): string
    {
        $description = $parameter['description'] ?? null;

        return \is_string($description) && $description !== '' ? \rtrim($description, '.') . '.' : '';
    }
}
