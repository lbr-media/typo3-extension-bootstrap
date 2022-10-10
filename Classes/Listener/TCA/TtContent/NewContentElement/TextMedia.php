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

class TextMedia implements NewContentElementInterface
{
    public static function addPlugin(TcaService $tcaService): void
    {
        // Add flexform
        $GLOBALS['TCA']['tt_content']['columns']['tx_bootstrap_flexform']['config']['ds']['*,textmedia'] = 'FILE:EXT:bootstrap/Configuration/FlexForms/TtContent/BootstrapTextMediaFloat.xml';

        // Configure TCA
        $GLOBALS['TCA']['tt_content']['types']['textmedia'] = [
            'showitem' => $tcaService->setShowitems($GLOBALS['TCA']['tt_content']['types']['textmedia']['showitem'])
                ->addShowitemAfter('tx_bootstrap_flexform', 'frames')
                ->removeShowitems(['mediaAdjustments', 'gallerySettings', 'imagelinks'])
                ->getShowitemsString(),
            'columnsOverrides' => [
                'bodytext' => [
                    'config' => [
                        'enableRichtext' => true,
                    ],
                ],
                'assets' => [
                    'config' => [
                        'minitems' => 1,
                        'maxitems' => 10,
                        'overrideChildTca' => [
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

        $GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['textmedia'] = 'bootstrap_textmediafloat';
    }
}
