<?php

declare(strict_types=1);

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
            'animation' => self::getFlexformValueByPath($data, 'data.sCAROUSEL.lDEF.animation.vDEF', 'string', 'slide', $this->logger),
            'autoplay' => self::getFlexformValueByPath($data, 'data.sCAROUSEL.lDEF.autoplay.vDEF', 'bool', true, $this->logger),
            'color_scheme' => self::getFlexformValueByPath($data, 'data.sCAROUSEL.lDEF.color_scheme.vDEF', 'string', '', $this->logger),
            'controls' => self::getFlexformValueByPath($data, 'data.sCAROUSEL.lDEF.controls.vDEF', 'bool', true, $this->logger),
            'indicators' => self::getFlexformValueByPath($data, 'data.sCAROUSEL.lDEF.indicators.vDEF', 'bool', true, $this->logger),
            'interval' => self::getFlexformValueByPath($data, 'data.sCAROUSEL.lDEF.interval.vDEF', 'int', 2000, $this->logger),
        ];
    }
}
