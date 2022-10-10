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
 * Explodes a string of $processedData['data'][$field] by $splitChar and stores it as $processedData[$as].
 * If $implodeChar is set, the array will be imploded.
 *
 * P.e. '1,2,3' will be transformed to [1, 2, 3] or '1 2 3'.
 *
 * Required parameters in $processorConfiguration:
 * - field
 * - as
 * - splitChar
 *
 * Additional parameters in $processorConfiguration:
 * - implodeChar (:space: will be transformed to ' ')
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
     * @return array The processed data as key/value store
     */
    public function process(
        ContentObjectRenderer $cObj,
        array $contentObjectConfiguration,
        array $processorConfiguration,
        array $processedData
    ): array {
        if (!isset($processorConfiguration['field'])) {
            throw new Exception("You have to define a 'field' to process on", 1645523447);
        }

        if (!isset($processorConfiguration['as'])) {
            throw new Exception("You have to define an 'as' variable.", 1645523448);
        }

        if (!isset($processorConfiguration['splitChar'])) {
            throw new Exception("You have to define the 'splitChar'.", 1645523449);
        }

        $processedData[$processorConfiguration['as']] = GeneralUtility::trimExplode($processorConfiguration['splitChar'], $processedData['data'][$processorConfiguration['field']], true);

        if (isset($processorConfiguration['implodeChar'])) {
            $processedData[$processorConfiguration['as']] = implode($processorConfiguration['implodeChar'] === ':space:' ? ' ' : $processorConfiguration['implodeChar'], $processedData[$processorConfiguration['as']]);
        }

        return $processedData;
    }
}
