<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Service;

use LBRmedia\Bootstrap\Utility\GeneralUtility as BootstrapGeneralUtility;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class FlexFormService implements LoggerAwareInterface
{
    use LoggerAwareTrait;
    
    const TYPE_TT_CONTENT_BOOTSTRAP_TEXT_MEDIA_GRID = 'tt_content_bootstrap_textmediagrid';
    const TYPE_TT_CONTENT_BOOTSTRAP_TEXT_MEDIA_FLOAT = 'tt_content_bootstrap_textmediafloat';
    const TYPE_TT_CONTENT_BOOTSTRAP_MEDIA_GRID = 'tt_content_bootstrap_mediagrid';
    const TYPE_TT_CONTENT_BOOTSTRAP_ACCORDION = 'tt_content_bootstrap_accordion';
    const TYPE_TT_CONTENT_BOOTSTRAP_TABS = 'tt_content_bootstrap_tabs';

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
     * Helper function to get a value from the flexform array.
     */
    protected static function getFlexformValueByPath(array $data, string $path, string $type = 'string', $defaultValue = '', $logger = null)
    {
        $parts = explode(".", $path);
        foreach ($parts as $part) {
            if (isset($data[$part])) {
                $data = $data[$part];
            } else {
                if ($logger) {
                    $logger->error("Cannot get path in flexform data: ".$path);
                }
                return null;
            }
        }

        if (trim($data) === "") {
            return $defaultValue;
        }
        
        switch ($type) {
            case 'string':
                return (string) $data;
                break;
            case 'boolean':
            case 'bool':
                return (bool) $data;
                break;
            case 'integer':
            case 'int':
                return (int) $data;
                break;
        }

        return $data;
    }
}
