<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Service;

use LBRmedia\Bootstrap\Utility\BootstrapUtility;

/**
 * Flexform configurations for content element bootstrap_textimage.
 */
class FlexFormServiceBootstrapTextImage extends FlexFormService implements FlexFormServiceInterface
{
    public function getConfiguration(string $xmlString): array
    {
        $this->initData($xmlString, self::TYPE_TT_CONTENT_BOOTSTRAP_TEXTIMAGE);

        return $this->getConfigurationArray($this->data[self::TYPE_TT_CONTENT_BOOTSTRAP_TEXTIMAGE]);
    }

    public function process(string $xmlString): array
    {
        $xmlArray = $this->getConfiguration($xmlString);
        
        $xmlArray['space_classes'] = BootstrapUtility::getGridSpaceClasses($xmlArray['space']);
        $xmlArray['mediaitem']['border_classes'] = BootstrapUtility::getBorderOptionClasses($xmlArray['mediaitem']['border']);

        return $xmlArray;
    }

    protected function getConfigurationArray(array $data): array
    {
        $transformedData = [
            'order' => self::getFlexformValueByPath($data, 'data.sGENERAL.lDEF.order.vDEF', 'string', 'text_image', $this->logger),
            'text_align' => self::getFlexformValueByPath($data, 'data.sGENERAL.lDEF.text_align.vDEF', 'string', 'start', $this->logger),
            'image_align' => self::getFlexformValueByPath($data, 'data.sGENERAL.lDEF.image_align.vDEF', 'string', 'start', $this->logger),
            'header_position' => self::getFlexformValueByPath($data, 'data.sGENERAL.lDEF.header_position.vDEF', 'string', 'above_all', $this->logger),
            'space' => self::getFlexformValueByPath($data, 'data.sGENERAL.lDEF.space.vDEF', 'string', ';;;;;', $this->logger),
            'mediaitem' => [
                'border' => self::getFlexformValueByPath($data, 'data.sMEDIAITEM.lDEF.border.vDEF', 'string', ';;;;', $this->logger),
            ],
        ];

        // Process presets which overrides some/all settings
        self::processPresets('bootstrap_textimage', $data, $transformedData, 'data.sPRESETS.lDEF.presets.vDEF', $this->logger);

        return $transformedData;
    }
}
