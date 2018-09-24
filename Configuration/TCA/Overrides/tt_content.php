<?php
defined('TYPO3_MODE') || die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'ChriWo.staffholiday',
    'Pi1',
    'LLL:EXT:staffholiday/Resources/Private/Language/locallang_flexform.xlf:plugin.title'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['staffholiday_pi1'] =
    'recursive,select_key,pages';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['staffholiday_pi1'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'staffholiday_pi1',
    'FILE:EXT:staffholiday/Configuration/FlexForms/flexform_staffholiday.xml'
);

// TypoScript
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'staffholiday',
    'Configuration/TypoScript',
    'Staff Holiday'
);
