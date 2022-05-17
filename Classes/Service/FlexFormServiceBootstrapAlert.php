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
 * Flexform configuration for content element bootstrap_alert.
 */
class FlexFormServiceBootstrapAlert extends FlexFormService implements FlexFormServiceInterface
{
    /**
     * Gets the flexform configuration for this service and transforms it to a raw array.
     *
     * @param string $xmlString
     * @return array
     */
    public function getConfiguration(string $xmlString): array
    {
        $this->initData($xmlString, self::TYPE_TT_CONTENT_BOOTSTRAP_ALERT);

        return $this->getConfigurationArray($this->data[self::TYPE_TT_CONTENT_BOOTSTRAP_ALERT]);
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

        $xmlArray['border_classes'] = BootstrapUtility::getBorderOptionClasses($xmlArray['border']);

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
            'alert_type' => $this->getFlexformValueByPath($data, 'data.sALERT.lDEF.alert_type.vDEF', 'string', ''),
            'bg_color' => $this->getFlexformValueByPath($data, 'data.sALERT.lDEF.bg_color.vDEF', 'string', ''),
            'text_color' => $this->getFlexformValueByPath($data, 'data.sALERT.lDEF.text_color.vDEF', 'string', ''),
            'border' => $this->getFlexformValueByPath($data, 'data.sALERT.lDEF.border.vDEF', 'string', ';;;;'),
        ];

        return $transformedData;
    }
}
