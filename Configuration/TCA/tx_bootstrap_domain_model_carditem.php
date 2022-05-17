<?php

declare(strict_types=1);

/*
 * @package LBRmedia Bootstrap Template - Provides Twitter Bootstrap 5 and some content elements.
 * @version 1.0.22
 * @author Marcel Briefs <mb@lbrmedia.de>
 * @copyright 2022 LBRmedia
 * @link https://github.com/lbr-media/typo3-extension-bootstrap
 * @license GPL-2.0-or-later
 */

return [
    'ctrl' => [
        'title' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:tx_bootstrap_domain_model_carditem',
        'label' => 'header',
        'label_userFunc' => \LBRmedia\Bootstrap\UserFunc\TCA\CardItem::class . '->title',
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
        'searchFields' => 'header,title,text,footer',
        'typeicon_classes' => [
            'default' => 'tx_bootstrap_domain_model_carditem',
        ],
    ],
    'types' => [
        '1' => [
            'showitem' => '
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                header,
                --linbreak--,
                title,
                --linebreak--,
                text,
                --palette--;;typolink_palette,
                footer,
                --div--;LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:tx_bootstrap_domain_model_carditem.div.image_iconset,
                image,
                iconset,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                hidden,--palette--;;timeRestriction,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,
            ',
        ],
    ],
    'palettes' => [
        'typolink_palette' => ['showitem' => 'typolink,typolink_text'],
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
        'header' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:tx_bootstrap_domain_model_carditem.header',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'max' => 255,
                'eval' => 'trim',
            ],
        ],
        'title' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:tx_bootstrap_domain_model_carditem.title',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'max' => 255,
                'eval' => 'trim',
            ],
        ],
        'image' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:tx_bootstrap_domain_model_carditem.image',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'image',
                [
                    'minitems' => 0,
                    'maxitems' => 1,
                    'overrideChildTca' => [
                        'types' => [
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                                'showitem' => 'title,alternative,crop,--palette--;;filePalette',
                            ],
                        ],
                        'columns' => [
                            'crop' => [
                                'config' => [
                                    'cropVariants' => \LBRmedia\Bootstrap\Utility\PictureUtility::getTcaCropVariantsOverride(\LBRmedia\Bootstrap\Utility\PictureUtility::CROP_VARIANTS_BOOTSTRAP),
                                ],
                            ],
                        ],
                    ],
                ],
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            ),
        ],
        'iconset' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:tx_bootstrap_domain_model_carditem.iconset',
            'config' => [
                'type' => 'user',
                'renderType' => 'bootstrapIcons',
                'renderIconPosition' => false,
                'renderIconSize' => true,
                'renderIconColor' => true,
            ],
        ],
        'text' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:tx_bootstrap_domain_model_carditem.text',
            'config' => [
                'type' => 'text',
                'cols' => 48,
                'rows' => 6,
                'enableRichtext' => true,
            ],
        ],
        'typolink' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:tx_bootstrap_domain_model_carditem.typolink',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputLink',
                'eval' => 'trim',
            ],
        ],
        'typolink_text' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:tx_bootstrap_domain_model_carditem.typolink_text',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'max' => 255,
                'eval' => 'trim',
            ],
        ],
        'footer' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:tx_bootstrap_domain_model_carditem.footer',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'max' => 255,
                'eval' => 'trim',
            ],
        ],
    ],
];
