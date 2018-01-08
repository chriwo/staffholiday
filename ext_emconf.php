<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Staff holiday',
    'description' => 'TYPO3 extension for the planning of holidays for employees',
    'category' => 'plugin',
    'author' => 'Christian Wolfram',
    'author_email' => 'c.wolfram@chriwo.de',
    'state' => 'stable',
    'internal' => '',
    'uploadfolder' => '',
    'createDirs' => '',
    'clearCacheOnLoad' => true,
    'modify_tables' => '',
    'version' => '1.0.1',
    'constraints' => [
        'depends' => [
            'typo3' => '7.6.0-8.7.99',
            'php' => '5.6.0-7.0.99',
        ],
        'conflicts' => [
        ],
        'suggests' => [
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'ChriWo\\Staffholiday\\' => 'Classes',
        ],
    ],
];
