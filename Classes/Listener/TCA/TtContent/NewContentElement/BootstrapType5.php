<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Listener\TCA\TtContent\NewContentElement;

use LBRmedia\Bootstrap\Service\TcaService;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

class BootstrapType5 implements NewContentElementInterface
{
    public static function addPlugin(TcaService $tcaService): void
    {
        // Add content element
        ExtensionManagementUtility::addPlugin(
            [
                'Bild + Text | Text + Bild',
                'bootstrap_type5',
                'EXT:bootstrap/Resources/Public/Icons/TCA/bootstrap_type5.svg',
            ],
            'CType',
            'bootstrap'
        );

        // Configure TCA
        $GLOBALS['TCA']['tt_content']['types']['bootstrap_type5'] = [
            'showitem' => $tcaService->setShowitems($GLOBALS['TCA']['tt_content']['types']['text']['showitem'])
                ->addShowitemAfter(implode(',', [
                    '--div--;Links',
                    'tx_bootstrap_image1',
                    'tx_bootstrap_bodytext1',
                    '--div--;Rechts',
                    'tx_bootstrap_bodytext2',
                    'tx_bootstrap_image2',
                ]), 'bodytext')
                ->removeShowitems(['bodytext'])
                ->getShowitemsString(),
        ];

        // Icon in backend page view
        $GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['bootstrap_type5'] = 'bootstrap_type5';
    }
}
