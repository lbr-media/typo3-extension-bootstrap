<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Listener\TCA\TtContent;

use LBRmedia\Bootstrap\UserFunc\TCA\TtContent;
use LBRmedia\Bootstrap\UserFunc\TCA\TtContentHeader;
use LBRmedia\Bootstrap\Utility\PictureUtility;
use TYPO3\CMS\Core\Configuration\Event\AfterTcaCompilationEvent;
use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

class Columns
{
    public function __invoke(AfterTcaCompilationEvent $event): void
    {
        /**
         * Add fields to tt_content.
         */
        $tmpColumnes = [
            'tx_bootstrap_header_layout' => [
                'exclude' => 1,
                'label' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:tt_content.tx_bootstrap_header_layout',
                'config' => [
                    'type' => 'select',
                    'renderType' => 'selectSingle',
                    'items' => [
                        ['Standard', ''],
                    ],
                ],
            ],
            'tx_bootstrap_header_color' => [
                'exclude' => 1,
                'label' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:tt_content.tx_bootstrap_header_color',
                'config' => [
                    'type' => 'select',
                    'renderType' => 'selectSingle',
                    'items' => [
                        ['Standard', ''],
                    ],
                ],
            ],
            'tx_bootstrap_header_predefined' => [
                'exclude' => 1,
                'label' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:tt_content.tx_bootstrap_header_predefined',
                'config' => [
                    'type' => 'select',
                    'renderType' => 'selectSingle',
                    'itemsProcFunc' => TtContentHeader::class.'->predefinedHeader',
                ],
            ],
            'tx_bootstrap_header_additional_styles' => [
                'exclude' => 1,
                'label' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:tt_content.tx_bootstrap_header_additional_styles',
                'config' => [
                    'type' => 'select',
                    'renderType' => 'selectMultipleSideBySide',
                    'size' => 3,
                    'itemsProcFunc' => TtContentHeader::class.'->additionalHeaderStyles',
                ],
            ],
            'tx_bootstrap_header_icon' => [
                'exclude' => 1,
                'label' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:tt_content.tx_bootstrap_header_icon',
                'config' => ExtensionManagementUtility::getFileFieldTCAConfig(
                    'tx_bootstrap_header_icon',
                    [
                        'minitems' => 0,
                        'maxitems' => 1,
                        'appearance' => [
                            'createNewRelationLinkTitle' => 'LLL:EXT:cms/locallang_ttc.xlf:images.addFileReference',
                        ],
                        'overrideChildTca' => [
                            'types' => [
                                File::FILETYPE_IMAGE => [
                                    'showitem' => 'title,alternative,crop,--palette--;;filePalette',
                                ],
                            ],
                            'columns' => [
                                'crop' => [
                                    'config' => [
                                        'cropVariants' => PictureUtility::getTcaCropVariantsOverride(['default']),
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'png,svg,gif', // $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
                ),
            ],
            'tx_bootstrap_text_color' => [
                'exclude' => 1,
                'label' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:tt_content.tx_bootstrap_text_color',
                'config' => [
                    'type' => 'select',
                    'renderType' => 'selectSingle',
                    'items' => [
                        ['Standard', ''],
                    ],
                ],
            ],
            'tx_bootstrap_background_color' => [
                'exclude' => 1,
                'label' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:tt_content.tx_bootstrap_background_color',
                'config' => [
                    'type' => 'select',
                    'renderType' => 'selectSingle',
                    'items' => [
                        ['Standard', ''],
                    ],
                ],
            ],
            'tx_bootstrap_additional_styles' => [
                'exclude' => 1,
                'label' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:tt_content.tx_bootstrap_additional_styles',
                'config' => [
                    'type' => 'select',
                    'renderType' => 'selectMultipleSideBySide',
                    'size' => 3,
                    'itemsProcFunc' => TtContent::class.'->additionalStyles',
                ],
            ],
            'tx_bootstrap_inner_frame_class' => [
                'exclude' => 1,
                'label' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:tt_content.tx_bootstrap_inner_frame_class',
                'config' => [
                    'type' => 'select',
                    'renderType' => 'selectSingle',
                    'items' => [
                        ['Standard', ''],
                    ],
                ],
            ],
            'tx_bootstrap_section_index_header' => [
                'exclude' => 1,
                'label' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:tt_content.tx_bootstrap_section_index_header',
                'config' => [
                    'type' => 'text',
                    'rows' => 3,
                    'cols' => 20,
                ],
            ],
            'tx_bootstrap_flexform' => [
                'exclude' => 1,
                'l10n_display' => 'hideDiff',
                'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:pi_flexform',
                'config' => [
                    'type' => 'flex',
                    'ds_pointerField' => 'list_type,CType',
                    'ds' => [
                        'default' => '
                            <T3DataStructure>
                            <ROOT>
                                <type>array</type>
                                <el>
                                    <!-- Repeat an element like "xmlTitle" beneath for as many elements you like. Remember to name them uniquely  -->
                                <xmlTitle>
                                    <TCEforms>
                                        <label>The Title:</label>
                                        <config>
                                            <type>input</type>
                                            <size>48</size>
                                        </config>
                                    </TCEforms>
                                </xmlTitle>
                                </el>
                            </ROOT>
                            </T3DataStructure>
                        ',
                    ],
                    'search' => [
                        'andWhere' => '{#CType}=\'list\'',
                    ],
                ],
            ],
            'tx_bootstrap_image1' => [
                'exclude' => 1,
                'label' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:tt_content.tx_bootstrap_image1',
                'config' => ExtensionManagementUtility::getFileFieldTCAConfig(
                    'tx_bootstrap_image1',
                    [
                        'minitems' => 0,
                        'maxitems' => 1,
                        'appearance' => [
                            'createNewRelationLinkTitle' => 'LLL:EXT:cms/locallang_ttc.xlf:images.addFileReference',
                        ],
                        'overrideChildTca' => [
                            'types' => [
                                File::FILETYPE_IMAGE => [
                                    'showitem' => 'title,alternative,description,link,crop,--palette--;;filePalette',
                                ],
                            ],
                            'columns' => [
                                'crop' => [
                                    'config' => [
                                        'cropVariants' => PictureUtility::getTcaCropVariantsOverride(['xs', 'sm', 'md', 'lg', 'xl']),
                                    ],
                                ],
                            ],
                        ],
                    ],
                    $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
                ),
            ],
            'tx_bootstrap_image2' => [
                'exclude' => 1,
                'label' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:tt_content.tx_bootstrap_image2',
                'config' => ExtensionManagementUtility::getFileFieldTCAConfig(
                    'tx_bootstrap_image2',
                    [
                        'minitems' => 0,
                        'maxitems' => 1,
                        'appearance' => [
                            'createNewRelationLinkTitle' => 'LLL:EXT:cms/locallang_ttc.xlf:images.addFileReference',
                        ],
                        'overrideChildTca' => [
                            'types' => [
                                File::FILETYPE_IMAGE => [
                                    'showitem' => 'title,alternative,description,link,crop,--palette--;;filePalette',
                                ],
                            ],
                            'columns' => [
                                'crop' => [
                                    'config' => [
                                        'cropVariants' => PictureUtility::getTcaCropVariantsOverride(['xs', 'sm', 'md', 'lg', 'xl']),
                                    ],
                                ],
                            ],
                        ],
                    ],
                    $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
                ),
            ],
            'tx_bootstrap_bodytext1' => [
                'exclude' => 1,
                'label' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:tt_content.tx_bootstrap_bodytext1',
                'config' => [
                    'type' => 'text',
                    'cols' => 48,
                    'rows' => 6,
                    'enableRichtext' => true,
                ],
            ],
            'tx_bootstrap_bodytext2' => [
                'exclude' => 1,
                'label' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:tt_content.tx_bootstrap_bodytext2',
                'config' => [
                    'type' => 'text',
                    'cols' => 48,
                    'rows' => 6,
                    'enableRichtext' => true,
                ],
            ],
            'tx_bootstrap_teammember' => [
                'exclude' => 1,
                'label' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:tt_content.tx_bootstrap_teammember',
                'config' => [
                    'type' => 'inline',
                    'foreign_table' => 'tx_bootstrap_domain_model_teammember',
                    'foreign_field' => 'tt_content_uid',
                    'maxitems' => 50,
                    'appearance' => [
                        'levelLinksPosition' => 'both',
                        'useSortable' => true,
                        'showPossibleLocalizationRecords' => false,
                        'showRemovedLocalizationRecords' => false,
                        'showSynchronizationLink' => false,
                        'showAllLocalizationLink' => false,
                        'collapseAll' => true,
                        'expandSingle' => true,
                    ],
                ],
            ],
            'tx_bootstrap_accordionitems' => [
                'exclude' => 1,
                'label' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:tt_content.tx_bootstrap_accordionitems',
                'config' => [
                    'type' => 'inline',
                    'foreign_table' => 'tx_bootstrap_domain_model_accordionitem',
                    'foreign_field' => 'tt_content_uid',
                    'maxitems' => 50,
                    'appearance' => [
                        'levelLinksPosition' => 'both',
                        'useSortable' => true,
                        'showPossibleLocalizationRecords' => false,
                        'showRemovedLocalizationRecords' => false,
                        'showSynchronizationLink' => false,
                        'showAllLocalizationLink' => false,
                        'collapseAll' => false,
                        'expandSingle' => true,
                    ],
                ],
            ],
            'tx_bootstrap_tabulatoritems' => [
                'exclude' => 1,
                'label' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:tt_content.tx_bootstrap_tabulatoritems',
                'config' => [
                    'type' => 'inline',
                    'foreign_table' => 'tx_bootstrap_domain_model_tabulatoritem',
                    'foreign_field' => 'tt_content_uid',
                    'maxitems' => 50,
                    'appearance' => [
                        'levelLinksPosition' => 'both',
                        'useSortable' => true,
                        'showPossibleLocalizationRecords' => false,
                        'showRemovedLocalizationRecords' => false,
                        'showSynchronizationLink' => false,
                        'showAllLocalizationLink' => false,
                        'collapseAll' => false,
                        'expandSingle' => true,
                    ],
                ],
            ],
        ];

        ExtensionManagementUtility::addTCAcolumns('tt_content', $tmpColumnes);

        ExtensionManagementUtility::addFieldsToPalette(
            'tt_content',
            'headers',
            'tx_bootstrap_header_layout,tx_bootstrap_header_predefined,--linebreak--,tx_bootstrap_header_color',
            'after:header_layout'
        );

        ExtensionManagementUtility::addFieldsToPalette(
            'tt_content',
            'headers',
            'tx_bootstrap_header_additional_styles,--linebreak--,tx_bootstrap_header_icon',
            'after:header_position'
        );

        ExtensionManagementUtility::addFieldsToPalette(
            'tt_content',
            'frames',
            'tx_bootstrap_inner_frame_class,--linebreak--,tx_bootstrap_additional_styles,--linebreak--,tx_bootstrap_text_color, tx_bootstrap_background_color,--linebreak--',
            'after:frame_class'
        );

        /*
         * we need more lines for the title in tt_content.header
         * also add a description
         */
        $GLOBALS['TCA']['tt_content']['columns']['header']['description'] = 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:tt_content.header.description';
        $GLOBALS['TCA']['tt_content']['columns']['header']['config']['type'] = 'text';
        $GLOBALS['TCA']['tt_content']['columns']['header']['config']['cols'] = 20;
        $GLOBALS['TCA']['tt_content']['columns']['header']['config']['rows'] = 3;

        /**
         * CType=table
         * Use more than one class for tables.
         */
        $GLOBALS['TCA']['tt_content']['columns']['table_class']['config']['renderType'] = 'selectMultipleSideBySide';

        // restore TCA
        $event->setTca($GLOBALS['TCA']);
    }
}
