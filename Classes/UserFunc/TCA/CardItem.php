<?php

declare(strict_types=1);

/*
 * @package LBRmedia Bootstrap Template - Provides Twitter Bootstrap 5 and some content elements.
 * @version 1.0.17
 * @author Marcel Briefs <mb@lbrmedia.de>
 * @copyright 2022 LBRmedia
 * @link https://github.com/lbr-media/typo3-extension-bootstrap
 * @license GPL-2.0-or-later
 */

namespace LBRmedia\Bootstrap\UserFunc\Tca;

use TYPO3\CMS\Backend\Utility\BackendUtility;

class CardItem
{
    /**
     * Gets the title in TCA for CardItems.
     *
     * @param array $parameters
     */
    public function title(&$parameters)
    {
        $record = BackendUtility::getRecord($parameters['table'], $parameters['row']['uid']);
        $titles = [];

        if (isset($record['header']) && $record['header']) {
            $titles[] = $record['header'];
        }

        if (isset($record['title']) && $record['title']) {
            $titles[] = $record['title'];
        }

        // show footer if header and title is empty
        if (empty($titles) && isset($record['footer']) && $record['footer']) {
            $titles[] = $record['footer'];
        }

        $parameters['title'] = implode(', ', $titles);
    }
}
