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
            'order' => $this->getFlexformValueByPath($data, 'data.sGENERAL.lDEF.order.vDEF', 'string', 'text_image'),
            'text_align' => $this->getFlexformValueByPath($data, 'data.sGENERAL.lDEF.text_align.vDEF', 'string', 'start'),
            'image_align' => $this->getFlexformValueByPath($data, 'data.sGENERAL.lDEF.image_align.vDEF', 'string', 'start'),
            'header_position' => $this->getFlexformValueByPath($data, 'data.sGENERAL.lDEF.header_position.vDEF', 'string', 'above_all'),
            'space' => $this->getFlexformValueByPath($data, 'data.sGENERAL.lDEF.space.vDEF', 'string', ';;;;;'),
            'mediaitem' => [
                'border' => $this->getFlexformValueByPath($data, 'data.sMEDIAITEM.lDEF.border.vDEF', 'string', ';;;;'),
            ],
        ];

        // Process presets which overrides some/all settings
        $this->processPresets('bootstrap_textimage', $data, $transformedData, 'data.sPRESETS.lDEF.presets.vDEF');

        return $transformedData;
    }
}
