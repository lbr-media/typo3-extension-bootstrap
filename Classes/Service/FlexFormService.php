<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Service;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use LBRmedia\Bootstrap\Utility\GeneralUtility as BootstrapGeneralUtility;

class FlexFormService
{
    const TYPE_TT_CONTENT_BOOTSTRAP_TEXT_MEDIA_GRID = 'TtContentBootstrapTextMediaGrid';
    const TYPE_TT_CONTENT_BOOTSTRAP_TEXT_MEDIA_FLOAT = 'TtContentBootstrapTextMediaFloat';

    /**
     * Array with the flexform configuration converted from XML string.
     * Each configuration is in a sub array with the constant as key.
     *
     * @var array
     */
    protected $data = [];

    /**
     * @var array
     */
    protected $pluginSettings = null;

    /**
     * @return ConfigurationManager
     */
    public static function getConfigurationManager()
    {
        return GeneralUtility::makeInstance(ConfigurationManager::class);
    }

    public function getPluginSettings(): array
    {
        if (null === $this->pluginSettings) {
            $settings = BootstrapGeneralUtility::getFormElementPluginSettings();
            $this->pluginSettings = isset($settings) && is_array($settings) ? $settings : [];
        }

        return $this->pluginSettings;
    }



    /**
     * @param string $xmlString
     * @param string $configurationType One of the constants
     */
    protected function initData($xmlString, $configurationType): void
    {
        // get the configuration from xml
        try {
            $this->data[$configurationType] = GeneralUtility::xml2array($xmlString);
        } catch (\Exception $e) {
            throw new \Exception('Could not convert xml to array.', 1495663497);
        }
    }

    /**
     * Helper function to get one value out of the flexform data.
     *
     * @param string $pointer
     * @param string $type
     * @param mixed  $defaultValue
     *
     * @return mixed
     */
    protected function getFlexformValue($pointer, string $type = 'string', $defaultValue = '')
    {
        if (!isset($pointer)) {
            return $defaultValue;
        }
        switch ($type) {
            case 'string':
                return (string) $pointer;
                break;
            case 'boolean':
            case 'bool':
                return (bool) $pointer;
                break;
            case 'integer':
            case 'int':
                return (int) $pointer;
                break;
        }

        return $pointer;
    }
}
