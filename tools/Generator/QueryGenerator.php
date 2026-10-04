<?php

declare(strict_types=1);

namespace Synchra\Generator;

/**
 * Emits a filter object per endpoint that has optional query parameters.
 *
 * The alternative — one nullable method argument per parameter — gives methods with eleven
 * arguments, and a caller cannot tell `null, null, 50` apart at a glance. A small object keeps the
 * method signatures short and lets callers name only the filters they care about:
 * `new ChatMessagesQuery(perPage: 50, provider: Provider::Twitch)`.
 */
final class QueryGenerator
{
    /** @var array<string, string> Operation key to generated class name. */
    private array $classes = [];

    /** @var array<string, true> */
    private array $taken = [];

    public function __construct(private readonly TypeMapper $types) {}

    /**
     * Registers the filter object for an operation, returning its class name, or null when the
     * endpoint has no optional query parameters.
     */
    public function register(Operation $operation): ?string
    {
        $optional = $this->optionalParameters($operation);

        if ($optional === []) {
            return null;
        }

        $key = $operation->method . ' ' . $operation->path;

        if (isset($this->classes[$key])) {
            return $this->classes[$key];
        }

        $base = Names::pascal($operation->phpName());
        $base = \preg_replace('/^(Get|List|Fetch)/', '', $base) ?: $base;
        $name = $this->claim($base . 'Query', Names::tagClass($operation->tag) . $base . 'Query');

        return $this->classes[$key] = $name;
    }

    public function emit(Emitter $emitter, Spec $spec): void
    {
        $emitter->wipe('src/Query');

        foreach ($spec->operations as $operation) {
            $key = $operation->method . ' ' . $operation->path;
            $class = $this->classes[$key] ?? null;

            if ($class === null) {
                continue;
            }

            $emitter->write('src/Query/' . $class . '.php', $this->render($class, $operation));
        }
    }

    public function count(): int
    {
        return \count($this->classes);
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function optionalParameters(Operation $operation): array
    {
        return \array_values(\array_filter(
            $operation->queryParameters,
            static fn(array $parameter): bool => ($parameter['required'] ?? false) !== true,
        ));
    }

    private function claim(string $preferred, string $fallback): string
    {
        if (!isset($this->taken[$preferred])) {
            $this->taken[$preferred] = true;

            return $preferred;
        }

        $candidate = $fallback;
        $suffix = 2;

        while (isset($this->taken[$candidate])) {
            $candidate = $fallback . $suffix++;
        }

        $this->taken[$candidate] = true;

        return $candidate;
    }

    private function render(string $class, Operation $operation): string
    {
        $params = [];
        $docs = [];
        $entries = [];
        $imports = [];

        foreach ($this->optionalParameters($operation) as $parameter) {
            /** @var string $name */
            $name = $parameter['name'];
            /** @var array<string, mixed> $schema */
            $schema = $parameter['schema'] ?? [];
            $mapped = $this->types->map($schema, $name, false, $class, $name);
            $imports = [...$imports, ...$mapped->imports];

            $params[] = \sprintf('        public %s $%s = null,', \ltrim($mapped->native, '?'), $name);
            $docs[] = \sprintf('@param %s $%s%s', $mapped->doc, $name, $this->describe($parameter));
            $entries[] = \sprintf("            '%s' => \$this->%s,", \addcslashes($name, "'\\"), $name);
        }

        // Every property is nullable: null means "do not send this filter".
        $params = \array_map(
            static fn(string $line): string => \preg_replace('/public (\??)/', 'public ?', $line) ?? $line,
            $params,
        );

        $classDoc = Emitter::docBlock([
            \sprintf('Optional filters for `%s %s`.', $operation->method, $operation->path),
            '',
            'Every field defaults to null, which means the filter is not sent.',
        ]);

        $body = $classDoc . \sprintf(
            <<<'PHP'
                final readonly class %1$s implements \JsonSerializable
                {
                %2$s    public function __construct(
                %3$s
                    ) {}

                    /**
                     * @return array<string, mixed>
                     */
                    public function toArray(): array
                    {
                        return [
                %4$s
                        ];
                    }

                    /**
                     * @return array<string, mixed>
                     */
                    public function jsonSerialize(): array
                    {
                        return \array_filter($this->toArray(), static fn(mixed $v): bool => $v !== null);
                    }
                }
                PHP,
            $class,
            Emitter::docBlock($docs, '    '),
            \implode("\n", $params),
            \implode("\n", $entries),
        );

        return Emitter::file('Synchra\\Query', $imports, $body);
    }

    /** @param array<string, mixed> $parameter */
    private function describe(array $parameter): string
    {
        $description = $parameter['description'] ?? null;

        return \is_string($description) && $description !== '' ? ' ' . \rtrim($description, '.') . '.' : '';
    }
}
