<?php

declare(strict_types=1);

call_user_func(
    function ($extKey) {
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
            $extKey,
            'Configuration/TsConfig/Page/General.typoscript',
            'General'
        );

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
            $extKey,
            'Configuration/TsConfig/BackendLayouts/General.typoscript',
            'Backend Layouts'
        );

        /*
         * set cropVariants and palette to social media images
         */
        $GLOBALS['TCA']['pages']['columns']['og_image']['config']['overrideChildTca']['types'] = [
            \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                'showitem' => 'crop,--palette--;;filePalette',
            ],
        ];
        $GLOBALS['TCA']['pages']['columns']['og_image']['config']['overrideChildTca']['columns']['crop']['config']['cropVariants'] = \LBRmedia\Bootstrap\Utility\GeneralUtility::getTcaCropVariantsOverride(['social']);

        $GLOBALS['TCA']['pages']['columns']['twitter_image']['config']['overrideChildTca']['types'] = [
            \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                'showitem' => 'crop,--palette--;;filePalette',
            ],
        ];
        $GLOBALS['TCA']['pages']['columns']['twitter_image']['config']['overrideChildTca']['columns']['crop']['config']['cropVariants'] = \LBRmedia\Bootstrap\Utility\GeneralUtility::getTcaCropVariantsOverride(['social']);

        /*
         * Configure the field media
         */
        $GLOBALS['TCA']['pages']['columns']['media']['config']['overrideChildTca']['columns']['crop']['config']['cropVariants'] = \LBRmedia\Bootstrap\Utility\GeneralUtility::getTcaCropVariantsOverride([
            'pages_media_xs',
            'pages_media_sm',
            'pages_media_md',
            'pages_media_lg',
            'pages_media_xl',
            'pages_media_xxl',
        ]);

        // constrain max items in field media
        $GLOBALS['TCA']['pages']['columns']['media']['config']['maxitems'] = 10;

        $GLOBALS['TCA']['pages']['columns']['media']['config']['overrideChildTca']['types'] = [
            \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                'showitem' => 'title,alternative,crop,--palette--;;filePalette',
            ],
        ];
    },
    'bootstrap'
);
