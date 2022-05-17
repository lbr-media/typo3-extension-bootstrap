<?php

declare(strict_types=1);

/*
 * @package LBRmedia Bootstrap Template - Provides Twitter Bootstrap 5 and some content elements.
 * @version 1.0.22
 * @author Marcel Briefs <mb@lbrmedia.de>
 * @copyright 2022 LBRmedia
 * @link https://github.com/lbr-media/typo3-extension-bootstrap
 * @license GPL-2.0-or-later
 */

namespace LBRmedia\Bootstrap\UserFunc\TCA;

use LBRmedia\Bootstrap\Utility\GeneralUtility as BootstrapGeneralUtility;

class TtContentHeader
{
    /**
     * @param array                                                         $configuration
     * @param \TYPO3\CMS\Backend\Form\FormDataProvider\AbstractItemProvider $abstractItemProvider
     *
     * @return string
     */
    public function predefinedHeader(&$configuration, &$abstractItemProvider)
    {
        $pluginSettings = BootstrapGeneralUtility::getFormElementPluginSettings();
        if (!is_array($pluginSettings['PredefinedHeader.'])) {
            throw new \Exception('You have to define key values pairs in plugin.tx_bootstrap.settings.form.element.PredefinedHeader in TsSetup!', 1616740168);
        }

        $configuration['items'][] = [
            0 => '',
            1 => '',
        ];

        foreach ($pluginSettings['PredefinedHeader.'] as $key => $itemConfiguration) {
            $configuration['items'][$key] = [
                0 => isset($itemConfiguration['label']) ? $itemConfiguration['label'] : '',
                1 => isset($itemConfiguration['value']) ? $itemConfiguration['value'] : '',
            ];
        }
        ksort($configuration['items']);
    }

    /**
     * @param array                                                         $configuration
     * @param \TYPO3\CMS\Backend\Form\FormDataProvider\AbstractItemProvider $abstractItemProvider
     *
     * @return string
     */
    public function additionalHeaderStyles(&$configuration, &$abstractItemProvider)
    {
        $pluginSettings = BootstrapGeneralUtility::getFormElementPluginSettings();
        if (!is_array($pluginSettings['AdditionalHeaderStyles.'])) {
            throw new \Exception('You have to define key values pairs in plugin.tx_bootstrap.settings.form.element.AdditionalHeaderStyles in TsSetup!', 1616740169);
        }

        foreach ($pluginSettings['AdditionalHeaderStyles.'] as $key => $itemConfiguration) {
            $configuration['items'][$key] = [
                0 => isset($itemConfiguration['label']) ? $itemConfiguration['label'] : '',
                1 => isset($itemConfiguration['value']) ? $itemConfiguration['value'] : '',
            ];
        }

        ksort($configuration['items']);
    }
}
