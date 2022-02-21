<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Listener\TCA\TtContent\NewContentElement;

use LBRmedia\Bootstrap\Service\TcaService;
use LBRmedia\Bootstrap\Utility\GeneralUtility as BootstrapGeneralUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

// use TYPO3\CMS\Core\Resource\File;

class BootstrapType1 implements NewContentElementInterface
{
    public static function addPlugin(TcaService $tcaService): void
    {
        // Add content element
        ExtensionManagementUtility::addPlugin(
            [
                'Überschrift + Text | Bild',
                'bootstrap_type1',
                'EXT:bootstrap/Resources/Public/Icons/TCA/bootstrap_type1.svg',
            ],
            'CType',
            'bootstrap'
        );

        // Configure TCA
        $GLOBALS['TCA']['tt_content']['types']['bootstrap_type1'] = [
            'showitem' => $tcaService->setShowitems($GLOBALS['TCA']['tt_content']['types']['textpic']['showitem'])
                ->getShowitemsString(),
            'columnsOverrides' => [
                'bodytext' => [
                    'config' => [
                        'enableRichtext' => true,
                    ],
                ],
                'image' => [
                    'config' => [
                        'minitems' => 0,
                        'maxitems' => 1,
                        'overrideChildTca' => [
                            // 'types' => [
                            //     File::FILETYPE_IMAGE => [
                            //         'showitem' => 'title,alternative,crop,--palette--;;filePalette',
                            //     ],
                            // ],
                            'columns' => [
                                'crop' => [
                                    'config' => [
                                        'cropVariants' => BootstrapGeneralUtility::getTcaCropVariantsOverride(['std', 'sm', 'md', 'lg', 'xl']),
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        // Icon in backend page view
        $GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['bootstrap_type1'] = 'bootstrap_type1';
    }
}
