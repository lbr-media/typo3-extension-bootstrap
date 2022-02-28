<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Listener\TCA\TtContent\NewContentElement;

use LBRmedia\Bootstrap\Service\TcaService;
use LBRmedia\Bootstrap\Utility\PictureUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Resource\File;

class BootstrapTextImage implements NewContentElementInterface
{
    public static function addPlugin(TcaService $tcaService): void
    {
        // Add content element
        ExtensionManagementUtility::addPlugin(
            [
                'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:tt_content.CType.bootstrap_textimage',
                'bootstrap_textimage',
                'EXT:bootstrap/Resources/Public/Icons/TCA/bootstrap_textimage.svg',
            ],
            'CType',
            'bootstrap'
        );

        // Add flexform
        $GLOBALS['TCA']['tt_content']['columns']['tx_bootstrap_flexform']['config']['ds']['*,bootstrap_textimage'] = 'FILE:EXT:bootstrap/Configuration/FlexForms/TtContent/BootstrapTextImage.xml';

        // Configure TCA
        $GLOBALS['TCA']['tt_content']['types']['bootstrap_textimage'] = [
            'showitem' => $tcaService->setShowitems($GLOBALS['TCA']['tt_content']['types']['textpic']['showitem'])
                ->addShowitemAfter('tx_bootstrap_flexform', 'frames')
                ->removeShowitems(['mediaAdjustments', 'gallerySettings', 'imagelinks'])
                ->getShowitemsString(),
            'columnsOverrides' => [
                'bodytext' => [
                    'config' => [
                        'enableRichtext' => true,
                    ],
                ],
                'image' => [
                    'config' => [
                        'minitems' => 1,
                        'maxitems' => 1,
                        'overrideChildTca' => [
                            'types' => [
                                File::FILETYPE_IMAGE => [
                                    'showitem' => 'title,alternative,--linebreak--,description,--linebreak--,crop,--palette--;;filePalette',
                                ],
                            ],
                            'columns' => [
                                'crop' => [
                                    'config' => [
                                        'cropVariants' => PictureUtility::getTcaCropVariantsOverride(['xs', 'sm', 'md', 'lg', 'xl', 'xxl']),
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        // Icon in backend page view
        $GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['bootstrap_textimage'] = 'bootstrap_textimage';
    }
}
