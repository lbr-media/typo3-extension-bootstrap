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

use LBRmedia\Bootstrap\Utility\PictureUtility;
use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

ExtensionManagementUtility::registerPageTSConfigFile(
    'bootstrap',
    'Configuration/TsConfig/Page/General.typoscript',
    'General'
);

ExtensionManagementUtility::registerPageTSConfigFile(
    'bootstrap',
    'Configuration/TsConfig/BackendLayouts/General.typoscript',
    'Backend Layouts'
);

ExtensionManagementUtility::registerPageTSConfigFile(
    'bootstrap',
    'Configuration/TsConfig/Page/TCEFORM.DisableUnusedFields.typoscript',
    'Disable unused fields'
);

/*
 * set cropVariants and palette to social media images
 */
$GLOBALS['TCA']['pages']['columns']['og_image']['config']['overrideChildTca']['types'] = [
    File::FILETYPE_IMAGE => [
        'showitem' => 'crop,--palette--;;filePalette',
    ],
];
$GLOBALS['TCA']['pages']['columns']['og_image']['config']['overrideChildTca']['columns']['crop']['config']['cropVariants'] = PictureUtility::getTcaCropVariantsOverride(PictureUtility::CROP_VARIANTS_SOCIAL_MEDIA);

$GLOBALS['TCA']['pages']['columns']['twitter_image']['config']['overrideChildTca']['types'] = [
    File::FILETYPE_IMAGE => [
        'showitem' => 'crop,--palette--;;filePalette',
    ],
];
$GLOBALS['TCA']['pages']['columns']['twitter_image']['config']['overrideChildTca']['columns']['crop']['config']['cropVariants'] = PictureUtility::getTcaCropVariantsOverride(PictureUtility::CROP_VARIANTS_SOCIAL_MEDIA);

/*
 * Configure the field media
 */
$GLOBALS['TCA']['pages']['columns']['media']['config']['overrideChildTca']['columns']['crop']['config']['cropVariants'] = PictureUtility::getTcaCropVariantsOverride(PictureUtility::CROP_VARIANTS_PAGES_MEDIA);

// constrain max items in field media
$GLOBALS['TCA']['pages']['columns']['media']['config']['maxitems'] = 10;

$GLOBALS['TCA']['pages']['columns']['media']['config']['overrideChildTca']['types'] = [
    File::FILETYPE_IMAGE => [
        'showitem' => 'title,alternative,crop,--palette--;;filePalette',
    ],
];
