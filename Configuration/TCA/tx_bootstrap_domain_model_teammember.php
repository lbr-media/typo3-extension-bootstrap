<?php

declare(strict_types=1);

return [
    'ctrl' => [
        'title' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:tx_bootstrap_domain_model_teammember',
        'label' => 'name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'delete' => 'deleted',
        'hideTable' => true,
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'sortby' => 'sorting',
        'searchFields' => 'name,description',
        'typeicon_classes' => [
            'default' => 'tx_bootstrap_domain_model_teammember',
        ],
    ],
    'types' => [
        '1' => [
            'showitem' => '
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                name,
                --linbreak--,
                portrait,
                --linebreak--,
                description,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                hidden,--palette--;;timeRestriction,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,
            ',
        ],
    ],
    'palettes' => [
        'timeRestriction' => ['showitem' => 'starttime,endtime'],
    ],
    'columns' => [
        'hidden' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.enabled',
            'exclude' => true,
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'default' => 0,
                'items' => [
                    [
                        0 => '',
                        1 => '',
                    ],
                ],
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0,
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0,
            ],
        ],

        'name' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:tx_bootstrap_domain_model_teammember.name',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'max' => 255,
                'eval' => 'trim,required',
            ],
        ],
        'portrait' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:tx_bootstrap_domain_model_teammember.portrait',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'portrait',
                [
                    'minitems' => 0,
                    'maxitems' => 1,
                    'overrideChildTca' => [
                        'types' => [
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                                'showitem' => 'crop,--palette--;;filePalette',
                            ],
                        ],
                        'columns' => [
                            'crop' => [
                                'config' => [
                                    'cropVariants' => \LBRmedia\Bootstrap\Utility\PictureUtility::getTcaCropVariantsOverride(\LBRmedia\Bootstrap\Utility\PictureUtility::CROP_VARIANTS_DEFAULT),
                                ],
                            ],
                        ],
                    ],
                ],
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            ),
        ],
        'description' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:tx_bootstrap_domain_model_teammember.description',
            'config' => [
                'type' => 'text',
                'cols' => 48,
                'rows' => 6,
                'enableRichtext' => true,
            ],
        ],
    ],
];
