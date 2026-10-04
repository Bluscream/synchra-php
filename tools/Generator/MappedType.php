<?php

declare(strict_types=1);

namespace Synchra\Generator;

/**
 * How one schema is expressed in PHP: its native type, its docblock type, the call that reads it,
 * and whether a null value has to stay on the wire.
 */
final readonly class MappedType
{
    /**
     * @param string $native The native PHP type, already including `?` where nullable.
     * @param string $doc The docblock type. Equal to `$native` unless the native type is wider —
     *                    `array` carrying `list<Activity>`, or `mixed` carrying a union.
     * @param string $reader The expression that reads this field from a `$reader`.
     * @param list<string> $imports Fully qualified names the generated file must import.
     * @param bool $nullable Whether the schema allows null, which means null must be sent rather
     *                       than omitted.
     * @param string|null $default A PHP literal to default the constructor parameter to.
     * @param string $note Prose for the docblock, for shapes the reader cannot prove. A `@param`
     *                     that claims more than the reader returns is a claim static analysis has
     *                     to take on trust, so an open union is documented in words instead.
     */
    public function __construct(
        public string $native,
        public string $doc,
        public string $reader,
        public array $imports = [],
        public bool $nullable = false,
        public ?string $default = null,
        public string $note = '',
    ) {}

    public function withDefault(string $literal): self
    {
        return new self(
            $this->native,
            $this->doc,
            $this->reader,
            $this->imports,
            $this->nullable,
            $literal,
            $this->note,
        );
    }

    /**
     * Whether the docblock says more than the native type does.
     */
    public function needsDocType(): bool
    {
        return $this->doc !== $this->native;
    }
}
