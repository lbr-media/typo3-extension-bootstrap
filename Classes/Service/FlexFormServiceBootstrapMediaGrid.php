<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Service;

use LBRmedia\Bootstrap\Utility\BootstrapUtility;

/**
 * Flexform configurations for content element bootstrap_mediagrid.
 */
class FlexFormServiceBootstrapMediaGrid extends FlexFormService implements FlexFormServiceInterface
{
    public function getConfiguration(string $xmlString): array
    {
        $this->initData($xmlString, self::TYPE_TT_CONTENT_BOOTSTRAP_MEDIA_GRID);

        return $this->getConfigurationArray($this->data[self::TYPE_TT_CONTENT_BOOTSTRAP_MEDIA_GRID]);
    }

    public function process(string $xmlString): array
    {
        $xmlArray = $this->getConfiguration($xmlString);
        
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
            'media' => [
                'masonry_enabled' => self::getFlexformValueByPath($data, 'data.sMEDIA.lDEF.masonry_enabled.vDEF', 'bool', false, $this->logger),
                'masonry_data_masonry_attribute' => "",
            ],
            'mediaitem' => [
                'image_zoom' => self::getFlexformValueByPath($data, 'data.sMEDIA.lDEF.image_zoom.vDEF', 'bool', false, $this->logger),
                'border' => self::getFlexformValueByPath($data, 'data.sMEDIAITEM.lDEF.border.vDEF', 'string', ';;;;', $this->logger),
                'col' => self::getFlexformValueByPath($data, 'data.sMEDIAITEM.lDEF.col.vDEF', 'string', ';;;;;', $this->logger),
                'space_y' => self::getFlexformValueByPath($data, 'data.sMEDIAITEM.lDEF.space_y.vDEF', 'string', ';;;;;', $this->logger),
                'space_x' => self::getFlexformValueByPath($data, 'data.sMEDIAITEM.lDEF.space_x.vDEF', 'string', ';;;;;', $this->logger),
                'align_items' => self::getFlexformValueByPath($data, 'data.sMEDIAITEM.lDEF.align_items.vDEF', 'string', ';;;;;', $this->logger),
                'justify_content' => self::getFlexformValueByPath($data, 'data.sMEDIAITEM.lDEF.justify_content.vDEF', 'string', ';;;;;', $this->logger),
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
        ];

        // Process presets which overrides some/all settings
        self::processPresets('bootstrap_mediagrid', $data, $transformedData, 'data.sPRESETS.lDEF.presets.vDEF', $this->logger);

        // set masonry data attribute
        $transformedData['media']['masonry_data_masonry_attribute'] = $transformedData['media']['masonry_enabled'] 
            ? ' data-masonry=\'{"percentPosition":true}\''
            : "";

        return $transformedData;
    }
}
