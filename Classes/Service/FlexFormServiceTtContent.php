<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Service;

/**
 * Flexform configurations for content elements.
 */
class FlexFormServiceTtContent extends FlexFormService implements FlexFormServiceInterface
{
    /**
     * @param string $configurationType One of the constants
     */
    public function getConfiguration(string $xmlString, string $configurationType): array
    {
        $this->initData($xmlString, $configurationType);

        return $this->getConfigurationForType($configurationType);
    }

    /**
     * @param string $configurationType One of the constants
     */
    protected function getConfigurationForType(string $configurationType): array
    {
        switch ($configurationType) {
            case self::TYPE_TT_CONTENT_BOOTSTRAP_TEXT_MEDIA_GRID:
                return $this->getConfigurationArray_BootstrapTextMediaGrid($this->data[self::TYPE_TT_CONTENT_BOOTSTRAP_TEXT_MEDIA_GRID]);
                break;
            case self::TYPE_TT_CONTENT_BOOTSTRAP_TEXT_MEDIA_FLOAT:
                return $this->getConfigurationArray_BootstrapTextMediaFloat($this->data[self::TYPE_TT_CONTENT_BOOTSTRAP_TEXT_MEDIA_FLOAT]);
                break;
            case self::TYPE_TT_CONTENT_BOOTSTRAP_MEDIA_GRID:
                return $this->getConfigurationArray_BootstrapMediaGrid($this->data[self::TYPE_TT_CONTENT_BOOTSTRAP_MEDIA_GRID]);
                break;
        }
    }

    protected function getConfigurationArray_BootstrapTextMediaGrid(array $data): array
    {
        $masonryEnabled = $this->getFlexformValueByPath($data, 'data.sMEDIA.lDEF.masonry_enabled.vDEF', 'bool', false);
        return [
            'order' => $this->getFlexformValueByPath($data, 'data.sOUTER.lDEF.order.vDEF', 'string', 'text_media'),
            'header_position' => $this->getFlexformValueByPath($data, 'data.sOUTER.lDEF.header_position.vDEF', 'string', 'above_all'),
            'device_order' => $this->getFlexformValueByPath($data, 'data.sOUTER.lDEF.device_order.vDEF', 'string', ';;;;;'),
            'overflow_hidden' => $this->getFlexformValueByPath($data, 'data.sOUTER.lDEF.overflow_hidden.vDEF', 'bool', true),
            'col_text' => $this->getFlexformValueByPath($data, 'data.sOUTER.lDEF.col_text.vDEF', 'string', ';;;;;'),
            'col_media' => $this->getFlexformValueByPath($data, 'data.sOUTER.lDEF.col_media.vDEF', 'string', ';;;;;'),
            'space_y' => $this->getFlexformValueByPath($data, 'data.sOUTER.lDEF.space_y.vDEF', 'string', ';;;;;'),
            'space_x' => $this->getFlexformValueByPath($data, 'data.sOUTER.lDEF.space_x.vDEF', 'string', ';;;;;'),
            'align_items' => $this->getFlexformValueByPath($data, 'data.sOUTER.lDEF.align_items.vDEF', 'string', ';;;;;'),
            'justify_content' => $this->getFlexformValueByPath($data, 'data.sOUTER.lDEF.justify_content.vDEF', 'string', ';;;;;'),
            'media' => [
                'masonry_enabled' => $masonryEnabled,
                'masonry_data_masonry_attribute' => $masonryEnabled ? ' data-masonry=\'{"percentPosition":true}\'' : "",
                'align_self' => $this->getFlexformValueByPath($data, 'data.sMEDIA.lDEF.align_self.vDEF', 'string', ';;;;;'),
                'space_inner' => [
                    'xs' => $this->getFlexformValueByPath($data, 'data.sMEDIA.lDEF.space_inner_xs.vDEF', 'string', ';;;;;;'),
                    'sm' => $this->getFlexformValueByPath($data, 'data.sMEDIA.lDEF.space_inner_sm.vDEF', 'string', ';;;;;;'),
                    'md' => $this->getFlexformValueByPath($data, 'data.sMEDIA.lDEF.space_inner_md.vDEF', 'string', ';;;;;;'),
                    'lg' => $this->getFlexformValueByPath($data, 'data.sMEDIA.lDEF.space_inner_lg.vDEF', 'string', ';;;;;;'),
                    'xl' => $this->getFlexformValueByPath($data, 'data.sMEDIA.lDEF.space_inner_xl.vDEF', 'string', ';;;;;;'),
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
                'image_zoom' => $this->getFlexformValueByPath($data, 'data.sMEDIA.lDEF.image_zoom.vDEF', 'bool', false),
                'col' => $this->getFlexformValueByPath($data, 'data.sMEDIAITEM.lDEF.col.vDEF', 'string', ';;;;;'),
                'space_y' => $this->getFlexformValueByPath($data, 'data.sMEDIAITEM.lDEF.space_y.vDEF', 'string', ';;;;;'),
                'space_x' => $this->getFlexformValueByPath($data, 'data.sMEDIAITEM.lDEF.space_x.vDEF', 'string', ';;;;;'),
                'align_items' => $this->getFlexformValueByPath($data, 'data.sMEDIAITEM.lDEF.align_items.vDEF', 'string', ';;;;;'),
                'justify_content' => $this->getFlexformValueByPath($data, 'data.sMEDIAITEM.lDEF.justify_content.vDEF', 'string', ';;;;;'),
            ],
        ];
    }

    protected function getConfigurationArray_BootstrapTextMediaFloat(array $data): array
    {
        $masonryEnabled = $this->getFlexformValueByPath($data, 'data.sMEDIA.lDEF.masonry_enabled.vDEF', 'bool', false);
        return [
            'header_position' => $this->getFlexformValueByPath($data, 'data.sGENERAL.lDEF.header_position.vDEF', 'string', 'above_all'),
            'media_position' => $this->getFlexformValueByPath($data, 'data.sGENERAL.lDEF.media_position.vDEF', 'string', ';;;;;'),
            'media_size' => $this->getFlexformValueByPath($data, 'data.sGENERAL.lDEF.media_size.vDEF', 'string', ';;;;;'),
            'space_x' => $this->getFlexformValueByPath($data, 'data.sGENERAL.lDEF.space_x.vDEF', 'string', ';;;;;'),
            'space_y' => $this->getFlexformValueByPath($data, 'data.sGENERAL.lDEF.space_y.vDEF', 'string', ';;;;;'),
            'media' => [
                'masonry_enabled' => $masonryEnabled,
                'masonry_data_masonry_attribute' => $masonryEnabled ? ' data-masonry=\'{"percentPosition":true}\'' : "",
            ],
            'mediaitem' => [
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
    }

    protected function getConfigurationArray_BootstrapMediaGrid(array $data): array
    {
        $masonryEnabled = $this->getFlexformValueByPath($data, 'data.sMEDIA.lDEF.masonry_enabled.vDEF', 'bool', false);
        return [
            'media' => [
                'masonry_enabled' => $masonryEnabled,
                'masonry_data_masonry_attribute' => $masonryEnabled ? ' data-masonry=\'{"percentPosition":true}\'' : "",
            ],
            'mediaitem' => [
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
    }
}
