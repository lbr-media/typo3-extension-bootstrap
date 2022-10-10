<?php

declare(strict_types=1);

/*
 * @package LBRmedia Bootstrap Template - Provides Twitter Bootstrap 5 and some content elements.
 * @version 12.0.0
 * @author Marcel Briefs <mb@lbrmedia.de>
 * @copyright 2022 LBRmedia
 * @link https://github.com/lbr-media/typo3-extension-bootstrap
 * @license GPL-2.0-or-later
 */

use LBRmedia\Bootstrap\UserFunc\TCA\CardItem;
use LBRmedia\Bootstrap\Utility\PictureUtility;
use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

return [
    'ctrl' => [
        'title' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:tx_bootstrap_domain_model_carditem',
        'label' => 'header',
        'label_userFunc' => CardItem::class . '->title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'delete' => 'deleted',
        'hideTable' => false,
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
        'security' => [
            'ignorePageTypeRestriction' => true,
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
                'type' => 'datetime',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'datetime',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038),
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
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
            'config' => ExtensionManagementUtility::getFileFieldTCAConfig(
                'image',
                [
                    'minitems' => 0,
                    'maxitems' => 1,
                    'overrideChildTca' => [
                        'types' => [
                            File::FILETYPE_IMAGE => [
                                'showitem' => 'title,alternative,crop,--palette--;;filePalette',
                            ],
                        ],
                        'columns' => [
                            'crop' => [
                                'config' => [
                                    'cropVariants' => PictureUtility::getTcaCropVariantsOverride(PictureUtility::CROP_VARIANTS_BOOTSTRAP),
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
                'type' => 'link',
                'nullable' => 'true',
                'allowedTypes' => ['page', 'url', 'file', 'email', 'telephone', 'record'],
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
