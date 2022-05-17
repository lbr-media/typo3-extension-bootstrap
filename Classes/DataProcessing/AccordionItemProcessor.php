<?php

declare(strict_types=1);

/*
 * @package LBRmedia Bootstrap Template - Provides Twitter Bootstrap 5 and some content elements.
 * @version 1.0.22
 * @author Marcel Briefs <mb@lbrmedia.de>
 * @copyright 2022 LBRmedia
 * @link https://github.com/lbr-media/typo3-extension-bootstrap
 * @license GPL-2.0-or-later
 */

namespace LBRmedia\Bootstrap\DataProcessing;

use LBRmedia\Bootstrap\Domain\Repository\AccordionItemRepository;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;

/**
 * Data processor to get tt_content related accordion items.
 */
class AccordionItemProcessor implements DataProcessorInterface
{
    /**
     * @var AccordionItemRepository $accordionItemRepository
     */
    protected $accordionItemRepository;

    /**
     * @param AccordionItemRepository $accordionItemRepository
     */
    public function __construct(
        AccordionItemRepository $accordionItemRepository
    ) {
        $this->accordionItemRepository = $accordionItemRepository;
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
        $as = isset($processorConfiguration['as']) && is_string($processorConfiguration['as']) && trim($processorConfiguration['as']) ? trim($processorConfiguration['as']) : 'accordion_items';
        $processedData[$as] = [];
        $accordionItems = $this->accordionItemRepository->findByRelation('tt_content_uid', $processedData['data']['uid']);
        if ($accordionItems) {
            $processedData[$as] = $accordionItems->toArray();
        }

        return $processedData;
    }
}
