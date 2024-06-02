<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->exclude('vendor')
    ->in(__DIR__)
;

return (new Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,
        'multiline_comment_opening_closing' => true, // @PhpCsFixer default
        'comment_to_phpdoc' => [
            'ignored_tags' => [],
        ], // @PhpCsFixer:risky default
        'concat_space' => [
            'spacing' => 'one',
        ], // overrides @Symfony defaults
        'single_line_throw' => false, // overrides @Symfony defaults
        'trailing_comma_in_multiline' => [
            'after_heredoc' => true,
            'elements' => [
                'arguments',
                'arrays',
                'match',
                'parameters',
            ],
        ], // overrides @Symfony defaults
    ])
    ->setFinder($finder)
;
