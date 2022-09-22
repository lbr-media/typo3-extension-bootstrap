<?php

declare(strict_types=1);

/*
 * @package LBRmedia Bootstrap Template - Provides Twitter Bootstrap 5 and some content elements.
 * @version 1.0.23
 * @author Marcel Briefs <mb@lbrmedia.de>
 * @copyright 2022 LBRmedia
 * @link https://github.com/lbr-media/typo3-extension-bootstrap
 * @license GPL-2.0-or-later
 */

namespace LBRmedia\Bootstrap\Listener\TCA\TtContent\NewContentElement;

use LBRmedia\Bootstrap\Service\TcaService;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

class BootstrapTwoColumnsText implements NewContentElementInterface
{
    public static function addPlugin(TcaService $tcaService): void
    {
        // Add content element
        ExtensionManagementUtility::addPlugin(
            [
                'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:tt_content.CType.bootstrap_twocolumnstext',
                'bootstrap_twocolumnstext',
                'EXT:bootstrap/Resources/Public/Icons/TCA/bootstrap_twocolumnstext.svg',
            ],
            'CType',
            'bootstrap'
        );

        // Configure TCA
        $GLOBALS['TCA']['tt_content']['types']['bootstrap_twocolumnstext'] = [
            'showitem' => $tcaService->setShowitems($GLOBALS['TCA']['tt_content']['types']['text']['showitem'])
                ->addShowitemAfter(implode(',', [
                    '--div--;LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:tt_content.div.left',
                    'tx_bootstrap_bodytext1',
                    '--div--;LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:tt_content.div.right',
                    'tx_bootstrap_bodytext2',
                ]), 'bodytext')
                ->removeShowitems(['bodytext'])
                ->getShowitemsString(),
        ];

        // Icon in backend page view
        $GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['bootstrap_twocolumnstext'] = 'bootstrap_twocolumnstext';
    }
}
