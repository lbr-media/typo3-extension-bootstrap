<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\DataProcessing;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use Exception;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;

/**
 * Converts a string into a list.
 */
class StringToListProcessor implements DataProcessorInterface
{
    /**
     * Process data for the content element "My new content element".
     *
     * @param ContentObjectRenderer $cObj                       The data of the content element or page
     * @param array                 $contentObjectConfiguration The configuration of Content Object
     * @param array                 $processorConfiguration     The configuration of this processor
     * @param array                 $processedData              Key/value store of processed data (e.g. to be passed to a Fluid View)
     *
     * @return array the processed data as key/value store
     */
    public function process(
        ContentObjectRenderer $cObj,
        array $contentObjectConfiguration,
        array $processorConfiguration,
        array $processedData
    ): array {
        if (!isset($processorConfiguration["field"])) {
            throw new Exception("You have to define a 'field' to process on", 1645523447);
        }

        if (!isset($processorConfiguration["as"])) {
            throw new Exception("You have to define an 'as' variable.", 1645523448);
        }

        if (!isset($processorConfiguration["splitChar"])) {
            throw new Exception("You have to define the 'splitChar'.", 1645523449);
        }

        $processedData[$processorConfiguration["as"]] = GeneralUtility::trimExplode($processorConfiguration["splitChar"], $processedData['data'][$processorConfiguration["field"]], true);

        if (isset($processorConfiguration["implodeChar"])) {
            $processedData[$processorConfiguration["as"]] = implode($processorConfiguration["implodeChar"] === ":space:" ? " " : $processorConfiguration["implodeChar"], $processedData[$processorConfiguration["as"]]);
        }

        return $processedData;
    }
}