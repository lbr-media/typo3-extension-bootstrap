<?php

namespace LBRmedia\Bootstrap\Form\Element;

use LBRmedia\Bootstrap\Service\FlexFormService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\StringUtility;

/**
 * This is rendered for type=text, renderType=bootstrapDevices.
 */
class BootstrapDevicesElement extends \TYPO3\CMS\Backend\Form\Element\AbstractFormElement
{
    /**
     * Render single element.
     *
     * @return array As defined in initializeResultArray() of AbstractNode
     */
    public function render(): array
    {
        $resultArray = $this->initializeResultArray();
        $parameterArray = $this->data['parameterArray'];
        $config = $parameterArray['fieldConf']['config'];

        // Initialization:
        $selectId = StringUtility::getUniqueId('tceforms-bootstrapDevices-');

        $itemFormElValue = $config['default'];
        if (!empty($parameterArray['itemFormElValue'])) {
            $itemFormElValue = (string) $parameterArray['itemFormElValue'];
        }

        /** @var FlexFormService $flexFormService */
        $flexFormService = GeneralUtility::makeInstance(FlexFormService::class);
        $pluginSettings = $flexFormService->getPluginSettings();

        if (!isset($pluginSettings[$config['elementConfiguration'].'.']) || !is_array($pluginSettings[$config['elementConfiguration'].'.'])) {
            throw new \Exception('You have to define key values pairs in plugin.tx_bootstrap.settings.form.element.'.$config['elementConfiguration'].' in TsConfig!', 1495437999);
        }
        $elementConfiguration = $pluginSettings[$config['elementConfiguration'].'.'];

        if (!is_array($elementConfiguration)) {
            throw new \Exception('You have to define key values pairs in plugin.tx_bootstrap.settings.form.element '.$config['elementConfiguration'].' in TsSetup!', 1495438665);
        }

        $options = [];
        foreach ($elementConfiguration as $value => $label) {
            $options[] = '<option value="'.$value.'">'.$label.'</option>';
        }

        $html = [];
        $html[] = '<div class="formengine-field-item t3js-formengine-field-item">';
        $html[] = '<div class="form-control-wrap">';
        $html[] = '<div class="form-wizards-wrap">';
        $html[] = '<div class="form-wizards-element">';

        $html[] = '<div class="form-control-inline-element">';
        $html[] = '<label for="'.$selectId.'-xs">XS</label>';
        $html[] = '<select class="form-control form-control-adapt" id="'.$selectId.'-xs">';
        $html[] = implode(LF, $options);
        $html[] = '</select>';
        $html[] = '</div>';

        $html[] = '<div class="form-control-inline-element">';
        $html[] = '<label for="'.$selectId.'-sm">SM</label>';
        $html[] = '<select class="form-control form-control-adapt" id="'.$selectId.'-sm">';
        $html[] = implode(LF, $options);
        $html[] = '</select>';
        $html[] = '</div>';

        $html[] = '<div class="form-control-inline-element">';
        $html[] = '<label for="'.$selectId.'-md">MD</label>';
        $html[] = '<select class="form-control form-control-adapt" id="'.$selectId.'-md">';
        $html[] = implode(LF, $options);
        $html[] = '</select>';
        $html[] = '</div>';

        $html[] = '<div class="form-control-inline-element">';
        $html[] = '<label for="'.$selectId.'-lg">LG</label>';
        $html[] = '<select class="form-control form-control-adapt" id="'.$selectId.'-lg">';
        $html[] = implode(LF, $options);
        $html[] = '</select>';
        $html[] = '</div>';

        $html[] = '<div class="form-control-inline-element">';
        $html[] = '<label for="'.$selectId.'-xl">XL</label>';
        $html[] = '<select class="form-control form-control-adapt" id="'.$selectId.'-xl">';
        $html[] = implode(LF, $options);
        $html[] = '</select>';
        $html[] = '</div>';

        $html[] = '<div class="form-control-inline-element">';
        $html[] = '<label for="'.$selectId.'-xxl">XXL</label>';
        $html[] = '<select class="form-control form-control-adapt" id="'.$selectId.'-xxl">';
        $html[] = implode(LF, $options);
        $html[] = '</select>';
        $html[] = '</div>';

        $html[] = '<input type="hidden"';
        $html[] = ' name="'.htmlspecialchars($this->data['parameterArray']['itemFormElName']).'"';
        $html[] = ' id="'.$selectId.'-hidden"';
        $html[] = ' value="'.trim(htmlspecialchars($itemFormElValue)).'"';
        $html[] = '/>';

        $html[] = '</div>';
        $html[] = '</div>';
        $html[] = '</div>';
        $html[] = '</div>';

        $resultArray['requireJsModules'][] = [
            'TYPO3/CMS/Bootstrap/FormEngine/Element/BootstrapDevicesElement' => implode(
                LF,
                [
                    'function(BootstrapDevicesElement) {',
                    '  require([\'jquery\'], function($) {',
                    '    $(function() {',
                    '      BootstrapDevicesElement.initialize('.GeneralUtility::quoteJSvalue($selectId).');',
                    '    });',
                    '  });',
                    '}',
                ]
            ),
        ];

        $resultArray['html'] = implode(LF, $html);

        return $resultArray;
    }
}
