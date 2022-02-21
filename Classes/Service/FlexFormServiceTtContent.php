<?php

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
                return $this->getConfigurationArray_TextMediaGrid($this->data[self::TYPE_TT_CONTENT_BOOTSTRAP_TEXT_MEDIA_GRID]);
                break;
        }
    }

    protected function getConfigurationArray_TextMediaGrid(array $data): array
    {
        return [
            'order' => $this->getFlexformValue($data['data']['sOUTER']['lDEF']['order']['vDEF'], 'string', 'text_media'),
            'header_position' => $this->getFlexformValue($data['data']['sOUTER']['lDEF']['header_position']['vDEF'], 'string', 'above_all'),
            'device_order' => $this->getFlexformValue($data['data']['sOUTER']['lDEF']['device_order']['vDEF'], 'string', ';;;;;'),
            'overflow_hidden' => $this->getFlexformValue($data['data']['sOUTER']['lDEF']['overflow_hidden']['vDEF'], 'bool', true),
            'col_text' => $this->getFlexformValue($data['data']['sOUTER']['lDEF']['col_text']['vDEF'], 'string', ';;;;;'),
            'col_media' => $this->getFlexformValue($data['data']['sOUTER']['lDEF']['col_media']['vDEF'], 'string', ';;;;;'),
            'space_y' => $this->getFlexformValue($data['data']['sOUTER']['lDEF']['space_y']['vDEF'], 'string', ';;;;;'),
            'space_x' => $this->getFlexformValue($data['data']['sOUTER']['lDEF']['space_x']['vDEF'], 'string', ';;;;;'),
            'align_items' => $this->getFlexformValue($data['data']['sOUTER']['lDEF']['align_items']['vDEF'], 'string', ';;;;;'),
            'justify_content' => $this->getFlexformValue($data['data']['sOUTER']['lDEF']['justify_content']['vDEF'], 'string', ';;;;;'),
            'media' => [
                'align_self' => $this->getFlexformValue($data['data']['sMEDIA']['lDEF']['align_self']['vDEF'], 'string', ';;;;;'),
                'space_inner' => [
                    'std' => $this->getFlexformValue($data['data']['sMEDIA']['lDEF']['space_inner_std']['vDEF'], 'string', ';;;;;;'),
                    'sm' => $this->getFlexformValue($data['data']['sMEDIA']['lDEF']['space_inner_sm']['vDEF'], 'string', ';;;;;;'),
                    'md' => $this->getFlexformValue($data['data']['sMEDIA']['lDEF']['space_inner_md']['vDEF'], 'string', ';;;;;;'),
                    'lg' => $this->getFlexformValue($data['data']['sMEDIA']['lDEF']['space_inner_lg']['vDEF'], 'string', ';;;;;;'),
                    'xl' => $this->getFlexformValue($data['data']['sMEDIA']['lDEF']['space_inner_xl']['vDEF'], 'string', ';;;;;;'),
                ],
            ],
            'mediaoptimizing' => [
                'width' => [
                    'xs' => $this->getFlexformValue($data['data']['sMEDIAOPTIMIZING']['lDEF']['width_xs']['vDEF'], 'int', 100),
                    'sm' => $this->getFlexformValue($data['data']['sMEDIAOPTIMIZING']['lDEF']['width_sm']['vDEF'], 'int', 100),
                    'md' => $this->getFlexformValue($data['data']['sMEDIAOPTIMIZING']['lDEF']['width_md']['vDEF'], 'int', 100),
                    'lg' => $this->getFlexformValue($data['data']['sMEDIAOPTIMIZING']['lDEF']['width_lg']['vDEF'], 'int', 100),
                    'xl' => $this->getFlexformValue($data['data']['sMEDIAOPTIMIZING']['lDEF']['width_xl']['vDEF'], 'int', 100),
                ],
            ],
            'text' => [
                'align_self' => $this->getFlexformValue($data['data']['sTEXT']['lDEF']['align_self']['vDEF'], 'string', ';;;;;'),
                'space_inner' => [
                    'std' => $this->getFlexformValue($data['data']['sTEXT']['lDEF']['space_inner_std']['vDEF'], 'string', ';;;;;;'),
                    'sm' => $this->getFlexformValue($data['data']['sTEXT']['lDEF']['space_inner_sm']['vDEF'], 'string', ';;;;;;'),
                    'md' => $this->getFlexformValue($data['data']['sTEXT']['lDEF']['space_inner_md']['vDEF'], 'string', ';;;;;;'),
                    'lg' => $this->getFlexformValue($data['data']['sTEXT']['lDEF']['space_inner_lg']['vDEF'], 'string', ';;;;;;'),
                    'xl' => $this->getFlexformValue($data['data']['sTEXT']['lDEF']['space_inner_xl']['vDEF'], 'string', ';;;;;;'),
                ],
            ],
            'mediaitem' => [
                'image_zoom' => $this->getFlexformValue($data['data']['sMEDIAITEM']['lDEF']['image_zoom']['vDEF'], 'bool', false),
                'col' => $this->getFlexformValue($data['data']['sMEDIAITEM']['lDEF']['col']['vDEF'], 'string', ';;;;;'),
                'space_y' => $this->getFlexformValue($data['data']['sMEDIAITEM']['lDEF']['space_y']['vDEF'], 'string', ';;;;;'),
                'space_x' => $this->getFlexformValue($data['data']['sMEDIAITEM']['lDEF']['space_x']['vDEF'], 'string', ';;;;;'),
                'align_items' => $this->getFlexformValue($data['data']['sMEDIAITEM']['lDEF']['align_items']['vDEF'], 'string', ';;;;;'),
                'justify_content' => $this->getFlexformValue($data['data']['sMEDIAITEM']['lDEF']['justify_content']['vDEF'], 'string', ';;;;;'),
            ],
        ];
    }
}
