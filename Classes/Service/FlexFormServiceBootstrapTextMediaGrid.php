<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Service;

use LBRmedia\Bootstrap\Utility\BootstrapUtility;

/**
 * Flexform configurations for content element bootstrap_textmediagrid.
 */
class FlexFormServiceBootstrapTextMediaGrid extends FlexFormService implements FlexFormServiceInterface
{
    public function getConfiguration(string $xmlString): array
    {
        $this->initData($xmlString, self::TYPE_TT_CONTENT_BOOTSTRAP_TEXT_MEDIA_GRID);

        return $this->getConfigurationArray($this->data[self::TYPE_TT_CONTENT_BOOTSTRAP_TEXT_MEDIA_GRID]);
    }

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
        $mediaSpaceClasses = BootstrapUtility::getGridSpaceXYClasses($xmlArray['mediaitem']['space_x'], $xmlArray['mediaitem']['space_y']);
        $xmlArray['mediaitem']['row_space_classes'] = $mediaSpaceClasses['row'];
        $xmlArray['mediaitem']['col_space_classes'] = $mediaSpaceClasses['col'];

        // container for all media items
        $xmlArray['mediaitem']['row_classes'] = implode(
            ' ',
            [
                'row',
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

    protected function getConfigurationArray(array $data): array
    {
        $transformedData = [
            'order' => self::getFlexformValueByPath($data, 'data.sGENERAL.lDEF.order.vDEF', 'string', 'text_media', $this->logger),
            'header_position' => self::getFlexformValueByPath($data, 'data.sGENERAL.lDEF.header_position.vDEF', 'string', 'above_all', $this->logger),
            'device_order' => self::getFlexformValueByPath($data, 'data.sGENERAL.lDEF.device_order.vDEF', 'string', ';;;;;', $this->logger),
            'overflow_hidden' => self::getFlexformValueByPath($data, 'data.sGENERAL.lDEF.overflow_hidden.vDEF', 'bool', true, $this->logger),
            'col_text' => self::getFlexformValueByPath($data, 'data.sGENERAL.lDEF.col_text.vDEF', 'string', ';;;;;', $this->logger),
            'col_media' => self::getFlexformValueByPath($data, 'data.sGENERAL.lDEF.col_media.vDEF', 'string', ';;;;;', $this->logger),
            'space_y' => self::getFlexformValueByPath($data, 'data.sGENERAL.lDEF.space_y.vDEF', 'string', ';;;;;', $this->logger),
            'space_x' => self::getFlexformValueByPath($data, 'data.sGENERAL.lDEF.space_x.vDEF', 'string', ';;;;;', $this->logger),
            'align_items' => self::getFlexformValueByPath($data, 'data.sGENERAL.lDEF.align_items.vDEF', 'string', ';;;;;', $this->logger),
            'justify_content' => self::getFlexformValueByPath($data, 'data.sGENERAL.lDEF.justify_content.vDEF', 'string', ';;;;;', $this->logger),
            'media' => [
                'masonry_enabled' => self::getFlexformValueByPath($data, 'data.sMEDIA.lDEF.masonry_enabled.vDEF', 'bool', false, $this->logger),
                'masonry_data_masonry_attribute' => "",
                'align_self' => self::getFlexformValueByPath($data, 'data.sMEDIA.lDEF.align_self.vDEF', 'string', ';;;;;', $this->logger),
                'space_inner' => [
                    'xs' => self::getFlexformValueByPath($data, 'data.sMEDIA.lDEF.space_inner_xs.vDEF', 'string', ';;;;;;', $this->logger),
                    'sm' => self::getFlexformValueByPath($data, 'data.sMEDIA.lDEF.space_inner_sm.vDEF', 'string', ';;;;;;', $this->logger),
                    'md' => self::getFlexformValueByPath($data, 'data.sMEDIA.lDEF.space_inner_md.vDEF', 'string', ';;;;;;', $this->logger),
                    'lg' => self::getFlexformValueByPath($data, 'data.sMEDIA.lDEF.space_inner_lg.vDEF', 'string', ';;;;;;', $this->logger),
                    'xl' => self::getFlexformValueByPath($data, 'data.sMEDIA.lDEF.space_inner_xl.vDEF', 'string', ';;;;;;', $this->logger),
                    'xxl' => self::getFlexformValueByPath($data, 'data.sMEDIA.lDEF.space_inner_xxl.vDEF', 'string', ';;;;;;', $this->logger),
                ],
            ],
            'mediaoptimizing' => [
                'width' => [
                    'xs' => self::getFlexformValueByPath($data, 'data.sMEDIAOPTIMIZING.lDEF.width_xs.vDEF', 'int', 100, $this->logger),
                    'sm' => self::getFlexformValueByPath($data, 'data.sMEDIAOPTIMIZING.lDEF.width_sm.vDEF', 'int', 100, $this->logger),
                    'md' => self::getFlexformValueByPath($data, 'data.sMEDIAOPTIMIZING.lDEF.width_md.vDEF', 'int', 100, $this->logger),
                    'lg' => self::getFlexformValueByPath($data, 'data.sMEDIAOPTIMIZING.lDEF.width_lg.vDEF', 'int', 100, $this->logger),
                    'xl' => self::getFlexformValueByPath($data, 'data.sMEDIAOPTIMIZING.lDEF.width_xl.vDEF', 'int', 100, $this->logger),
                    'xxl' => self::getFlexformValueByPath($data, 'data.sMEDIAOPTIMIZING.lDEF.width_xxl.vDEF', 'int', 100, $this->logger),
                ],
            ],
            'text' => [
                'align_self' => self::getFlexformValueByPath($data, 'data.sTEXT.lDEF.align_self.vDEF', 'string', ';;;;;', $this->logger),
                'space_inner' => [
                    'xs' => self::getFlexformValueByPath($data, 'data.sTEXT.lDEF.space_inner_xs.vDEF', 'string', ';;;;;;', $this->logger),
                    'sm' => self::getFlexformValueByPath($data, 'data.sTEXT.lDEF.space_inner_sm.vDEF', 'string', ';;;;;;', $this->logger),
                    'md' => self::getFlexformValueByPath($data, 'data.sTEXT.lDEF.space_inner_md.vDEF', 'string', ';;;;;;', $this->logger),
                    'lg' => self::getFlexformValueByPath($data, 'data.sTEXT.lDEF.space_inner_lg.vDEF', 'string', ';;;;;;', $this->logger),
                    'xl' => self::getFlexformValueByPath($data, 'data.sTEXT.lDEF.space_inner_xl.vDEF', 'string', ';;;;;;', $this->logger),
                ],
            ],
            'mediaitem' => [
                'image_zoom' => self::getFlexformValueByPath($data, 'data.sMEDIA.lDEF.image_zoom.vDEF', 'bool', false, $this->logger),
                'col' => self::getFlexformValueByPath($data, 'data.sMEDIAITEM.lDEF.col.vDEF', 'string', ';;;;;', $this->logger),
                'space_y' => self::getFlexformValueByPath($data, 'data.sMEDIAITEM.lDEF.space_y.vDEF', 'string', ';;;;;', $this->logger),
                'space_x' => self::getFlexformValueByPath($data, 'data.sMEDIAITEM.lDEF.space_x.vDEF', 'string', ';;;;;', $this->logger),
                'align_items' => self::getFlexformValueByPath($data, 'data.sMEDIAITEM.lDEF.align_items.vDEF', 'string', ';;;;;', $this->logger),
                'justify_content' => self::getFlexformValueByPath($data, 'data.sMEDIAITEM.lDEF.justify_content.vDEF', 'string', ';;;;;', $this->logger),
            ],
        ];

        // Process presets which overrides some/all settings
        self::processPresets('bootstrap_textmediagrid', $data, $transformedData, 'data.sPRESETS.lDEF.presets.vDEF', $this->logger);

        // set masonry data attribute
        $transformedData['media']['masonry_data_masonry_attribute'] = $transformedData['media']['masonry_enabled'] 
            ? ' data-masonry=\'{"percentPosition":true}\''
            : "";
        
        return $transformedData;
    }
}
