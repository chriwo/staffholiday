<?php
defined('TYPO3_MODE') || die();

use ChriWo\Staffholiday\Domain\Model\Log;

$model = 'tx_staffholiday_domain_model_log';
$languageFile = 'LLL:EXT:staffholiday/Resources/Private/Language/locallang_db.xlf:' . $model;

return [
    'ctrl' => [
        'title' => $languageFile,
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'dividers2tabs' => true,
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
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'sys_language',
                'foreign_table_where' => 'ORDER BY sys_language.title',
                'items' => [
                    ['LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.allLanguages', -1],
                    ['LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.default_value', 0],
                ],
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
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
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime',
                'default' => 0,
                'range' => [
                    'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y')),
                ]
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime',
                'default' => 0,
                'range' => [
                    'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y')),
                ]
            ],
        ],
        'title' => [
            'exclude' => false,
            'label' => $languageFile . '.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
            ],
        ],
        'crdate' => [
            'label' => $languageFile . '.crdate',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime',
                'readOnly' => 1,
            ],
        ],
        'state' => [
            'exclude' => false,
            'label' => $languageFile . '.state',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    [$languageFile . '.state.100', '--div--'],
                    [$languageFile . '.state.101', Log::STATUS_NEWPLAN],
                    [$languageFile . '.state.102', Log::STATUS_PLANCONFIRMEDADMIN],
                    [$languageFile . '.state.103', Log::STATUS_PLANREFUSEDUSER],
                    [$languageFile . '.state.104', Log::STATUS_PLANREFUSEDADMIN],
                    [$languageFile . '.state.105', Log::STATUS_PLANREQUEST],
                    [$languageFile . '.state.200', '--div--'],
                    [$languageFile . '.state.201', Log::STATUS_PLANUPDATED],
                    [$languageFile . '.state.300', '--div--'],
                    [$languageFile . '.state.301', Log::STATUS_PLANDELETED],
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
