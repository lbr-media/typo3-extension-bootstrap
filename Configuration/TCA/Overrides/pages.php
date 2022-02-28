<?php

declare(strict_types=1);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
    'bootstrap',
    'Configuration/TsConfig/Page/General.typoscript',
    'General'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
    'bootstrap',
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
$GLOBALS['TCA']['pages']['columns']['og_image']['config']['overrideChildTca']['columns']['crop']['config']['cropVariants'] = \LBRmedia\Bootstrap\Utility\PictureUtility::getTcaCropVariantsOverride(\LBRmedia\Bootstrap\Utility\PictureUtility::CROP_VARIANTS_SOCIAL_MEDIA);

$GLOBALS['TCA']['pages']['columns']['twitter_image']['config']['overrideChildTca']['types'] = [
    \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
        'showitem' => 'crop,--palette--;;filePalette',
    ],
];
$GLOBALS['TCA']['pages']['columns']['twitter_image']['config']['overrideChildTca']['columns']['crop']['config']['cropVariants'] = \LBRmedia\Bootstrap\Utility\PictureUtility::getTcaCropVariantsOverride(\LBRmedia\Bootstrap\Utility\PictureUtility::CROP_VARIANTS_SOCIAL_MEDIA);

/*
 * Configure the field media
 */
$GLOBALS['TCA']['pages']['columns']['media']['config']['overrideChildTca']['columns']['crop']['config']['cropVariants'] = \LBRmedia\Bootstrap\Utility\PictureUtility::getTcaCropVariantsOverride(\LBRmedia\Bootstrap\Utility\PictureUtility::CROP_VARIANTS_PAGES_MEDIA);

// constrain max items in field media
$GLOBALS['TCA']['pages']['columns']['media']['config']['maxitems'] = 10;

$GLOBALS['TCA']['pages']['columns']['media']['config']['overrideChildTca']['types'] = [
    \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
        'showitem' => 'title,alternative,crop,--palette--;;filePalette',
    ],
];
