<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Listener\TCA\TtContent\NewContentElement;

use LBRmedia\Bootstrap\Service\TcaService;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use LBRmedia\Bootstrap\Utility\GeneralUtility as BootstrapGeneralUtility;

class BootstrapTextMediaFloat implements NewContentElementInterface
{
    public static function addPlugin(TcaService $tcaService): void
    {
        // Add content element
        ExtensionManagementUtility::addPlugin(
            [
                'Text & Medien (umfließend)',
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
                                        'cropVariants' => BootstrapGeneralUtility::getTcaCropVariantsOverride(['xs', 'sm', 'md', 'lg', 'xl', 'xxl']),
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