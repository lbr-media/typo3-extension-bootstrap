<?php

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
use LBRmedia\Bootstrap\Service\FlexFormServiceTtContent;
use LBRmedia\Bootstrap\Utility\BootstrapUtility;

/**
 * Class for data processing for various content elements which use the extra fields defined in this extension.
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
     *
     * @return array the processed data as key/value store
     */
    public function process(
        ContentObjectRenderer $cObj,
        array $contentObjectConfiguration,
        array $processorConfiguration,
        array $processedData
    ): array {
        $processedData["grid"] = [];
        if (!trim($processedData['data']['tx_bootstrap_flexform'])) {
            return $processedData;
        }

        if (!isset($processorConfiguration["type"])) {
            throw new Exception("You have to define a FlexformService::TYPE*", 1645460359);
        }

        $type = "";
        switch ($processorConfiguration["type"]) {
            case "TYPE_TT_CONTENT_BOOTSTRAP_TEXT_MEDIA_GRID":
                $type = FlexFormServiceTtContent::TYPE_TT_CONTENT_BOOTSTRAP_TEXT_MEDIA_GRID;
                break;
        }

        try {
            // get the configuration from flexform
            /** @var FlexFormServiceTtContent $flexFormService */
            $flexFormService = GeneralUtility::makeInstance(FlexFormServiceTtContent::class);
            $xmlArray = $flexFormService->getConfiguration($processedData['data']['tx_bootstrap_flexform'], $type);
        } catch (Exception $e) {
            return $processedData;
        }

        switch ($type) {
            case FlexFormServiceTtContent::TYPE_TT_CONTENT_BOOTSTRAP_TEXT_MEDIA_GRID;
            $processedData["grid"] = self::processTextMediaGrid($xmlArray);
            break;
        }


        return $processedData;
    }

    protected static function processTextMediaGrid($xmlArray):array {
        $spaceClasses = BootstrapUtility::getGridSpaceXYClasses($xmlArray['space_x'], $xmlArray['space_y']);
        $xmlArray['row_space_classes'] = $spaceClasses['row'];
        $xmlArray['col_space_classes'] = $spaceClasses['col'];

        $xmlArray['row_classes'] = implode(
            ' ',
            [
                'row',
                'no-gutters',
                BootstrapUtility::getAlignmentClasses($xmlArray['align_items'], 'align-items-'),
                BootstrapUtility::getAlignmentClasses($xmlArray['justify_content'], 'justify-content-'),
            ]
        );

        $xmlArray['col_text_classes'] = BootstrapUtility::getColClasses($xmlArray['col_text']);
        $textAlignSelfClasses = BootstrapUtility::getAlignmentClasses($xmlArray['text']['align_self'], 'align-self-');
        if (trim($textAlignSelfClasses)) {
            $xmlArray['col_text_classes'] .= ' ' . $textAlignSelfClasses;
        }

        $xmlArray['col_media_classes'] = BootstrapUtility::getColClasses($xmlArray['col_media']);
        $mediaAlignSelfClasses = BootstrapUtility::getAlignmentClasses($xmlArray['media']['align_self'], 'align-self-');
        if (trim($mediaAlignSelfClasses)) {
            $xmlArray['col_media_classes'] .= ' ' . $mediaAlignSelfClasses;
        }

        // device_order
        if (isset($xmlArray['device_order']) && 4 === substr_count($xmlArray['device_order'], ';')) {
            $orderClasses = BootstrapUtility::getGridDeviceOrderClasses($xmlArray['device_order']);
            if ($orderClasses['text']) {
                $xmlArray['col_text_classes'] .= ' ' . $orderClasses['text'];
            }
            if ($orderClasses['media']) {
                $xmlArray['col_media_classes'] .= ' ' . $orderClasses['media'];
            }
        }

        // text
        $textItemClasses = [];

        $textPaddingClasses = BootstrapUtility::getPaddingClasses($xmlArray['text']['space_inner']);
        if (trim($textPaddingClasses)) {
            $textItemClasses[] = $textPaddingClasses;
        }

        $xmlArray['text']['item_classes'] = count($textItemClasses) ? implode(' ', $textItemClasses) : '';

        // media
        $mediaItemClasses = [];
        $mediaPaddingClasses = BootstrapUtility::getPaddingClasses($xmlArray['media']['space_inner']);
        if (trim($mediaPaddingClasses)) {
            $mediaItemClasses[] = $mediaPaddingClasses;
        }

        $xmlArray['media']['item_classes'] = count($mediaItemClasses) ? implode(' ', $mediaItemClasses) : '';

        // mediaitem
        $mediaSpaceClasses = BootstrapUtility::getGridSpaceXYClasses($xmlArray['mediaitem']['space_x'], $xmlArray['mediaitem']['space_y']);
        $xmlArray['mediaitem']['row_space_classes'] = $mediaSpaceClasses['row'];
        $xmlArray['mediaitem']['col_space_classes'] = $mediaSpaceClasses['col'];

        // container for all media items
        $xmlArray['mediaitem']['row_classes'] = implode(
            ' ',
            [
                'row',
                'no-gutters',
                BootstrapUtility::getAlignmentClasses($xmlArray['mediaitem']['align_items'], 'align-items-'),
                BootstrapUtility::getAlignmentClasses($xmlArray['mediaitem']['justify_content'], 'justify-content-'),
            ]
        );

        // a media item columne
        $xmlArray['mediaitem']['col_classes'] = BootstrapUtility::getColClasses($xmlArray['mediaitem']['col']);

        // the image
        $xmlArray['mediaitem']['img_classes'] = 'img-fluid';

        return $xmlArray;
    }
}
