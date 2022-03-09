<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Service;

use LBRmedia\Bootstrap\Utility\BootstrapUtility;

/**
 * Flexform configuration for content element bootstrap_textimage.
 */
class FlexFormServiceBootstrapTextImage extends FlexFormService implements FlexFormServiceInterface
{
    /**
     * Gets the flexform configuration for this service and transforms it to a raw array.
     *
     * @param string $xmlString
     * @return array
     */
    public function getConfiguration(string $xmlString): array
    {
        $this->initData($xmlString, self::TYPE_TT_CONTENT_BOOTSTRAP_TEXTIMAGE);

        return $this->getConfigurationArray($this->data[self::TYPE_TT_CONTENT_BOOTSTRAP_TEXTIMAGE]);
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

        $xmlArray['space_classes'] = BootstrapUtility::getGridSpaceClasses($xmlArray['space']);
        $xmlArray['mediaitem']['border_classes'] = BootstrapUtility::getBorderOptionClasses($xmlArray['mediaitem']['border']);

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
