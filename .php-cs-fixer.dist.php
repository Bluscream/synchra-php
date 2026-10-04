<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in([__DIR__ . '/src', __DIR__ . '/tests', __DIR__ . '/tools', __DIR__ . '/examples'])
    ->name('*.php');

$config = (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@PER-CS2.0' => true,
        '@PHP82Migration' => true,
        'declare_strict_types' => true,
        'strict_param' => true,
        'strict_comparison' => true,
        'global_namespace_import' => ['import_classes' => false, 'import_functions' => false],
        'no_unused_imports' => true,
        'ordered_imports' => ['sort_algorithm' => 'alpha'],
        'php_unit_test_case_static_method_calls' => ['call_type' => 'self'],
        'single_line_throw' => false,
    ])
    ->setFinder($finder);

// The package supports PHP 8.2 upwards, so running the fixer on a newer runtime is expected and
// not something to warn about on every invocation.
if (\method_exists($config, 'setUnsupportedPhpVersionAllowed')) {
    $config->setUnsupportedPhpVersionAllowed(true);
}

return $config;
