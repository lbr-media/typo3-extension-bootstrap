<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\DataProcessing;

use LBRmedia\Bootstrap\Service\FlexFormServiceBootstrapAccordion;
use LBRmedia\Bootstrap\Service\FlexFormServiceBootstrapAlert;
use LBRmedia\Bootstrap\Service\FlexFormServiceBootstrapCards;
use LBRmedia\Bootstrap\Service\FlexFormServiceBootstrapCarousel;
use LBRmedia\Bootstrap\Service\FlexFormServiceBootstrapMediaGrid;
use LBRmedia\Bootstrap\Service\FlexFormServiceBootstrapTabs;
use LBRmedia\Bootstrap\Service\FlexFormServiceBootstrapTextImage;
use LBRmedia\Bootstrap\Service\FlexFormServiceBootstrapTextMediaFloat;
use LBRmedia\Bootstrap\Service\FlexFormServiceBootstrapTextMediaGrid;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;

/**
 * Class for data processing for various content elements which use the flexform field tx_bootstap_flexform.
 * Converts the flexform data into useable values in fluid template.
 *
 * If $processorConfiguration['CType'] is set, the given flexform transform will be used. Otherwise the content elements CType will be used.
 * Optionally $processorConfiguration['as'] can be used to define $processedData[$as].
 *
 * The following CType flexforms are supported:
 * - bootstrap_textmediagrid
 * - bootstrap_textmediafloat
 * - bootstrap_mediagrid
 * - bootstrap_accordion
 * - bootstrap_tabs
 * - bootstrap_carousel
 * - bootstrap_textimage
 * - bootstrap_cards
 * - bootstrap_alert
 */
class FlexFormProcessor implements DataProcessorInterface
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
        if (!trim($processedData['data']['tx_bootstrap_flexform'])) {
            return $processedData;
        }

        $CType = isset($processorConfiguration['CType']) ? $processorConfiguration['CType'] : $processedData['data']['CType'];
        switch ($CType) {
            case 'bootstrap_textmediagrid':
                /** @var FlexFormServiceBootstrapTextMediaGrid $flexFormService */
                $flexFormService = GeneralUtility::makeInstance(FlexFormServiceBootstrapTextMediaGrid::class);
                $as = isset($processorConfiguration['as']) && is_string($processorConfiguration['as']) && trim($processorConfiguration['as']) ? trim($processorConfiguration['as']) : 'grid';
                $processedData[$as] = $flexFormService->process($processedData['data']['tx_bootstrap_flexform']);
                break;
            case 'bootstrap_textmediafloat':
                /** @var FlexFormServiceBootstrapTextMediaFloat $flexFormService */
                $flexFormService = GeneralUtility::makeInstance(FlexFormServiceBootstrapTextMediaFloat::class);
                $as = isset($processorConfiguration['as']) && is_string($processorConfiguration['as']) && trim($processorConfiguration['as']) ? trim($processorConfiguration['as']) : 'grid';
                $processedData[$as] = $flexFormService->process($processedData['data']['tx_bootstrap_flexform']);
                break;
            case 'bootstrap_mediagrid':
                /** @var FlexFormServiceBootstrapMediaGrid $flexFormService */
                $flexFormService = GeneralUtility::makeInstance(FlexFormServiceBootstrapMediaGrid::class);
                $as = isset($processorConfiguration['as']) && is_string($processorConfiguration['as']) && trim($processorConfiguration['as']) ? trim($processorConfiguration['as']) : 'grid';
                $processedData[$as] = $flexFormService->process($processedData['data']['tx_bootstrap_flexform']);
                break;
            case 'bootstrap_accordion':
                /** @var FlexFormServiceBootstrapAccordion $flexFormService */
                $flexFormService = GeneralUtility::makeInstance(FlexFormServiceBootstrapAccordion::class);
                $as = isset($processorConfiguration['as']) && is_string($processorConfiguration['as']) && trim($processorConfiguration['as']) ? trim($processorConfiguration['as']) : 'accordion';
                $processedData[$as] = $flexFormService->process($processedData['data']['tx_bootstrap_flexform']);
                break;
            case 'bootstrap_tabs':
                /** @var FlexFormServiceBootstrapTabs $flexFormService */
                $flexFormService = GeneralUtility::makeInstance(FlexFormServiceBootstrapTabs::class);
                $as = isset($processorConfiguration['as']) && is_string($processorConfiguration['as']) && trim($processorConfiguration['as']) ? trim($processorConfiguration['as']) : 'tabulator';
                $processedData[$as] = $flexFormService->process($processedData['data']['tx_bootstrap_flexform']);
                break;
            case 'bootstrap_carousel':
                /** @var FlexFormServiceBootstrapCarousel $flexFormService */
                $flexFormService = GeneralUtility::makeInstance(FlexFormServiceBootstrapCarousel::class);
                $as = isset($processorConfiguration['as']) && is_string($processorConfiguration['as']) && trim($processorConfiguration['as']) ? trim($processorConfiguration['as']) : 'carousel';
                $processedData[$as] = $flexFormService->process($processedData['data']['tx_bootstrap_flexform']);
                break;
            case 'bootstrap_textimage':
                /** @var FlexFormServiceBootstrapTextImage $flexFormService */
                $flexFormService = GeneralUtility::makeInstance(FlexFormServiceBootstrapTextImage::class);
                $as = isset($processorConfiguration['as']) && is_string($processorConfiguration['as']) && trim($processorConfiguration['as']) ? trim($processorConfiguration['as']) : 'configuration';
                $processedData[$as] = $flexFormService->process($processedData['data']['tx_bootstrap_flexform']);
                break;
            case 'bootstrap_cards':
                /** @var FlexFormServiceBootstrapCards $flexFormService */
                $flexFormService = GeneralUtility::makeInstance(FlexFormServiceBootstrapCards::class);
                $as = isset($processorConfiguration['as']) && is_string($processorConfiguration['as']) && trim($processorConfiguration['as']) ? trim($processorConfiguration['as']) : 'configuration';
                $processedData[$as] = $flexFormService->process($processedData['data']['tx_bootstrap_flexform']);
                break;
            case 'bootstrap_alert':
                /** @var FlexFormServiceBootstrapAlert $flexFormService */
                $flexFormService = GeneralUtility::makeInstance(FlexFormServiceBootstrapAlert::class);
                $as = isset($processorConfiguration['as']) && is_string($processorConfiguration['as']) && trim($processorConfiguration['as']) ? trim($processorConfiguration['as']) : 'configuration';
                $processedData[$as] = $flexFormService->process($processedData['data']['tx_bootstrap_flexform']);
                break;
        }

        return $processedData;
    }
}
