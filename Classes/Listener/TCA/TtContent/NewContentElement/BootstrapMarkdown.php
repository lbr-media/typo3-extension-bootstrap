<?php

declare(strict_types=1);

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
            'showitem' => $GLOBALS['TCA']['tt_content']['types']['text']['showitem'],
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
