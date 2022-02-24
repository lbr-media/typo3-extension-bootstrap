<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Service;

/**
 * Flexform configurations for content element bootstrap_carousel.
 */
class FlexFormServiceBootstrapCarousel extends FlexFormService implements FlexFormServiceInterface
{
    public function getConfiguration(string $xmlString): array
    {
        $this->initData($xmlString, self::TYPE_TT_CONTENT_BOOTSTRAP_TABS);

        return $this->getConfigurationArray($this->data[self::TYPE_TT_CONTENT_BOOTSTRAP_TABS]);
    }

    public function process(string $xmlString): array
    {
        return $this->getConfiguration($xmlString);
    }

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
