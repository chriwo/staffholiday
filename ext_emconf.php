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
    'version' => '2.0.1-dev',
    'constraints' => [
        'depends' => [
            'typo3' => '8.7.0-9.99.99',
            'felogin' => '8.7.0-9.5.99',
            'php' => '7.0.0-7.2.99',
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
