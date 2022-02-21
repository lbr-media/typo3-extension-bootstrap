<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Listener\TCA\TtContent\NewContentElement;

use LBRmedia\Bootstrap\Service\TcaService;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

class BootstrapType7 implements NewContentElementInterface
{
    public static function addPlugin(TcaService $tcaService): void
    {
        // Add content element
        ExtensionManagementUtility::addPlugin(
            [
                'Text | Text',
                'bootstrap_type7',
                'EXT:bootstrap/Resources/Public/Icons/TCA/bootstrap_type7.svg',
            ],
            'CType',
            'bootstrap'
        );

        // Configure TCA
        $GLOBALS['TCA']['tt_content']['types']['bootstrap_type7'] = [
            'showitem' => $tcaService->setShowitems($GLOBALS['TCA']['tt_content']['types']['text']['showitem'])
                ->addShowitemAfter(implode(',', [
                    '--div--;Links',
                    'tx_bootstrap_bodytext1',
                    '--div--;Rechts',
                    'tx_bootstrap_bodytext2',
                ]), 'bodytext')
                ->removeShowitems(['bodytext'])
                ->getShowitemsString(),
        ];

        // Icon in backend page view
        $GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['bootstrap_type7'] = 'bootstrap_type7';
    }
}
