<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Listener\TCA\TtContent\NewContentElement;

use LBRmedia\Bootstrap\Service\TcaService;
use LBRmedia\Bootstrap\Utility\GeneralUtility as BootstrapGeneralUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

class BootstrapMediaGrid implements NewContentElementInterface
{
    public static function addPlugin(TcaService $tcaService): void
    {
        // Add content element
        ExtensionManagementUtility::addPlugin(
            [
                'Medien-Raster',
                'bootstrap_mediagrid',
                'EXT:bootstrap/Resources/Public/Icons/TCA/bootstrap_mediagrid.svg',
            ],
            'CType',
            'bootstrap'
        );

        // Add flexform
        $GLOBALS['TCA']['tt_content']['columns']['tx_bootstrap_flexform']['config']['ds']['*,bootstrap_mediagrid'] = 'FILE:EXT:bootstrap/Configuration/FlexForms/TtContent/BootstrapMediaGrid.xml';

        // Configure TCA
        $GLOBALS['TCA']['tt_content']['types']['bootstrap_mediagrid'] = [
            'showitem' => $tcaService->setShowitems($GLOBALS['TCA']['tt_content']['types']['image']['showitem'])
                ->addShowitemAfter('tx_bootstrap_flexform', 'frames')
                ->addShowitemAfter('assets', 'image')
                ->removeShowitems(['bodytext', 'image', 'mediaAdjustments', 'gallerySettings', 'imagelinks'])
                ->getShowitemsString(),
            'columnsOverrides' => [
                'assets' => [
                    'config' => [
                        'minitems' => 1,
                        'maxitems' => 30,
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
        $GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['bootstrap_mediagrid'] = 'bootstrap_mediagrid';
    }
}