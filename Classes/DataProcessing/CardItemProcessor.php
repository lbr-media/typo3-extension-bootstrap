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

use LBRmedia\Bootstrap\Domain\Repository\CardItemRepository;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;

class CardItemProcessor implements DataProcessorInterface
{
    /**
     * @var TabulatorItemRepository
     */
    protected $cardItemRepository;

    public function __construct(CardItemRepository $cardItemRepository)
    {
        $this->cardItemRepository = $cardItemRepository;
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
        $as = isset($processorConfiguration['as']) && is_string($processorConfiguration['as']) && trim($processorConfiguration['as']) ? trim($processorConfiguration['as']) : 'card_items';
        $processedData[$as] = [];
        $cardItems = $this->cardItemRepository->findByRelation('tt_content_uid', $processedData['data']['uid']);
        if ($cardItems) {
            $processedData[$as] = $cardItems->toArray();
        }

        return $processedData;
    }
}
