<?php

declare(strict_types=1);

namespace Synchra\Generator;

/**
 * Writes generated files, and removes the ones a previous run left behind.
 *
 * Wiping each generated directory before writing is what keeps a renamed or deleted endpoint from
 * lingering as a stale class that still compiles.
 */
final class Emitter
{
    private int $written = 0;

    public function __construct(private readonly string $root) {}

    public const HEADER = <<<'TXT'
        /*
         * This file is generated — do not edit it by hand.
         *
         * Source:    spec/openapi.json (and spec/websocket.md for the gateway)
         * Generator: tools/generate.php
         *
         * To pick up an API change: ./tools/fetch-spec.sh && composer generate
         */
        TXT;

    public function wipe(string $relativeDir): void
    {
        $dir = $this->root . '/' . \trim($relativeDir, '/');

        if (!\is_dir($dir)) {
            return;
        }

        foreach (\glob($dir . '/*.php') ?: [] as $file) {
            \unlink($file);
        }
    }

    public function write(string $relativePath, string $contents): void
    {
        $path = $this->root . '/' . \ltrim($relativePath, '/');
        $dir = \dirname($path);

        if (!\is_dir($dir) && !\mkdir($dir, 0o775, true) && !\is_dir($dir)) {
            throw new \RuntimeException("Could not create {$dir}.");
        }

        if (\file_put_contents($path, \rtrim($contents) . "\n") === false) {
            throw new \RuntimeException("Could not write {$path}.");
        }

        ++$this->written;
    }

    public function count(): int
    {
        return $this->written;
    }

    /**
     * Assembles a file from its namespace, imports and body.
     *
     * @param list<string> $imports Fully qualified names to import.
     */
    public static function file(string $namespace, array $imports, string $body): string
    {
        $imports = \array_values(\array_unique(\array_filter(
            $imports,
            static fn(string $fqcn): bool => $fqcn !== '' && !\str_starts_with($fqcn, '\\')
                && \implode('\\', \array_slice(\explode('\\', $fqcn), 0, -1)) !== $namespace,
        )));
        \sort($imports);

        $useLines = $imports === []
            ? ''
            : "\n" . \implode("\n", \array_map(static fn(string $i): string => "use {$i};", $imports)) . "\n";

        return \sprintf(
            "<?php\n\n%s\n\ndeclare(strict_types=1);\n\nnamespace %s;\n%s\n%s\n",
            self::HEADER,
            $namespace,
            $useLines,
            \rtrim($body),
        );
    }

    /**
     * Wraps prose into a docblock at the given indentation.
     *
     * @param list<string> $lines
     */
    public static function docBlock(array $lines, string $indent = ''): string
    {
        $lines = \array_values(\array_filter($lines, static fn(string $l): bool => $l !== "\0"));

        if ($lines === []) {
            return '';
        }

        $out = $indent . "/**\n";

        foreach ($lines as $line) {
            $out .= $line === '' ? $indent . " *\n" : $indent . ' * ' . $line . "\n";
        }

        return $out . $indent . " */\n";
    }
}
