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

use LBRmedia\Bootstrap\Utility\GeneralUtility as BootstrapGeneralUtility;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use TYPO3\CMS\Core\Log\Logger;
use TYPO3\CMS\Core\TypoScript\TypoScriptService;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class FlexFormService implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    const TYPE_TT_CONTENT_BOOTSTRAP_TEXT_MEDIA_GRID = 'tt_content_bootstrap_textmediagrid';
    const TYPE_TT_CONTENT_BOOTSTRAP_TEXT_MEDIA_FLOAT = 'tt_content_bootstrap_textmediafloat';
    const TYPE_TT_CONTENT_BOOTSTRAP_MEDIA_GRID = 'tt_content_bootstrap_mediagrid';
    const TYPE_TT_CONTENT_BOOTSTRAP_ACCORDION = 'tt_content_bootstrap_accordion';
    const TYPE_TT_CONTENT_BOOTSTRAP_TABS = 'tt_content_bootstrap_tabs';
    const TYPE_TT_CONTENT_BOOTSTRAP_TEXTIMAGE = 'tt_content_bootstrap_textimage';
    const TYPE_TT_CONTENT_BOOTSTRAP_CARDS = 'tt_content_bootstrap_cards';
    const TYPE_TT_CONTENT_BOOTSTRAP_ALERT = 'tt_content_bootstrap_alert';

    /**
     * Array with the flexform configuration converted from XML string.
     * Each configuration is in a sub array with the constant as key.
     *
     * @var array $data
     */
    protected $data = [];

    /**
     * @var array $pluginSettings
     */
    protected $pluginSettings;

    /**
     * Additional informations which might be usefull in getFlexformValueByPath()
     *
     * @var array
     */
    public array $additionalLoggerInfo = [];

    /**
     * @return ConfigurationManager
     */
    public static function getConfigurationManager()
    {
        return GeneralUtility::makeInstance(ConfigurationManager::class);
    }

    /**
     * Returns the TypoScript configuration in path: plugin.tx_bootstrap.settings.form.element as array.
     *
     * @return array
     */
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
     *
     * @param array $data
     * @param string $path
     * @param string $type
     * @param string $defaultValue
     * @param Logger $logger
     * @return mixed
     */
    protected function getFlexformValueByPath(array $data, string $path, string $type = 'string', $defaultValue = '', ?Logger $logger = null)
    {
        $parts = explode('.', $path);
        foreach ($parts as $part) {
            if (isset($data[$part])) {
                $data = $data[$part];
            } else {
                if ($this->logger) {
                    $this->logger->error(
                        'Cannot get path in flexform data.',
                        count($this->additionalLoggerInfo)
                                ? array_merge(['path' => $path], $this->additionalLoggerInfo)
                                : ['path' => $path]
                    );
                }
                return $defaultValue;
            }
        }

        if (trim($data) === '') {
            return $defaultValue;
        }

        switch ($type) {
            case 'string':
                return (string)$data;
                break;
            case 'boolean':
            case 'bool':
                return (bool)$data;
                break;
            case 'integer':
            case 'int':
                return (int)$data;
                break;
        }

        return $data;
    }

    /**
     * Process presets which overrides some/all settings
     *
     * @param string $CType           Content element to get the presets from. Must be: tt_content.$CTYPE.flexform_presets.
     * @param array  $data            The XML data array.
     * @param array  $transformedData The allready processed data where the presets will be merged and overwritten to.
     * @param string $path            The path in $data to get the preset keys.
     * @param Logger $logger
     */
    protected function processPresets(string $CType, array $data, array &$transformedData, string $path = "'data.sPRESETS.lDEF.presets.vDEF'", ?Logger $logger = null): void
    {
        $presets = $this->getFlexformValueByPath($data, $path, 'string', '', $logger);
        if ($presets) {
            $ts = BootstrapGeneralUtility::getFullTypoScript();
            if (isset($ts['tt_content.'][$CType . '.']['flexform_presets.']) && is_array($ts['tt_content.'][$CType . '.']['flexform_presets.'])) {
                /** @var TypoScriptService $typoScriptService */
                $typoScriptService = GeneralUtility::makeInstance(TypoScriptService::class);
                $plainTS = $typoScriptService->convertTypoScriptArrayToPlainArray($ts['tt_content.'][$CType . '.']['flexform_presets.']);

                $keys = GeneralUtility::trimExplode(',', $presets, true);
                foreach ($keys as $key) {
                    $ts = BootstrapGeneralUtility::getFullTypoScript();
                    if (isset($plainTS[$key]['configuration']) && is_array($plainTS[$key]['configuration'])) {
                        ArrayUtility::mergeRecursiveWithOverrule($transformedData, $plainTS[$key]['configuration'], false, true, true);
                    }
                }
            }
        }
    }
}
