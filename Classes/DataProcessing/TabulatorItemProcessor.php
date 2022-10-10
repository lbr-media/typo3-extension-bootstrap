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

use LBRmedia\Bootstrap\Domain\Repository\TabulatorItemRepository;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;

/**
 * Data processor to get tt_content related tabulator items.
 */
class TabulatorItemProcessor implements DataProcessorInterface
{
    /**
     * @var TabulatorItemRepository $tabulatorItemRepository
     */
    protected $tabulatorItemRepository;

    /**
     * @param TabulatorItemRepository $tabulatorItemRepository
     */
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
     * @return array The processed data as key/value store
     */
    public function process(
        ContentObjectRenderer $cObj,
        array $contentObjectConfiguration,
        array $processorConfiguration,
        array $processedData
    ): array {
        $as = isset($processorConfiguration['as']) && is_string($processorConfiguration['as']) && trim($processorConfiguration['as']) ? trim($processorConfiguration['as']) : 'tabulator_items';
        $processedData[$as] = [];
        $tabulatorItems = $this->tabulatorItemRepository->findByRelation('tt_content_uid', $processedData['data']['uid']);
        if ($tabulatorItems) {
            $processedData[$as] = $tabulatorItems->toArray();

            $hasActive = false;
            foreach ($processedData[$as] as $tabulatorItem) {
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
                $firstTabulatorItem = reset($processedData[$as]);
                $firstTabulatorItem->setActive(true);
            }
        }

        return $processedData;
    }
}
