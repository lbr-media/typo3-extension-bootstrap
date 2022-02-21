<?php

declare(strict_types=1);

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
}
