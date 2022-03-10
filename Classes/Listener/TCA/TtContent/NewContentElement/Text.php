<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Listener\TCA\TtContent\NewContentElement;

use LBRmedia\Bootstrap\Service\TcaService;

class Text implements NewContentElementInterface
{
    public static function addPlugin(TcaService $tcaService): void
    {
        // Prepend bodytext with a div
        $GLOBALS['TCA']['tt_content']['types']['text']['showitem'] =
            $tcaService->setShowitems($GLOBALS['TCA']['tt_content']['types']['text']['showitem'])
                ->replaceShowItem('bodytext', '--div--;LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:tt_content.div.bodytext,bodytext')
                ->getShowitemsString();
    }
}
