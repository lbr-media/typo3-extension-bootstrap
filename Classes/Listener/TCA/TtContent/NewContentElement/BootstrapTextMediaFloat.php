<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Listener\TCA\TtContent\NewContentElement;

use LBRmedia\Bootstrap\Service\TcaService;
use LBRmedia\Bootstrap\Utility\PictureUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

class BootstrapTextMediaFloat implements NewContentElementInterface
{
    public static function addPlugin(TcaService $tcaService): void
    {
        // Add content element
        ExtensionManagementUtility::addPlugin(
            [
                'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:tt_content.CType.bootstrap_textmediafloat',
                'bootstrap_textmediafloat',
                'EXT:bootstrap/Resources/Public/Icons/TCA/bootstrap_textmediafloat.svg',
            ],
            'CType',
            'bootstrap'
        );

        // Add flexform
        $GLOBALS['TCA']['tt_content']['columns']['tx_bootstrap_flexform']['config']['ds']['*,bootstrap_textmediafloat'] = 'FILE:EXT:bootstrap/Configuration/FlexForms/TtContent/BootstrapTextMediaFloat.xml';

        // Configure TCA
        $GLOBALS['TCA']['tt_content']['types']['bootstrap_textmediafloat'] = [
            'showitem' => $tcaService->setShowitems($GLOBALS['TCA']['tt_content']['types']['textmedia']['showitem'])
                ->addShowitemAfter('tx_bootstrap_flexform', 'frames')
                ->removeShowitems(['mediaAdjustments', 'gallerySettings', 'imagelinks'])
                ->replaceShowItem('bodytext', '--div--;LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:tt_content.div.bodytext,bodytext')
                ->getShowitemsString(),
            'columnsOverrides' => [
                'bodytext' => [
                    'config' => [
                        'enableRichtext' => true,
                    ],
                ],
                'assets' => [
                    'config' => [
                        'minitems' => 1,
                        'maxitems' => 10,
                        'overrideChildTca' => [
                            'columns' => [
                                'crop' => [
                                    'config' => [
                                        'cropVariants' => PictureUtility::getTcaCropVariantsOverride(PictureUtility::CROP_VARIANTS_BOOTSTRAP),
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        // Icon in backend page view
        $GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['bootstrap_textmediafloat'] = 'bootstrap_textmediafloat';
    }
}
