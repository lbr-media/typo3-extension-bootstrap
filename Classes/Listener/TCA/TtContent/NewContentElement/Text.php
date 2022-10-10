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
