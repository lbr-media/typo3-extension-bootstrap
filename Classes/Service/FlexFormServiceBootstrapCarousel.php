<?php

declare(strict_types=1);

/*
 * @package LBRmedia Bootstrap Template - Provides Twitter Bootstrap 5 and some content elements.
 * @version 1.0.23
 * @author Marcel Briefs <mb@lbrmedia.de>
 * @copyright 2022 LBRmedia
 * @link https://github.com/lbr-media/typo3-extension-bootstrap
 * @license GPL-2.0-or-later
 */

namespace LBRmedia\Bootstrap\Service;

/**
 * Flexform configuration for content element bootstrap_carousel.
 */
class FlexFormServiceBootstrapCarousel extends FlexFormService implements FlexFormServiceInterface
{
    /**
     * Gets the flexform configuration for this service and transforms it to a raw array.
     *
     * @param string $xmlString
     * @return array
     */
    public function getConfiguration(string $xmlString): array
    {
        $this->initData($xmlString, self::TYPE_TT_CONTENT_BOOTSTRAP_TABS);

        return $this->getConfigurationArray($this->data[self::TYPE_TT_CONTENT_BOOTSTRAP_TABS]);
    }

    /**
     * Uses the raw flexform array and builds a modified array which can be used in templates.
     *
     * @param string $xmlString
     * @return array
     */
    public function process(string $xmlString): array
    {
        return $this->getConfiguration($xmlString);
    }

    /**
     * Reads the flexform array and transforms the values to a raw array for futher processing.
     *
     * @param array $data
     * @return array
     */
    protected function getConfigurationArray(array $data): array
    {
        return [
            'animation' => $this->getFlexformValueByPath($data, 'data.sCAROUSEL.lDEF.animation.vDEF', 'string', 'slide'),
            'autoplay' => $this->getFlexformValueByPath($data, 'data.sCAROUSEL.lDEF.autoplay.vDEF', 'bool', true),
            'color_scheme' => $this->getFlexformValueByPath($data, 'data.sCAROUSEL.lDEF.color_scheme.vDEF', 'string', ''),
            'controls' => $this->getFlexformValueByPath($data, 'data.sCAROUSEL.lDEF.controls.vDEF', 'bool', true),
            'indicators' => $this->getFlexformValueByPath($data, 'data.sCAROUSEL.lDEF.indicators.vDEF', 'bool', true),
            'interval' => $this->getFlexformValueByPath($data, 'data.sCAROUSEL.lDEF.interval.vDEF', 'int', 2000),
        ];
    }
}
