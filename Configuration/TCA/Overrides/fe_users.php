<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

$feUsersColumns['tx_staffholiday_plan'] = [
    'exclude' => 1,
    'label' => 'LLL:EXT:staffholiday/Resources/Private/Language/locallang_db.xlf:fe_users.holiday_plan',
    'config' => [
        'type' => 'inline',
        'foreign_table' => 'tx_staffholiday_domain_model_plan',
        'foreign_field' => 'user',
        'maxitems' => 1000,
        'minitems' => 0,
        'appearance' => [
            'collapseAll' => 1,
            'expandSingle' => 1,
        ],
    ],
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('fe_users', $feUsersColumns);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'fe_users',
    '--div--;LLL:EXT:staffholiday/Resources/Private/Language/locallang_db.xlf:fe_users.tab, tx_staffholiday_plan,'
);
