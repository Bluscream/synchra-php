<?php

declare(strict_types=1);

namespace Synchra\Generator;

/**
 * Emits one endpoint-group class per tag, plus the trait that hangs them off the facade.
 *
 * Generated resources refer to models by fully qualified name rather than importing them. It is
 * wordier to read, but the `Channel` tag and the `Channel` model would otherwise collide in the
 * same file, and an alias scheme is one more thing to get subtly wrong on every regeneration.
 */
final class ResourceGenerator
{
    /** @var array<string, string> Tag to class name. */
    private array $classes = [];

    public function __construct(
        private readonly Spec $spec,
        private readonly TypeMapper $types,
        private readonly UnionRegistry $unions,
        private readonly QueryGenerator $queries,
    ) {}

    public function emit(Emitter $emitter): void
    {
        $emitter->wipe('src/Resource');

        /** @var array<string, list<Operation>> $byTag */
        $byTag = [];

        foreach ($this->spec->operations as $operation) {
            $byTag[$operation->tag][] = $operation;
        }

        foreach ($byTag as $tag => $operations) {
            $class = Names::tagClass($tag);
            $this->classes[$tag] = $class;
            $emitter->write('src/Resource/' . $class . '.php', $this->renderResource($tag, $class, $operations));
        }

        $emitter->write('src/Resource/ResourceAccessors.php', $this->renderAccessors());
        $emitter->write('src/Resource/AbstractResource.php', $this->abstractResource());
    }

    public function count(): int
    {
        return \count($this->classes);
    }

    /** @param list<Operation> $operations */
    private function renderResource(string $tag, string $class, array $operations): string
    {
        $methods = [];
        $used = [];

        foreach ($operations as $operation) {
            $name = $operation->phpName();
            $candidate = $name;
            $suffix = 2;

            while (isset($used[$candidate])) {
                $candidate = $name . $suffix++;
            }

            $used[$candidate] = true;
            $methods[] = $this->renderMethod($operation, $candidate);
        }

        $doc = Emitter::docBlock([
            \sprintf('The `%s` endpoints.', $tag),
            '',
            \sprintf('Reach this group with `$synchra->%s()`.', Names::camel($class)),
        ]);

        $body = $doc . \sprintf(
            "final class %s extends AbstractResource\n{\n%s}\n",
            $class,
            \implode("\n", $methods),
        );

        return Emitter::file('Synchra\\Resource', [], $body);
    }

    private function renderMethod(Operation $operation, string $name): string
    {
        $signature = new MethodSignature($operation, $this->spec, $this->types, $this->unions, $this->queries);

        $doc = Emitter::docBlock($signature->docLines(), '    ');

        return $doc . \sprintf(
            "    public function %s(%s): %s\n    {\n%s\n    }\n",
            $name,
            $signature->parameterList(),
            $signature->returnType(),
            $signature->methodBody(),
        );
    }

    private function renderAccessors(): string
    {
        $methods = [];
        $docLines = ['Typed access to every endpoint group.', ''];

        foreach ($this->classes as $tag => $class) {
            $accessor = Names::camel($class);
            $docLines[] = \sprintf('@see %s for the `%s` endpoints.', $class, $tag);
            $methods[] = Emitter::docBlock([\sprintf('The `%s` endpoints.', $tag)], '    ')
                . \sprintf(
                    "    public function %s(): %s\n    {\n        return \$this->resource(%s::class);\n    }\n",
                    $accessor,
                    $class,
                    $class,
                );
        }

        $body = Emitter::docBlock($docLines)
            . \sprintf("trait ResourceAccessors\n{\n%s}\n", \implode("\n", $methods));

        return Emitter::file('Synchra\\Resource', [], $body);
    }

    /**
     * Rewritten on every run so the generated resources always have the base class they expect,
     * even in a fresh checkout where src/Resource was wiped.
     */
    private function abstractResource(): string
    {
        $body = Emitter::docBlock([
            'Base for the generated endpoint groups.',
            '',
            'Each subclass covers one tag of the API description and does nothing but describe',
            'requests — transport, authentication and error handling all live in the client.',
        ]) . <<<'PHP'
            abstract class AbstractResource
            {
                public function __construct(protected readonly ApiClient $client) {}

                /**
                 * The underlying client, for reaching an endpoint this package does not model yet.
                 */
                final public function client(): ApiClient
                {
                    return $this->client;
                }

                /**
                 * Drops the headers a caller left unset.
                 *
                 * @param array<string, string|null> $headers
                 *
                 * @return array<string, string>
                 */
                final protected static function headers(array $headers): array
                {
                    $out = [];

                    foreach ($headers as $name => $value) {
                        if ($value !== null) {
                            $out[$name] = $value;
                        }
                    }

                    return $out;
                }
            }
            PHP;

        return Emitter::file('Synchra\\Resource', ['Synchra\\Http\\ApiClient'], $body);
    }
}
