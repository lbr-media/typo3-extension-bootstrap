<?php

declare(strict_types=1);

call_user_func(
    function ($extKey) {
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'ItemList',
            'Items: overview'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'ItemDetails',
            'Items: details'
        );

        // register preview renderer
        $GLOBALS['TCA']['tt_content']['ctrl']['previewRenderer'] = \LBRmedia\Bootstrap\Hooks\PageLayoutView\ContentPreviewRenderer::class;
    },
    'bootstrap'
);
