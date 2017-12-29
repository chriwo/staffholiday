<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'ChriWo.staffholiday',
    'Pi1',
    [
        'Holiday' => 'list',
        'New' => 'new,create,confirmCreateRequest',
    ],
    [
        'Holiday' => 'list',
        'New' => 'new,create,confirmCreateRequest',
    ]
);
