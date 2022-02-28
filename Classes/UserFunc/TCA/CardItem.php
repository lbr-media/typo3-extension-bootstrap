<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\UserFunc\Tca;

use TYPO3\CMS\Backend\Utility\BackendUtility;

class CardItem
{
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
        $parameters['title'] = implode(", ", $titles);
    }
}
