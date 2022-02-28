<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Listener\TCA\TtContent\NewContentElement;

use LBRmedia\Bootstrap\Service\TcaService;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

class BootstrapCards implements NewContentElementInterface
{
    public static function addPlugin(TcaService $tcaService): void
    {
        // Add content element
        ExtensionManagementUtility::addPlugin(
            [
                'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:tt_content.CType.bootstrap_cards',
                'bootstrap_cards',
                'EXT:bootstrap/Resources/Public/Icons/TCA/bootstrap_cards.svg',
            ],
            'CType',
            'bootstrap'
        );

        // Add flexform
        $GLOBALS['TCA']['tt_content']['columns']['tx_bootstrap_flexform']['config']['ds']['*,bootstrap_cards'] = 'FILE:EXT:bootstrap/Configuration/FlexForms/TtContent/BootstrapCards.xml';

        // Configure TCA
        $GLOBALS['TCA']['tt_content']['types']['bootstrap_cards'] = [
            'showitem' => $tcaService->setShowitems($GLOBALS['TCA']['tt_content']['types']['text']['showitem'])
                ->addShowitemAfter('tx_bootstrap_flexform,tx_bootstrap_carditems', 'bodytext')
                ->removeShowitems(['bodytext'])
                ->getShowitemsString(),
        ];

        // Icon in backend page view
        $GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['bootstrap_tabs'] = 'bootstrap_cards';
    }
}
