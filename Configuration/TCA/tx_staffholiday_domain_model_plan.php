<?php
defined('TYPO3_MODE') || die();

use ChriWo\Staffholiday\Domain\Model\Plan;

$extConfiguration = \ChriWo\Staffholiday\Utility\EmConfigurationUtility::getSettings();
$model = 'tx_staffholiday_domain_model_plan';
$languageFile = 'LLL:EXT:staffholiday/Resources/Private/Language/locallang_db.xlf:' . $model;

$planColumns = [
    'ctrl' => [
        'title' => $languageFile,
        'label' => 'holiday_begin',
        'label_alt' => 'holiday_end, user',
        'label_alt_force' => true,
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
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'hideTable' => $extConfiguration->isHideHolidayPlanTable(),
        'searchFields' => 'title',
        'iconfile' => 'EXT:staffholiday/Resources/Public/Icons/' . $model . '.svg',
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, crdate, state, user',
    ],
    'types' => [
        '1' => [
            'showitem' => 'l10n_parent, l10n_diffsource, user,' .
                '--palette--;;paletteStatus,' .
                '--palette--;;paletteDates,notice,' .
                '--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,' .
                '--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;paletteAccess,',
        ],
    ],
    'palettes' => [
        'paletteStatus' => [
            'showitem' => 'crdate, status,',
        ],
        'paletteDates' => [
            'showitem' => 'holiday_begin, holiday_end,',
        ],
        'paletteCore' => [
            'showitem' => 'sys_language_uid, hidden,',
        ],
        'paletteAccess' => [
            'showitem' => 'hidden, sys_language_uid, --linebreak--,' .
                'starttime;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:starttime_formlabel,' .
                'endtime;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:endtime_formlabel,',
        ],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'sys_language',
                'foreign_table_where' => 'ORDER BY sys_language.title',
                'items' => [
                    ['LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.allLanguages', -1],
                    ['LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.default_value', 0],
                ],
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => true,
            'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_staffholiday_domain_model_plan',
                'foreign_table_where' => 'AND tx_staffholiday_domain_model_plan.pid = ###CURRENT_PID### AND ' .
                    'tx_staffholiday_domain_model_plan.sys_language_uid IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label' => [
            'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
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
            'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
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
        'crdate' => [
            'label' => $languageFile . '.crdate',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime',
                'readOnly' => 1,
            ],
        ],
        'holiday_begin' => [
            'exclude' => false,
            'label' => $languageFile . '.holiday_begin',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'required,' . $extConfiguration->getDateTimeHoliday(),
                'default' => time(),
            ],
        ],
        'holiday_end' => [
            'exclude' => false,
            'label' => $languageFile . '.holiday_end',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'required,' . $extConfiguration->getDateTimeHoliday(),
                'default' => 0,
            ],
        ],
        'notice' => [
            'exclude' => false,
            'label' => $languageFile . '.notice',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 5,
            ],
            'behaviour' => [
                'allowLanguageSynchronization' => 1
            ]
        ],
        'status' => [
            'exclude' => false,
            'label' => $languageFile . '.status',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    [$languageFile . '.status.101', Plan::STATUS_OPEN],
                    [$languageFile . '.status.102', Plan::STATUS_CONFIRMED],
                    [$languageFile . '.status.103', Plan::STATUS_REFUSED],
                ],
                'size' => 1,
                'maxitems' => 1,
            ],
        ],
        'user' => [
            'exclude' => false,
            'label' => $languageFile . '.user',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'fe_users',
                'foreign_where' => ' AND 1=1 ORDER BY fe_users.lastname, fe_users.firstname, fe_user.name',
                'size' => 1,
                'minitems' => 1,
                'maxitems' => 1,
                'eval' => 'required',
            ],
        ],
    ],
];

if (!$extConfiguration->isDisableLog()) {
    $planColumns['columns']['log'] = [
        'exclude' => true,
        'label' => $languageFile . '.log',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_staffholiday_domain_model_log',
            'foreign_field' => 'plan',
            'maxitems' => 1000,
            'minitems' => 0,
            'appearance' => [
                'collapseAll' => 1,
                'expandSingle' => 1,
            ],
        ],
    ];
    $planColumns['palettes']['paletteAccess']['showitem'] .= '--linebreak--, log,';
}

return $planColumns;
