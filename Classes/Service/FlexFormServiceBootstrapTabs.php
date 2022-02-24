<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Service;

/**
 * Flexform configurations for content element bootstrap_tabs.
 */
class FlexFormServiceBootstrapTabs extends FlexFormService implements FlexFormServiceInterface
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
            'layout' => self::getFlexformValueByPath($data, 'data.sTABS.lDEF.layout.vDEF', 'string', 'default', $this->logger),
            'nav_orientation' => self::getFlexformValueByPath($data, 'data.sTABS.lDEF.nav_orientation.vDEF', 'string', '', $this->logger),
        ];
    }
}
