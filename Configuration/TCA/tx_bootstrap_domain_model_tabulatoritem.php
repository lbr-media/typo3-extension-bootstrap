<?php

declare(strict_types=1);

/*
 * @package LBRmedia Bootstrap Template - Provides Twitter Bootstrap 5 and some content elements.
 * @version 1.0.23
 * @author Marcel Briefs <mb@lbrmedia.de>
 * @copyright 2022 LBRmedia
 * @link https://github.com/lbr-media/typo3-extension-bootstrap
 * @license GPL-2.0-or-later
 */

return [
    'ctrl' => [
        'title' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:tx_bootstrap_domain_model_tabulatoritem',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'delete' => 'deleted',
        'hideTable' => true,
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'sortby' => 'sorting',
        'searchFields' => 'title',
        'typeicon_classes' => [
            'default' => 'tx_bootstrap_domain_model_tabulatoritem',
        ],
        'security' => [
            'ignorePageTypeRestriction' => true,
        ]
    ],
    'types' => [
        '1' => [
            'showitem' => '
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                title,
                --linebreak--,
                active,
                --div--;LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:tt_content.div.content_elements,
                content_elements,
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
        'title' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:tx_bootstrap_domain_model_tabulatoritem.title',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'max' => 255,
                'eval' => 'trim',
                'required' => true,
            ],
        ],
        'active' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:tx_bootstrap_domain_model_tabulatoritem.active',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'default' => 0,
            ],
        ],
        'content_elements' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:tx_bootstrap_domain_model_tabulatoritem.content_elements',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_bootstrap_domain_model_contentelement',
                'foreign_field' => 'tabulatoritem_uid',
                'foreign_sortby' => 'sorting',
                'maxitems' => 50,
                'appearance' => [
                    'levelLinksPosition' => 'both',
                    'useSortable' => true,
                    'showPossibleLocalizationRecords' => false,
                    'showSynchronizationLink' => false,
                    'showAllLocalizationLink' => false,
                    'collapseAll' => true,
                    'expandSingle' => true,
                ],
            ],
        ],
    ],
];
