<?php

declare(strict_types=1);

/*
 * @package LBRmedia Bootstrap Template - Provides Twitter Bootstrap 5 and some content elements.
 * @version 1.0.22
 * @author Marcel Briefs <mb@lbrmedia.de>
 * @copyright 2022 LBRmedia
 * @link https://github.com/lbr-media/typo3-extension-bootstrap
 * @license GPL-2.0-or-later
 */

namespace LBRmedia\Bootstrap\Listener\TCA\TtContent\NewContentElement;

use LBRmedia\Bootstrap\Service\TcaService;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

class BootstrapAlert implements NewContentElementInterface
{
    public static function addPlugin(TcaService $tcaService): void
    {
        // Add content element
        ExtensionManagementUtility::addPlugin(
            [
                'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:tt_content.CType.bootstrap_alert',
                'bootstrap_alert',
                'EXT:bootstrap/Resources/Public/Icons/TCA/bootstrap_alert.svg',
            ],
            'CType',
            'bootstrap'
        );

        // Add flexform
        $GLOBALS['TCA']['tt_content']['columns']['tx_bootstrap_flexform']['config']['ds']['*,bootstrap_alert'] = 'FILE:EXT:bootstrap/Configuration/FlexForms/TtContent/BootstrapAlert.xml';
        $GLOBALS['TCA']['tt_content']['palettes']['headers_bootstrap_alert'] = [
            'showitem' => 'header',
        ];

        // Configure TCA
        $GLOBALS['TCA']['tt_content']['types']['bootstrap_alert'] = [
            'showitem' => $tcaService->setShowitems($GLOBALS['TCA']['tt_content']['types']['text']['showitem'])
                ->addShowitemAfter('tx_bootstrap_flexform,tx_bootstrap_header_iconset,--linebreak--,tx_bootstrap_header_iconset_alignment', 'frames')
                ->addShowitemAfter('--palette--;;headers_bootstrap_alert', 'headers')
                ->removeShowitems(['headers', 'headers_icon', 'headers_iconset'])
                ->getShowitemsString(),
            'columnsOverrides' => [
                'bodytext' => [
                    'config' => [
                        'enableRichtext' => true,
                    ],
                ],
            ],
        ];

        // Icon in backend page view
        $GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['bootstrap_alert'] = 'bootstrap_alert';
    }
}
