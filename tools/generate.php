<?php

declare(strict_types=1);

/*
 * Builds the generated layer of the SDK from the vendored API description.
 *
 * Run it with `composer generate` after `./tools/fetch-spec.sh`. Everything it writes is listed in
 * the summary it prints; nothing outside those directories is touched.
 */

namespace Synchra\Generator;

require __DIR__ . '/../vendor/autoload.php';

$root = \dirname(__DIR__);

$spec = Spec::fromFile($root . '/spec/openapi.json');
$websocket = \file_get_contents($root . '/spec/websocket.md');

if ($websocket === false) {
    \fwrite(\STDERR, "Could not read spec/websocket.md.\n");

    exit(1);
}

$emitter = new Emitter($root);
$enums = new EnumRegistry();
$unions = new UnionRegistry();
$types = new TypeMapper($spec, $enums, $unions);
$queries = new QueryGenerator($types);

$models = new ModelGenerator($spec, $types);
$resources = new ResourceGenerator($spec, $types, $unions, $queries);
$gateway = new GatewayGenerator($spec, $unions);

$enums->registerNamed($spec);

// Models and resources are rendered first because rendering them is what discovers the inline
// enums and unions the description never named.
$models->emit($emitter);
$resources->emit($emitter);
$queries->emit($emitter, $spec);
$enums->emit($emitter);
$unions->emit($emitter);

$gateway->parse($websocket);
$gateway->emit($emitter);

$operations = \count($spec->operations);

\printf(
    "Generated %d files from spec/openapi.json:\n"
    . "  %3d models        src/Model\n"
    . "  %3d enums         src/Enum\n"
    . "  %3d unions        src/Model/Union\n"
    . "  %3d filter objects src/Query\n"
    . "  %3d endpoint groups covering %d operations   src/Resource\n"
    . "  %3d gateway event types                      src/WebSocket\n",
    $emitter->count(),
    $models->count(),
    $enums->count(),
    $unions->count(),
    $queries->count(),
    $resources->count(),
    $operations,
    $gateway->count(),
);
