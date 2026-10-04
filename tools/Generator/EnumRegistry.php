<?php

declare(strict_types=1);

namespace Synchra\Generator;

/**
 * Collects every closed value set in the description and gives each one a PHP enum.
 *
 * Most of these are inline in the description rather than named schemas — the provider list
 * appears at 27 different call sites — so they are keyed by their values. Two fields with the same
 * value set share one enum, which is what makes `Provider` a single type instead of 27.
 */
final class EnumRegistry
{
    /** @var array<string, array{name: string, type: string, values: list<string|int>, titles: list<string>, owner: string}> */
    private array $byKey = [];

    /** @var array<string, string> Assigned class name to the key that owns it. */
    private array $takenNames = [];

    /**
     * Claims a class name for every enum the description names, before anything inline is mapped.
     *
     * Named schemas have to win the race for their own name: if an inline field carrying the same
     * value set were mapped first it would claim `ActivityCountCurrencyType`, and the `$ref` to
     * `CurrencyType` would then point at a class that was never written.
     */
    public function registerNamed(Spec $spec): void
    {
        foreach ($spec->schemas as $name => $schema) {
            if (isset($schema['enum'])) {
                $this->register($schema, $name, 'value', Names::schemaClass($name));
            }
        }
    }

    /**
     * Registers an enum schema and returns the PHP class name for it.
     *
     * @param array<string, mixed> $schema
     * @param ?string $preferred Class name to use when this value set has not been seen yet.
     */
    public function register(array $schema, string $owner, string $property, ?string $preferred = null): string
    {
        /** @var list<string|int> $values */
        $values = $schema['enum'];
        $type = \is_int($values[0] ?? null) ? 'int' : 'string';
        $key = $type . ':' . \json_encode($values);

        if (isset($this->byKey[$key])) {
            $title = \is_string($schema['title'] ?? null) ? $schema['title'] : '';

            if ($title !== '' && !\in_array($title, $this->byKey[$key]['titles'], true)) {
                $this->byKey[$key]['titles'][] = $title;
            }

            return $this->byKey[$key]['name'];
        }

        $name = $this->chooseName($schema, $owner, $property, $key, $preferred);

        $this->byKey[$key] = [
            'name' => $name,
            'type' => $type,
            'values' => $values,
            'titles' => \is_string($schema['title'] ?? null) && $schema['title'] !== '' ? [$schema['title']] : [],
            'owner' => $owner,
        ];

        return $name;
    }

    public function emit(Emitter $emitter): void
    {
        $emitter->wipe('src/Enum');

        foreach ($this->byKey as $enum) {
            $emitter->write('src/Enum/' . $enum['name'] . '.php', $this->render($enum));
        }
    }

    public function count(): int
    {
        return \count($this->byKey);
    }

    /** @param array<string, mixed> $schema */
    private function chooseName(
        array $schema,
        string $owner,
        string $property,
        string $key,
        ?string $preferred = null,
    ): string {
        $title = \is_string($schema['title'] ?? null) ? $schema['title'] : '';
        $candidates = [];

        if ($preferred !== null) {
            $candidates[] = $preferred;
        }

        if ($title !== '') {
            $candidates[] = Names::pascal($title);
            // Qualify with the owning schema when the bare title is already in use for a
            // different value set — several unrelated fields are titled just "Type".
            $candidates[] = Names::pascal($owner . ' ' . $title);
        }

        $candidates[] = Names::pascal($owner . ' ' . $property);

        foreach ($candidates as $candidate) {
            if (!isset($this->takenNames[$candidate])) {
                $this->takenNames[$candidate] = $key;

                return $candidate;
            }
        }

        $base = $candidates[\count($candidates) - 1];
        $suffix = 2;

        while (isset($this->takenNames[$base . $suffix])) {
            ++$suffix;
        }

        $this->takenNames[$base . $suffix] = $key;

        return $base . $suffix;
    }

    /** @param array{name: string, type: string, values: list<string|int>, titles: list<string>, owner: string} $enum */
    private function render(array $enum): string
    {
        $doc = ['Values the API accepts for ' . $this->describe($enum) . '.'];
        $cases = [];
        $used = [];

        foreach ($enum['values'] as $value) {
            $case = Names::enumCase($value);
            $candidate = $case;
            $n = 2;

            while (isset($used[$candidate])) {
                $candidate = $case . $n++;
            }

            $used[$candidate] = true;
            $literal = \is_int($value) ? (string) $value : "'" . \str_replace("'", "\\'", $value) . "'";
            $cases[] = "    case {$candidate} = {$literal};";
        }

        $body = Emitter::docBlock($doc)
            . \sprintf("enum %s: %s\n{\n%s\n}\n", $enum['name'], $enum['type'], \implode("\n", $cases));

        return Emitter::file('Synchra\\Enum', [], $body);
    }

    /** @param array{name: string, type: string, values: list<string|int>, titles: list<string>, owner: string} $enum */
    private function describe(array $enum): string
    {
        if ($enum['titles'] !== []) {
            return '`' . \implode('` / `', \array_slice($enum['titles'], 0, 3)) . '`';
        }

        return $enum['owner'];
    }
}
