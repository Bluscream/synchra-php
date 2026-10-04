<?php

declare(strict_types=1);

namespace Synchra\Tests\Unit;

use PHPUnit\Framework\TestCase;

/**
 * Keeps hand-written files inside the size limits this project works to.
 *
 * Generated files are exempt: their length is a property of the API surface, not of anyone's
 * judgement, and splitting a 400-method resource class would make it harder to read rather than
 * easier. Every exemption below is therefore a file carrying the generator's own header.
 */
final class SourceLimitsTest extends TestCase
{
    private const SOFT_LIMIT = 400;
    private const HARD_LIMIT = 600;
    private const FUNCTION_LIMIT = 100;

    /**
     * Files that are over the soft limit on purpose, with the reason.
     *
     * A file listed here still has to stay under the hard limit; this only records that the extra
     * length was a decision rather than drift.
     */
    private const ACCEPTED = [
        // One method per JSON type, each a handful of lines. Splitting by type would scatter the
        // hydration rules across files that always change together.
        'src/Serialization/Reader.php' => 'one reader method per JSON type',

        // The union mapping recurses back into the general mapping — describeBranches() calls
        // map() — so moving it out would make the two halves depend on each other in both
        // directions, which is worse than one longer file.
        'tools/Generator/TypeMapper.php' => 'union mapping recurses into the general mapping',

        // parameterList(), docLines() and the request-building expressions all read the same
        // collected parameter state. Splitting it would mean threading that state through a
        // separate object for no gain in clarity.
        'tools/Generator/MethodSignature.php' => 'one operation\'s parameters, read by three renderers',
    ];

    /** @return iterable<string, array{string, string}> */
    public static function handWrittenFiles(): iterable
    {
        $root = \dirname(__DIR__, 2);
        $directories = [$root . '/src', $root . '/tools', $root . '/tests'];

        foreach ($directories as $directory) {
            $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($directory));

            foreach ($iterator as $file) {
                if (!$file instanceof \SplFileInfo || $file->getExtension() !== 'php') {
                    continue;
                }

                $path = $file->getPathname();
                $contents = \file_get_contents($path);

                if ($contents === false || \str_contains($contents, 'This file is generated')) {
                    continue;
                }

                $relative = \substr($path, \strlen($root) + 1);

                yield $relative => [$relative, $contents];
            }
        }
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('handWrittenFiles')]
    public function testAFileStaysUnderTheHardLimit(string $relative, string $contents): void
    {
        $lines = \substr_count($contents, "\n");

        self::assertLessThanOrEqual(
            self::HARD_LIMIT,
            $lines,
            "{$relative} is {$lines} lines; split it rather than letting it grow.",
        );
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('handWrittenFiles')]
    public function testAFileOverTheSoftLimitIsAnAcknowledgedException(string $relative, string $contents): void
    {
        $lines = \substr_count($contents, "\n");

        if ($lines <= self::SOFT_LIMIT) {
            self::assertArrayNotHasKey(
                $relative,
                self::ACCEPTED,
                "{$relative} is back under {$lines} lines; drop its entry from ACCEPTED.",
            );

            return;
        }

        $soft = self::SOFT_LIMIT;

        self::assertArrayHasKey(
            $relative,
            self::ACCEPTED,
            "{$relative} is {$lines} lines, over the {$soft}-line soft limit. Split it, or record why not in ACCEPTED.",
        );
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('handWrittenFiles')]
    public function testNoFunctionRunsPastTheLineLimit(string $relative, string $contents): void
    {
        $tooLong = [];

        foreach (self::functionLengths($contents) as $name => $length) {
            if ($length > self::FUNCTION_LIMIT) {
                $tooLong[] = "{$name}() is {$length} lines";
            }
        }

        self::assertSame([], $tooLong, "Functions in {$relative} past the line limit.");
    }

    /**
     * Measures every named function body, in lines from `function` to its closing brace.
     *
     * Counting braces in the raw text would be wrong — a `{` inside a string literal or a comment
     * looks exactly like a block opener — so this walks PHP's own token stream, where a brace
     * token is only ever a real brace.
     *
     * @return array<string, int>
     */
    private static function functionLengths(string $contents): array
    {
        $tokens = \PhpToken::tokenize($contents);
        $lengths = [];
        $count = \count($tokens);

        for ($index = 0; $index < $count; ++$index) {
            if (!$tokens[$index]->is(\T_FUNCTION)) {
                continue;
            }

            $name = self::functionName($tokens, $index);

            if ($name === null) {
                continue;
            }

            $end = self::bodyEndLine($tokens, $index);

            if ($end !== null) {
                $lengths[$name] = $end - $tokens[$index]->line + 1;
            }
        }

        return $lengths;
    }

    /**
     * The name of the function declared at `$index`, or null for an anonymous one.
     *
     * @param array<array-key, \PhpToken> $tokens
     */
    private static function functionName(array $tokens, int $index): ?string
    {
        for ($i = $index + 1, $count = \count($tokens); $i < $count; ++$i) {
            if ($tokens[$i]->text === '(') {
                return null;
            }

            if ($tokens[$i]->is(\T_STRING)) {
                return $tokens[$i]->text;
            }
        }

        return null;
    }

    /**
     * The line of the closing brace of the body, or null when there is no body — an interface or
     * abstract method ends at a semicolon.
     *
     * @param array<array-key, \PhpToken> $tokens
     */
    private static function bodyEndLine(array $tokens, int $index): ?int
    {
        $depth = 0;

        for ($i = $index, $count = \count($tokens); $i < $count; ++$i) {
            $text = $tokens[$i]->text;

            if ($depth === 0 && $text === ';') {
                return null;
            }

            if ($text === '{') {
                ++$depth;
            } elseif ($text === '}') {
                --$depth;

                if ($depth === 0) {
                    return $tokens[$i]->line;
                }
            }
        }

        return null;
    }
}
