<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

$boot = function ($extensionKey) {
    foreach (['plan', 'log'] as $table) {
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages(
            'tx_staffholiday_domain_model_' . $table
        );
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
            'tx_staffholiday_domain_model_' . $table,
            'EXT:staffholiday/Resources/Private/Language/locallang_csh_' . $table . '.xlf'
        );
    }
};

$boot($_EXTKEY);
unset($boot);
