<?php

declare(strict_types=1);

/*
 * @package LBRmedia Bootstrap Template - Provides Twitter Bootstrap 5 and some content elements.
 * @version 1.0.23
 * @author Marcel Briefs <mb@lbrmedia.de>
 * @copyright 2022 LBRmedia
 * @link https://github.com/lbr-media/typo3-extension-bootstrap
 * @license GPL-2.0-or-later
 */

namespace LBRmedia\Bootstrap\Service;

use LBRmedia\Bootstrap\Utility\BootstrapUtility;

/**
 * Flexform configuration for content element bootstrap_textmediagrid.
 */
class FlexFormServiceBootstrapTextMediaGrid extends FlexFormService implements FlexFormServiceInterface
{
    /**
     * Gets the flexform configuration for this service and transforms it to a raw array.
     *
     * @param string $xmlString
     * @return array
     */
    public function getConfiguration(string $xmlString): array
    {
        $this->initData($xmlString, self::TYPE_TT_CONTENT_BOOTSTRAP_TEXT_MEDIA_GRID);

        return $this->getConfigurationArray($this->data[self::TYPE_TT_CONTENT_BOOTSTRAP_TEXT_MEDIA_GRID]);
    }

    /**
     * Uses the raw flexform array and builds a modified array which can be used in templates.
     *
     * @param string $xmlString
     * @return array
     */
    public function process(string $xmlString): array
    {
        $xmlArray = $this->getConfiguration($xmlString);

        $spaceClasses = BootstrapUtility::getGridSpaceXYClasses($xmlArray['space_x'], $xmlArray['space_y']);
        $xmlArray['row_space_classes'] = $spaceClasses['row'];
        $xmlArray['col_space_classes'] = $spaceClasses['col'];

        $xmlArray['row_classes'] = implode(
            ' ',
            [
                'row',
                BootstrapUtility::getDeviceClasses($xmlArray['align_items'], 'align-items-'),
                BootstrapUtility::getDeviceClasses($xmlArray['justify_content'], 'justify-content-'),
            ]
        );

        $xmlArray['col_text_classes'] = BootstrapUtility::getColClasses($xmlArray['col_text']);
        $textAlignSelfClasses = BootstrapUtility::getDeviceClasses($xmlArray['text']['align_self'], 'align-self-');
        if (trim($textAlignSelfClasses)) {
            $xmlArray['col_text_classes'] .= ' ' . $textAlignSelfClasses;
        }

        $xmlArray['col_media_classes'] = BootstrapUtility::getColClasses($xmlArray['col_media']);
        $mediaAlignSelfClasses = BootstrapUtility::getDeviceClasses($xmlArray['media']['align_self'], 'align-self-');
        if (trim($mediaAlignSelfClasses)) {
            $xmlArray['col_media_classes'] .= ' ' . $mediaAlignSelfClasses;
        }

        // device_order
        if (isset($xmlArray['device_order']) && 5 === substr_count($xmlArray['device_order'], ';')) {
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
        $xmlArray['mediaitem']['image_zoom'] = $xmlArray['media']['image_zoom'];
        $xmlArray['mediaitem']['border_classes'] = BootstrapUtility::getBorderOptionClasses($xmlArray['mediaitem']['border']);
        $mediaSpaceClasses = BootstrapUtility::getGridSpaceXYClasses($xmlArray['mediaitem']['space_x'], $xmlArray['mediaitem']['space_y']);
        $xmlArray['mediaitem']['row_space_classes'] = $mediaSpaceClasses['row'];
        $xmlArray['mediaitem']['col_space_classes'] = $mediaSpaceClasses['col'];

        // container for all media items
        $xmlArray['mediaitem']['row_classes'] = implode(
            ' ',
            [
                'row',
                BootstrapUtility::getDeviceClasses($xmlArray['mediaitem']['align_items'], 'align-items-'),
                BootstrapUtility::getDeviceClasses($xmlArray['mediaitem']['justify_content'], 'justify-content-'),
            ]
        );

        // a media item columne
        $xmlArray['mediaitem']['col_classes'] = BootstrapUtility::getColClasses($xmlArray['mediaitem']['col']);

        // the image
        $xmlArray['mediaitem']['img_classes'] = 'img-fluid';

        return $xmlArray;
    }

    /**
     * Reads the flexform array and transforms the values to a raw array for futher processing.
     *
     * @param array $data
     * @return array
     */
    protected function getConfigurationArray(array $data): array
    {
        $transformedData = [
            'order' => $this->getFlexformValueByPath($data, 'data.sGENERAL.lDEF.order.vDEF', 'string', 'text_media'),
            'header_position' => $this->getFlexformValueByPath($data, 'data.sGENERAL.lDEF.header_position.vDEF', 'string', 'above_all'),
            'device_order' => $this->getFlexformValueByPath($data, 'data.sGENERAL.lDEF.device_order.vDEF', 'string', ';;;;;'),
            'overflow_hidden' => $this->getFlexformValueByPath($data, 'data.sGENERAL.lDEF.overflow_hidden.vDEF', 'bool', true),
            'col_text' => $this->getFlexformValueByPath($data, 'data.sGENERAL.lDEF.col_text.vDEF', 'string', ';;;;;'),
            'col_media' => $this->getFlexformValueByPath($data, 'data.sGENERAL.lDEF.col_media.vDEF', 'string', ';;;;;'),
            'space_y' => $this->getFlexformValueByPath($data, 'data.sGENERAL.lDEF.space_y.vDEF', 'string', ';;;;;'),
            'space_x' => $this->getFlexformValueByPath($data, 'data.sGENERAL.lDEF.space_x.vDEF', 'string', ';;;;;'),
            'align_items' => $this->getFlexformValueByPath($data, 'data.sGENERAL.lDEF.align_items.vDEF', 'string', ';;;;;'),
            'justify_content' => $this->getFlexformValueByPath($data, 'data.sGENERAL.lDEF.justify_content.vDEF', 'string', ';;;;;'),
            'media' => [
                'image_zoom' => $this->getFlexformValueByPath($data, 'data.sMEDIA.lDEF.image_zoom.vDEF', 'bool', false),
                'masonry_enabled' => $this->getFlexformValueByPath($data, 'data.sMEDIA.lDEF.masonry_enabled.vDEF', 'bool', false),
                'masonry_data_masonry_attribute' => '',
                'align_self' => $this->getFlexformValueByPath($data, 'data.sMEDIA.lDEF.align_self.vDEF', 'string', ';;;;;'),
                'space_inner' => [
                    'xs' => $this->getFlexformValueByPath($data, 'data.sMEDIA.lDEF.space_inner_xs.vDEF', 'string', ';;;;;;'),
                    'sm' => $this->getFlexformValueByPath($data, 'data.sMEDIA.lDEF.space_inner_sm.vDEF', 'string', ';;;;;;'),
                    'md' => $this->getFlexformValueByPath($data, 'data.sMEDIA.lDEF.space_inner_md.vDEF', 'string', ';;;;;;'),
                    'lg' => $this->getFlexformValueByPath($data, 'data.sMEDIA.lDEF.space_inner_lg.vDEF', 'string', ';;;;;;'),
                    'xl' => $this->getFlexformValueByPath($data, 'data.sMEDIA.lDEF.space_inner_xl.vDEF', 'string', ';;;;;;'),
                    'xxl' => $this->getFlexformValueByPath($data, 'data.sMEDIA.lDEF.space_inner_xxl.vDEF', 'string', ';;;;;;'),
                ],
            ],
            'mediaoptimizing' => [
                'width' => [
                    'xs' => $this->getFlexformValueByPath($data, 'data.sMEDIAOPTIMIZING.lDEF.width_xs.vDEF', 'int', 100),
                    'sm' => $this->getFlexformValueByPath($data, 'data.sMEDIAOPTIMIZING.lDEF.width_sm.vDEF', 'int', 100),
                    'md' => $this->getFlexformValueByPath($data, 'data.sMEDIAOPTIMIZING.lDEF.width_md.vDEF', 'int', 100),
                    'lg' => $this->getFlexformValueByPath($data, 'data.sMEDIAOPTIMIZING.lDEF.width_lg.vDEF', 'int', 100),
                    'xl' => $this->getFlexformValueByPath($data, 'data.sMEDIAOPTIMIZING.lDEF.width_xl.vDEF', 'int', 100),
                    'xxl' => $this->getFlexformValueByPath($data, 'data.sMEDIAOPTIMIZING.lDEF.width_xxl.vDEF', 'int', 100),
                ],
            ],
            'text' => [
                'align_self' => $this->getFlexformValueByPath($data, 'data.sTEXT.lDEF.align_self.vDEF', 'string', ';;;;;'),
                'space_inner' => [
                    'xs' => $this->getFlexformValueByPath($data, 'data.sTEXT.lDEF.space_inner_xs.vDEF', 'string', ';;;;;;'),
                    'sm' => $this->getFlexformValueByPath($data, 'data.sTEXT.lDEF.space_inner_sm.vDEF', 'string', ';;;;;;'),
                    'md' => $this->getFlexformValueByPath($data, 'data.sTEXT.lDEF.space_inner_md.vDEF', 'string', ';;;;;;'),
                    'lg' => $this->getFlexformValueByPath($data, 'data.sTEXT.lDEF.space_inner_lg.vDEF', 'string', ';;;;;;'),
                    'xl' => $this->getFlexformValueByPath($data, 'data.sTEXT.lDEF.space_inner_xl.vDEF', 'string', ';;;;;;'),
                ],
            ],
            'mediaitem' => [
                'border' => $this->getFlexformValueByPath($data, 'data.sMEDIAITEM.lDEF.border.vDEF', 'string', ';;;;'),
                'col' => $this->getFlexformValueByPath($data, 'data.sMEDIAITEM.lDEF.col.vDEF', 'string', ';;;;;'),
                'space_y' => $this->getFlexformValueByPath($data, 'data.sMEDIAITEM.lDEF.space_y.vDEF', 'string', ';;;;;'),
                'space_x' => $this->getFlexformValueByPath($data, 'data.sMEDIAITEM.lDEF.space_x.vDEF', 'string', ';;;;;'),
                'align_items' => $this->getFlexformValueByPath($data, 'data.sMEDIAITEM.lDEF.align_items.vDEF', 'string', ';;;;;'),
                'justify_content' => $this->getFlexformValueByPath($data, 'data.sMEDIAITEM.lDEF.justify_content.vDEF', 'string', ';;;;;'),
            ],
        ];

        // Process presets which overrides some/all settings
        $this->processPresets('bootstrap_textmediagrid', $data, $transformedData, 'data.sPRESETS.lDEF.presets.vDEF');

        // set masonry data attribute
        $transformedData['media']['masonry_data_masonry_attribute'] = $transformedData['media']['masonry_enabled']
            ? ' data-bs-masonry=\'{"percentPosition":true}\''
            : '';

        return $transformedData;
    }
}
