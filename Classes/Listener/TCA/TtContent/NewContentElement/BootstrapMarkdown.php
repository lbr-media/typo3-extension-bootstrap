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

class BootstrapMarkdown implements NewContentElementInterface
{
    public static function addPlugin(TcaService $tcaService): void
    {
        // Add content element
        ExtensionManagementUtility::addPlugin(
            [
                'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:tt_content.CType.bootstrap_markdown',
                'bootstrap_markdown',
                'EXT:bootstrap/Resources/Public/Icons/TCA/bootstrap_markdown.svg',
            ],
            'CType',
            'bootstrap'
        );

        // Configure TCA
        $GLOBALS['TCA']['tt_content']['types']['bootstrap_markdown'] = [
            'showitem' => $tcaService->setShowitems($GLOBALS['TCA']['tt_content']['types']['text']['showitem'])
                ->replaceShowItem('bodytext', '--div--;LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:tt_content.div.markdown,bodytext')
                ->getShowitemsString(),
            'columnsOverrides' => [
                'bodytext' => [
                    'config' => [
                        'enableRichtext' => false,
                    ],
                ],
            ],
        ];

        // Icon in backend page view
        $GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['bootstrap_markdown'] = 'bootstrap_markdown';
    }
}
