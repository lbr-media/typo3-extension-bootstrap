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

use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;
use LBRmedia\Bootstrap\Domain\Repository\TabulatorItemRepository;

class TabulatorItemProcessor implements DataProcessorInterface
{
    /**
     * @var TabulatorItemRepository
     */
    protected $tabulatorItemRepository = null;

    public function __construct(TabulatorItemRepository $tabulatorItemRepository)
    {
        $this->tabulatorItemRepository = $tabulatorItemRepository;
    }

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
        $processedData['tabulator_items'] = [];
        $tabulatorItems = $this->tabulatorItemRepository->findByRelation('tt_content_uid', $processedData['data']['uid']);
        if ($tabulatorItems) {
            $processedData['tabulator_items'] = $tabulatorItems->toArray();

            $hasActive = false;
            foreach ($processedData['tabulator_items'] as $tabulatorItem) {
                // disable item when there is already an active tab
                if ($hasActive && $tabulatorItem->isActive()) {
                    $tabulatorItem->setActive(false);
                }

                // store active state for next run
                if ($tabulatorItem->isActive()) {
                    $hasActive = true;
                }
            }

            if (!$hasActive) {
                $firstTabulatorItem = reset($processedData['tabulator_items']);
                $firstTabulatorItem->setActive(true);
            }
        }

        return $processedData;
    }
}
