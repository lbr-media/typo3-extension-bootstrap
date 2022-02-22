<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\UserFunc\Tca;

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