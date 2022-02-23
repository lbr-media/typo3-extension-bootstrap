<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Service;

/**
 * Flexform configurations for content element bootstrap_accordion.
 */
class FlexFormServiceBootstrapAccordion extends FlexFormService implements FlexFormServiceInterface
{
    public function getConfiguration(string $xmlString): array
    {
        $this->initData($xmlString, self::TYPE_TT_CONTENT_BOOTSTRAP_ACCORDION);

        return $this->getConfigurationArray($this->data[self::TYPE_TT_CONTENT_BOOTSTRAP_ACCORDION]);
    }

    public function process(string $xmlString): array
    {
        return $this->getConfiguration($xmlString);
    }

    protected function getConfigurationArray(array $data): array
    {
        return [
            'keep_open' => self::getFlexformValueByPath($data, 'data.sACCORDION.lDEF.keep_open.vDEF', 'bool', false, $this->logger),
        ];
    }
}
