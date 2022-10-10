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

use LBRmedia\Bootstrap\Domain\Repository\CardItemRepository;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;

/**
 * Data processor to get tt_content related card items.
 */
class CardItemProcessor implements DataProcessorInterface
{
    /**
     * @var TabulatorItemRepository $cardItemRepository
     */
    protected $cardItemRepository;

    /**
     * @param CardItemRepository $cardItemRepository
     */
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
     * @return array The processed data as key/value store
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
