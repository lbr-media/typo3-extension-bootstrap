<?php

declare(strict_types=1);

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
