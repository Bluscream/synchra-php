<?php

declare(strict_types=1);

namespace Synchra\Generator;

/**
 * Generates the realtime gateway's typed surface from `spec/websocket.md`.
 *
 * The gateway is documented separately from the OpenAPI description — it has its own reference
 * served at `/api/2/ws-docs` — so this reads the event table out of that document: which event
 * types exist, which key each one subscribes with, and which model its payload carries.
 */
final class GatewayGenerator
{
    /**
     * Payloads the gateway reference names but the OpenAPI description does not define. These are
     * hand-written from the documented examples in src/WebSocket/Payload.
     *
     * @var array<string, string>
     */
    private const PAYLOAD_OVERRIDES = [
        'KvEventData' => 'Synchra\\WebSocket\\Payload\\WidgetValue',
        'ChannelGiveawaysEventData' => 'Synchra\\WebSocket\\Payload\\GiveawayPointer',
        'QueueEvent' => 'Synchra\\WebSocket\\Payload\\QueueEvent',
    ];

    /** @var list<array{type: string, keys: list<string>, payload: list<string>, list: bool, description: string}> */
    private array $events = [];

    public function __construct(
        private readonly Spec $spec,
        private readonly UnionRegistry $unions,
    ) {}

    public function parse(string $markdown): void
    {
        $this->events = [];

        foreach ($this->eventTable($markdown) as $type => $keys) {
            $section = $this->section($markdown, $type);
            [$payload, $isList] = $this->payloadOf($section);

            $this->events[] = [
                'type' => $type,
                'keys' => $keys,
                'payload' => $payload,
                'list' => $isList,
                'description' => $this->descriptionOf($section),
            ];
        }

        if ($this->events === []) {
            throw new \RuntimeException('Found no event types in spec/websocket.md.');
        }
    }

    public function emit(Emitter $emitter): void
    {
        $emitter->write('src/WebSocket/EventType.php', $this->renderEventType());
        $emitter->write('src/WebSocket/EventPayloads.php', $this->renderPayloads());
        $emitter->write('src/WebSocket/Subscriptions.php', $this->renderSubscriptions());
    }

    public function count(): int
    {
        return \count($this->events);
    }

    /**
     * @return array<string, list<string>>
     */
    private function eventTable(string $markdown): array
    {
        if (\preg_match('/## Event Types\n\n\|[^\n]*\n\|[^\n]*\n((?:\|[^\n]*\n)+)/', $markdown, $matches) !== 1) {
            throw new \RuntimeException('Could not find the Event Types table in spec/websocket.md.');
        }

        $out = [];

        foreach (\explode("\n", \trim($matches[1])) as $line) {
            $cells = \array_map('trim', \explode('|', \trim($line, "| \t")));

            if (\count($cells) < 2) {
                continue;
            }

            $type = \trim($cells[0], '`');
            $keys = [];

            foreach (\explode(',', $cells[1]) as $key) {
                $key = \trim(\trim($key), '`');

                if ($key !== '') {
                    $keys[] = $key;
                }
            }

            $out[$type] = $keys;
        }

        return $out;
    }

    private function section(string $markdown, string $type): string
    {
        $pattern = '/\n## `' . \preg_quote($type, '/') . "`\n(.*?)(?=\n## `|\\z)/s";

        if (\preg_match($pattern, $markdown, $matches) !== 1) {
            throw new \RuntimeException("No section for the \"{$type}\" event in spec/websocket.md.");
        }

        return $matches[1];
    }

    /**
     * @return array{list<string>, bool}
     */
    private function payloadOf(string $section): array
    {
        if (\preg_match('/\n\| `data` \| ([^|]+)\|/', $section, $matches) !== 1) {
            return [[], false];
        }

        $cell = \trim($matches[1]);
        \preg_match_all('/`([^`]+)`/', $cell, $names);

        $payload = \array_values(\array_filter(
            $names[1],
            static fn(string $name): bool => !\in_array($name, ['any', 'null', 'string', 'object'], true),
        ));

        return [$payload, \str_contains($cell, '[]')];
    }

    private function descriptionOf(string $section): string
    {
        $firstLine = \trim(\explode("\n", \trim($section))[0]);

        return \str_starts_with($firstLine, '#') || \str_starts_with($firstLine, '|') ? '' : $firstLine;
    }

    private function renderEventType(): string
    {
        $cases = [];

        foreach ($this->events as $event) {
            $doc = $event['description'] === ''
                ? ''
                : Emitter::docBlock([\rtrim($event['description'], '.') . '. Subscribe with `' . \implode('`, `', $event['keys']) . '`.'], '    ');
            $cases[] = $doc . \sprintf("    case %s = '%s';", Names::pascal($event['type']), $event['type']);
        }

        $body = Emitter::docBlock([
            'Event types the realtime gateway can push.',
            '',
            'The `ok` acknowledgement and `error` frames are not listed here — they are answers to a',
            'command rather than subscribable events; see Event::isAcknowledgement() and',
            'Event::isError().',
        ]) . \sprintf("enum EventType: string\n{\n%s\n}\n", \implode("\n\n", $cases));

        return Emitter::file('Synchra\\WebSocket', [], $body);
    }

