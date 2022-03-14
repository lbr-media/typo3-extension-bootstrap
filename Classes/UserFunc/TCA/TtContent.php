<?php

declare(strict_types=1);

/*
 * @package LBRmedia Bootstrap Template - Provides Twitter Bootstrap 5 and some content elements.
 * @version 1.0.17
 * @author Marcel Briefs <mb@lbrmedia.de>
 * @copyright 2022 LBRmedia
 * @link https://github.com/lbr-media/typo3-extension-bootstrap
 * @license GPL-2.0-or-later
 */

namespace LBRmedia\Bootstrap\UserFunc\Tca;

use LBRmedia\Bootstrap\Utility\GeneralUtility as BootstrapGeneralUtility;

class TtContent
{
    /**
     * @param array                                                         $configuration
     * @param \TYPO3\CMS\Backend\Form\FormDataProvider\AbstractItemProvider $abstractItemProvider
     *
     * @return string
     */
    public function additionalStyles(&$configuration, &$abstractItemProvider)
    {
        $pluginSettings = BootstrapGeneralUtility::getFormElementPluginSettings();
        if (!is_array($pluginSettings['AdditionalStyles.'])) {
            throw new \Exception('You have to define key values pairs in plugin.tx_bootstrap.settings.form.element.AdditionalStyles in TsSetup!', 1621602708);
        }

        foreach ($pluginSettings['AdditionalStyles.'] as $key => $itemConfiguration) {
            $configuration['items'][$key] = [
                0 => isset($itemConfiguration['label']) ? $itemConfiguration['label'] : '',
                1 => isset($itemConfiguration['value']) ? $itemConfiguration['value'] : '',
            ];
        }

        ksort($configuration['items']);
    }

    /**
     * @param array $params
     */
    public function itemsProcFunc(&$params): void
    {
        /**
         * Add preset items to flexforms.
         * Searches for tt_content.[CType].flexform_presets.
         */
        if (isset($params['config']['CType']) && is_string($params['config']['CType'])) {
            $CType = $params['config']['CType'];
            $ts = BootstrapGeneralUtility::getFullTypoScript();
            if (isset($ts['tt_content.'][$CType . '.']['flexform_presets.']) && is_array($ts['tt_content.'][$CType . '.']['flexform_presets.'])) {
                foreach ($ts['tt_content.'][$CType . '.']['flexform_presets.'] as $key => $preset) {
                    if (isset($preset['label']) && is_string($preset['label']) && isset($preset['configuration.']) && is_array($preset['configuration.'])) {
                        $params['items'][] = [$preset['label'], substr($key, 0, -1)];
                    }
                }
            }
        }
    }
}
