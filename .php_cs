<?php

return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules(array(
        '@Symfony' => true,
        'array_syntax' => ['syntax' => 'short'],
        'ordered_imports' => true,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'implode_call' => true,
        'phpdoc_add_missing_param_annotation' => true,
        'concat_space' => ['spacing' => 'one'],
        'blank_line_before_statement' => false,
        'phpdoc_separation' => false,
        'phpdoc_align' => false,
        'phpdoc_summary' => false,
        'single_trait_insert_per_statement' => false,
        'yoda_style' => null,
        'method_chaining_indentation' => true,
        'array_indentation' => true,
        'binary_operator_spaces' => [
            'operators' => ['=>' => 'align_single_space_minimal']
        ]
    ))
    ->setIndent('    ')
    ->setLineEnding(PHP_EOL)
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->exclude('vendor')
            ->exclude('thinkphp')
            ->exclude('runtime')
            ->in(__DIR__)
    );