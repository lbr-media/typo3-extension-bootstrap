<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Listener\TCA\TtContent\NewContentElement;

use LBRmedia\Bootstrap\Service\TcaService;
use LBRmedia\Bootstrap\Utility\GeneralUtility as BootstrapGeneralUtility;

class TextMedia implements NewContentElementInterface
{
    public static function addPlugin(TcaService $tcaService): void
    {
        /*
         * Set default cropVariants for field assets in content element textmedia
         */
        $GLOBALS['TCA']['tt_content']['types']['textmedia']['columnsOverrides']['assets']['config']['overrideChildTca']['columns']['crop']['config']['cropVariants'] = BootstrapGeneralUtility::getTcaCropVariantsOverride(['std', 'sm', 'md', 'lg', 'xl']);

        /*
         * Add FlexForm to textmedia
         */
        $GLOBALS['TCA']['tt_content']['columns']['tx_bootstrap_flexform']['config']['ds']['*,textmedia'] = 'FILE:EXT:bootstrap/Configuration/FlexForms/TtContent/TextMedia.xml';
        $GLOBALS['TCA']['tt_content']['types']['textmedia']['showitem'] = str_replace('frames,', 'frames,tx_bootstrap_flexform,', $GLOBALS['TCA']['tt_content']['types']['textmedia']['showitem']);
    }
}
