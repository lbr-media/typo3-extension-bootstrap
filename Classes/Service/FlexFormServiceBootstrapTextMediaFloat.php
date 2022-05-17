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

namespace LBRmedia\Bootstrap\Service;

use LBRmedia\Bootstrap\Utility\BootstrapUtility;

/**
 * Flexform configuration for content element bootstrap_textmediafloat.
 */
class FlexFormServiceBootstrapTextMediaFloat extends FlexFormService implements FlexFormServiceInterface
{
    /**
     * Gets the flexform configuration for this service and transforms it to a raw array.
     *
     * @param string $xmlString
     * @return array
     */
    public function getConfiguration(string $xmlString): array
    {
        $this->initData($xmlString, self::TYPE_TT_CONTENT_BOOTSTRAP_TEXT_MEDIA_FLOAT);

        return $this->getConfigurationArray($this->data[self::TYPE_TT_CONTENT_BOOTSTRAP_TEXT_MEDIA_FLOAT]);
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

        $xmlArray['float_classes'] = BootstrapUtility::getFloatClasses($xmlArray['media_position']);
        $xmlArray['media_size_classes'] = BootstrapUtility::getFloatMediaSizeClasses($xmlArray['media_size'], $xmlArray['media_position'], $xmlArray['space_x'], $xmlArray['space_y']);

        // mediaitem
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
            'header_position' => $this->getFlexformValueByPath($data, 'data.sGENERAL.lDEF.header_position.vDEF', 'string', 'above_all'),
            'media_position' => $this->getFlexformValueByPath($data, 'data.sGENERAL.lDEF.media_position.vDEF', 'string', ';;;;;'),
            'media_size' => $this->getFlexformValueByPath($data, 'data.sGENERAL.lDEF.media_size.vDEF', 'string', ';;;;;'),
            'space_x' => $this->getFlexformValueByPath($data, 'data.sGENERAL.lDEF.space_x.vDEF', 'string', ';;;;;'),
            'space_y' => $this->getFlexformValueByPath($data, 'data.sGENERAL.lDEF.space_y.vDEF', 'string', ';;;;;'),
            'media' => [
                'masonry_enabled' => $this->getFlexformValueByPath($data, 'data.sMEDIA.lDEF.masonry_enabled.vDEF', 'bool', false),
                'masonry_data_masonry_attribute' => '',
            ],
            'mediaitem' => [
                'border' => $this->getFlexformValueByPath($data, 'data.sMEDIAITEM.lDEF.border.vDEF', 'string', ';;;;'),
                'image_zoom' => $this->getFlexformValueByPath($data, 'data.sMEDIA.lDEF.image_zoom.vDEF', 'bool', false),
                'col' => $this->getFlexformValueByPath($data, 'data.sMEDIAITEM.lDEF.col.vDEF', 'string', ';;;;;'),
                'space_y' => $this->getFlexformValueByPath($data, 'data.sMEDIAITEM.lDEF.space_y.vDEF', 'string', ';;;;;'),
                'space_x' => $this->getFlexformValueByPath($data, 'data.sMEDIAITEM.lDEF.space_x.vDEF', 'string', ';;;;;'),
                'align_items' => $this->getFlexformValueByPath($data, 'data.sMEDIAITEM.lDEF.align_items.vDEF', 'string', ';;;;;'),
                'justify_content' => $this->getFlexformValueByPath($data, 'data.sMEDIAITEM.lDEF.justify_content.vDEF', 'string', ';;;;;'),
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
        ];

        // Process presets which overrides some/all settings
        $this->processPresets('bootstrap_textmediafloat', $data, $transformedData, 'data.sPRESETS.lDEF.presets.vDEF');

        // set masonry data attribute
        $transformedData['media']['masonry_data_masonry_attribute'] = $transformedData['media']['masonry_enabled']
            ? ' data-bs-masonry=\'{"percentPosition":true}\''
            : '';

        return $transformedData;
    }
}
