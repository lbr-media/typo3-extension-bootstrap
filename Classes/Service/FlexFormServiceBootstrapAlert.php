<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Service;

use LBRmedia\Bootstrap\Utility\BootstrapUtility;

/**
 * Flexform configurations for content element bootstrap_alert.
 */
class FlexFormServiceBootstrapAlert extends FlexFormService implements FlexFormServiceInterface
{
    public function getConfiguration(string $xmlString): array
    {
        $this->initData($xmlString, self::TYPE_TT_CONTENT_BOOTSTRAP_ALERT);

        return $this->getConfigurationArray($this->data[self::TYPE_TT_CONTENT_BOOTSTRAP_ALERT]);
    }

    public function process(string $xmlString): array
    {
        $xmlArray = $this->getConfiguration($xmlString);

        $xmlArray['border_classes'] = BootstrapUtility::getBorderOptionClasses($xmlArray['border']);

        return $xmlArray;
    }

    protected function getConfigurationArray(array $data): array
    {
        $transformedData = [
            'alert_type' => self::getFlexformValueByPath($data, 'data.sALERT.lDEF.alert_type.vDEF', 'string', '', $this->logger),
            'bg_color' => self::getFlexformValueByPath($data, 'data.sALERT.lDEF.bg_color.vDEF', 'string', '', $this->logger),
            'text_color' => self::getFlexformValueByPath($data, 'data.sALERT.lDEF.text_color.vDEF', 'string', '', $this->logger),
            'border' => self::getFlexformValueByPath($data, 'data.sALERT.lDEF.border.vDEF', 'string', ';;;;', $this->logger),
        ];

        return $transformedData;
    }
}
