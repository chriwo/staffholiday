<?php
use ChriWo\Staffholiday\Domain\Model\Log;

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

$llDb = 'LLL:EXT:staffholiday/Resources/Private/Language/locallang_db.xlf:';
$model = 'tx_staffholiday_domain_model_log';

return [
    'ctrl' => [
        'title' => $llDb . $model,
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'dividers2tabs' => true,
        'versioningWS' => 2,
        'versioning_followPages' => true,
        'origUid' => 't3_origuid',
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'default_sortby' => 'ORDER BY crdate DESC',
        'hideTable' => true,
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'title',
        'iconfile' => 'EXT:staffholiday/Resources/Public/Icons/' . $model . '.svg',
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, crdate, state, plan',
    ],
    'types' => [
        '1' => [
            'showitem' => 'title, crdate, state, plan, ' .
                '--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,sys_language_uid, ' .
                'l10n_parent, l10n_diffsource, hidden, starttime, endtime',
        ],
    ],
    'palettes' => [
        '1' => ['showitem' => ''],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'sys_language',
                'foreign_table_where' => 'ORDER BY sys_language.title',
                'items' => [
                    ['LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1],
                    ['LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0],
                ],
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_staffholiday_domain_model_log',
                'foreign_table_where' => 'AND tx_staffholiday_domain_model_log.pid = ###CURRENT_PID### AND ' .
                    'tx_staffholiday_domain_model_log.sys_language_uid IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label' => [
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ],
        ],
        'hidden' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
            ],
        ],
        'starttime' => [
            'exclude' => 1,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'max' => 20,
                'eval' => 'datetime',
                'checkbox' => 0,
                'default' => 0,
                'range' => [
                    'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y')),
                ],
            ],
        ],
        'endtime' => [
            'exclude' => 1,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'max' => 20,
                'eval' => 'datetime',
                'checkbox' => 0,
                'default' => 0,
                'range' => [
                    'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y')),
                ],
            ],
        ],
        'title' => [
            'exclude' => 0,
            'label' => $llDb .
                'tx_staffholiday_domain_model_log.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
            ],
        ],
        'crdate' => [
            'label' => $llDb .
                'tx_staffholiday_domain_model_log.crdate',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'datetime',
                'readOnly' => 1,
            ],
        ],
        'state' => [
            'exclude' => 0,
            'label' => $llDb .
                'tx_staffholiday_domain_model_log.state',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    [$llDb . 'tx_staffholiday_domain_model_log.state.100', '--div--'],
                    [$llDb . 'tx_staffholiday_domain_model_log.state.101', Log::STATUS_NEWPLAN],
                    [$llDb . 'tx_staffholiday_domain_model_log.state.102', Log::STATUS_PLANCONFIRMEDADMIN],
                    [$llDb . 'tx_staffholiday_domain_model_log.state.103', Log::STATUS_PLANREFUSEDUSER],
                    [$llDb . 'tx_staffholiday_domain_model_log.state.104', Log::STATUS_PLANREFUSEDADMIN],
                    [$llDb . 'tx_staffholiday_domain_model_log.state.105', Log::STATUS_PLANREQUEST],
                    [$llDb . 'tx_staffholiday_domain_model_log.state.200', '--div--'],
                    [$llDb . 'tx_staffholiday_domain_model_log.state.201', Log::STATUS_PLANUPDATED],
                    [$llDb . 'tx_staffholiday_domain_model_log.state.300', '--div--'],
                    [$llDb . 'tx_staffholiday_domain_model_log.state.301', Log::STATUS_PLANDELETED],
                ],
                'size' => 1,
                'maxitems' => 1,
            ],
        ],
        'plan' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
    ],
];
