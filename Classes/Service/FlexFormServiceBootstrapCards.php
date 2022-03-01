<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Service;

use LBRmedia\Bootstrap\Utility\BootstrapUtility;

/**
 * Flexform configurations for content element bootstrap_cards.
 */
class FlexFormServiceBootstrapCards extends FlexFormService implements FlexFormServiceInterface
{
    public function getConfiguration(string $xmlString): array
    {
        $this->initData($xmlString, self::TYPE_TT_CONTENT_BOOTSTRAP_CARDS);

        return $this->getConfigurationArray($this->data[self::TYPE_TT_CONTENT_BOOTSTRAP_CARDS]);
    }

    public function process(string $xmlString): array
    {
        $xmlArray = $this->getConfiguration($xmlString);
        
        // mediaitem
        $mediaSpaceClasses = BootstrapUtility::getGridSpaceXYClasses($xmlArray['grid']['space_x'], $xmlArray['grid']['space_y']);
        $xmlArray['grid']['row_space_classes'] = $mediaSpaceClasses['row'];
        $xmlArray['grid']['col_space_classes'] = $mediaSpaceClasses['col'];

        // container for all media items
        $xmlArray['grid']['row_classes'] = implode(
            ' ',
            [
                'row',
                BootstrapUtility::getAlignmentClasses($xmlArray['grid']['align_items'], 'align-items-'),
                BootstrapUtility::getAlignmentClasses($xmlArray['grid']['justify_content'], 'justify-content-'),
            ]
        );

        // a media item columne
        $xmlArray['grid']['col_classes'] = BootstrapUtility::getColClasses($xmlArray['grid']['col']);

        return $xmlArray;
    }

    protected function getConfigurationArray(array $data): array
    {
        $transformedData = [
            'grid' => [
                'col' => self::getFlexformValueByPath($data, 'data.sGRID.lDEF.col.vDEF', 'string', ';;;;;', $this->logger),
                'space_y' => self::getFlexformValueByPath($data, 'data.sGRID.lDEF.space_y.vDEF', 'string', ';;;;;', $this->logger),
                'space_x' => self::getFlexformValueByPath($data, 'data.sGRID.lDEF.space_x.vDEF', 'string', ';;;;;', $this->logger),
                'align_items' => self::getFlexformValueByPath($data, 'data.sGRID.lDEF.align_items.vDEF', 'string', ';;;;;', $this->logger),
                'justify_content' => self::getFlexformValueByPath($data, 'data.sGRID.lDEF.justify_content.vDEF', 'string', ';;;;;', $this->logger),
                'image_position' => self::getFlexformValueByPath($data, 'data.sGRID.lDEF.image_position.vDEF', 'string', 'above', $this->logger),
            ],
            'card' => [
                'image_position' => self::getFlexformValueByPath($data, 'data.sCARD.lDEF.image_position.vDEF', 'string', 'above', $this->logger),
                'bg_color' => self::getFlexformValueByPath($data, 'data.sCARD.lDEF.bg_color.vDEF', 'string', '', $this->logger),
                'text_color' => self::getFlexformValueByPath($data, 'data.sCARD.lDEF.text_color.vDEF', 'string', '', $this->logger),
                'border_color' => self::getFlexformValueByPath($data, 'data.sCARD.lDEF.border_color.vDEF', 'string', '', $this->logger),
                'border_width' => self::getFlexformValueByPath($data, 'data.sCARD.lDEF.border_width.vDEF', 'string', '', $this->logger),
                'button_color' => self::getFlexformValueByPath($data, 'data.sCARD.lDEF.button_color.vDEF', 'string', '', $this->logger),
                'shadow' => self::getFlexformValueByPath($data, 'data.sCARD.lDEF.shadow.vDEF', 'string', '', $this->logger),
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
        self::processPresets('bootstrap_cards', $data, $transformedData, 'data.sPRESETS.lDEF.presets.vDEF', $this->logger);

        return $transformedData;
    }
}