    private function renderPayloads(): string
    {
        $arms = [];
        $imports = ['Synchra\\Serialization\\DataModel'];

        foreach ($this->events as $event) {
            $expression = $this->hydrationFor($event, $imports);

            if ($expression === null) {
                continue;
            }

            $arms[] = \sprintf("            '%s' => %s,", $event['type'], $expression);
        }

        $body = Emitter::docBlock([
            'Maps a gateway event onto the model its payload carries.',
            '',
            'Event types whose payload the API description does not define return null; read those',
            'with Event::dataObject() instead.',
        ]) . \sprintf(
            <<<'PHP'
                final class EventPayloads
                {
                    /**
                     * @return DataModel|list<DataModel>|null
                     */
                    public static function hydrate(Event $event): DataModel|array|null
                    {
                        return match ($event->type) {
                %s
                            default => null,
                        };
                    }
                }
                PHP,
            \implode("\n", $arms),
        );

        return Emitter::file('Synchra\\WebSocket', $imports, $body);
    }

    /**
     * @param array{type: string, keys: list<string>, payload: list<string>, list: bool, description: string} $event
     * @param list<string> $imports
     */
    private function hydrationFor(array $event, array &$imports): ?string
    {
        if ($event['payload'] === []) {
            return null;
        }

        if (\count($event['payload']) > 1) {
            // The gateway sends the same tagged union the REST endpoints do, so reuse its resolver.
            $union = $this->matchingUnion($event['payload']);

            if ($union === null) {
                return null;
            }

            $imports[] = 'Synchra\\Model\\Union\\' . $union;

            return \sprintf('%s::fromArray($event->dataObject())', $union);
        }

        $name = $event['payload'][0];
        $class = self::PAYLOAD_OVERRIDES[$name] ?? null;

        if ($class === null) {
            if (!$this->spec->isObjectSchema($name)) {
                return null;
            }

            $class = 'Synchra\\Model\\' . Names::schemaClass($name);
        }

        $imports[] = $class;
        $parts = \explode('\\', $class);
        $short = \end($parts);

        return $event['list']
            ? \sprintf('\array_map(%s::fromArray(...), $event->dataObjects())', $short)
            : \sprintf('%s::fromArray($event->dataObject())', $short);
    }

    /**
     * Finds the already-registered union whose variants are exactly this payload list.
     *
     * @param list<string> $payload
     */
    private function matchingUnion(array $payload): ?string
    {
        $wanted = \array_map(static fn(string $name): string => Names::schemaClass($name), $payload);
        \sort($wanted);

        foreach ($this->unions->names() as $union) {
            $variants = $this->unions->variants($union);
            \sort($variants);

            if ($variants === $wanted) {
                return $union;
            }
        }

        return null;
    }

    private function renderSubscriptions(): string
    {
        $methods = [];

        foreach ($this->events as $event) {
            $name = Names::pascal($event['type']);
            $params = [];
            $entries = [];

            foreach ($event['keys'] as $key) {
                $php = Names::camel($key);
                $params[] = 'string $' . $php;
                $entries[] = \sprintf("'%s' => \$%s", $key, $php);
            }

            $keyList = '[' . \implode(', ', $entries) . ']';
            $description = $event['description'] === '' ? \sprintf('`%s` events.', $event['type']) : \rtrim($event['description'], '.') . '.';

            $methods[] = Emitter::docBlock(["Subscribes to {$description}"], '    ')
                . \sprintf(
                    "    public function subscribe%s(%s, ?string \$nonce = null): self\n    {\n        return \$this->subscribe(EventType::%s, %s, \$nonce);\n    }\n",
                    $name,
                    \implode(', ', $params),
                    $name,
                    $keyList,
                );

            $methods[] = Emitter::docBlock(["Stops receiving {$description}"], '    ')
                . \sprintf(
                    "    public function unsubscribe%s(%s): self\n    {\n        return \$this->unsubscribe(EventType::%s, %s);\n    }\n",
                    $name,
                    \implode(', ', $params),
                    $name,
                    $keyList,
                );
        }

        $body = Emitter::docBlock([
            'Typed subscribe and unsubscribe calls, one pair per event type.',
            '',
            'These only spell out the subscription key each event needs; EventStream::subscribe()',
            'takes the same thing untyped if the gateway gains an event before this is regenerated.',
        ]) . \sprintf(
            <<<'PHP'
                trait Subscriptions
                {
                    /**
                     * @param array<string, string> $data
                     */
                    abstract public function subscribe(EventType|string $type, array $data, ?string $nonce = null): self;

                    /**
                     * @param array<string, string> $data
                     */
                    abstract public function unsubscribe(EventType|string $type, array $data): self;

                %s}
                PHP,
            \implode("\n", $methods),
        );

        return Emitter::file('Synchra\\WebSocket', [], $body);
    }
}
