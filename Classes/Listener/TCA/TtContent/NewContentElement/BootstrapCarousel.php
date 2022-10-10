<?php

declare(strict_types=1);

/*
 * @package LBRmedia Bootstrap Template - Provides Twitter Bootstrap 5 and some content elements.
 * @version 12.0.0
 * @author Marcel Briefs <mb@lbrmedia.de>
 * @copyright 2022 LBRmedia
 * @link https://github.com/lbr-media/typo3-extension-bootstrap
 * @license GPL-2.0-or-later
 */

namespace LBRmedia\Bootstrap\Listener\TCA\TtContent\NewContentElement;

use LBRmedia\Bootstrap\Service\TcaService;
use LBRmedia\Bootstrap\Utility\PictureUtility;
use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

class BootstrapCarousel implements NewContentElementInterface
{
    public static function addPlugin(TcaService $tcaService): void
    {
        // Add content element
        ExtensionManagementUtility::addPlugin(
            [
                'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:tt_content.CType.bootstrap_carousel',
                'bootstrap_carousel',
                'EXT:bootstrap/Resources/Public/Icons/TCA/bootstrap_carousel.svg',
            ],
            'CType',
            'bootstrap'
        );

        // Add flexform
        $GLOBALS['TCA']['tt_content']['columns']['tx_bootstrap_flexform']['config']['ds']['*,bootstrap_carousel'] = 'FILE:EXT:bootstrap/Configuration/FlexForms/TtContent/BootstrapCarousel.xml';

        // Configure TCA
        $GLOBALS['TCA']['tt_content']['types']['bootstrap_carousel'] = [
            'showitem' => $tcaService->setShowitems($GLOBALS['TCA']['tt_content']['types']['image']['showitem'])
                ->addShowitemAfter('tx_bootstrap_flexform', 'frames')
                ->removeShowitems(['mediaAdjustments', 'gallerySettings', 'imagelinks'])
                ->getShowitemsString(),
            'columnsOverrides' => [
                'image' => [
                    'config' => [
                        'minitems' => 1,
                        'maxitems' => 10,
                        'overrideChildTca' => [
                            'types' => [
                                File::FILETYPE_IMAGE => [
                                    'showitem' => '
                                        tx_bootstrap_header,
                                        --linebreak--,
                                        title,
                                        alternative,
                                        description,
                                        --linebreak--,
                                        link,
                                        tx_bootstrap_link_text,
                                        crop,
                                        --palette--;;filePalette',
                                ],
                            ],
                            'columns' => [
                                'crop' => [
                                    'config' => [
                                        'cropVariants' => PictureUtility::getTcaCropVariantsOverride(PictureUtility::CROP_VARIANTS_BOOTSTRAP),
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        // Icon in backend page view
        $GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['bootstrap_carousel'] = 'bootstrap_carousel';
    }
}
