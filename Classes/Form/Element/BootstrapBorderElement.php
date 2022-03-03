<?php

namespace LBRmedia\Bootstrap\Form\Element;

use LBRmedia\Bootstrap\Service\FlexFormService;
use LBRmedia\Bootstrap\Utility\FormElementUtility;
use RuntimeException;
use TYPO3\CMS\Backend\Form\Element\AbstractFormElement;
use TYPO3\CMS\Core\Page\JavaScriptModuleInstruction;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\StringUtility;

/**
 * This is rendered for type=text, renderType=bootstrapBorderElement.
 */
class BootstrapBorderElement extends AbstractFormElement
{
    /**
     * Default field information enabled for this element.
     *
     * @var array
     */
    protected $defaultFieldInformation = [
        'tcaDescription' => [
            'renderType' => 'tcaDescription',
        ],
    ];

    /**
     * Default field wizards enabled for this element.
     *
     * @var array
     */
    protected $defaultFieldWizard = [
        'localizationStateSelector' => [
            'renderType' => 'localizationStateSelector',
        ],
        'otherLanguageContent' => [
            'renderType' => 'otherLanguageContent',
            'after' => [
                'localizationStateSelector',
            ],
        ],
        'defaultLanguageDifferences' => [
            'renderType' => 'defaultLanguageDifferences',
            'after' => [
                'otherLanguageContent',
            ],
        ],
    ];

    /**
     * Render single element.
     *
     * @return array As defined in initializeResultArray() of AbstractNode
     * @throws RuntimeException with invalid configuration
     */
    public function render()
    {
        $resultArray = $this->initializeResultArray();

        $parameterArray = $this->data['parameterArray'];
        $config = $parameterArray['fieldConf']['config'];
        $itemFormElValue = isset($config['default']) ? $config['default'] : '';
        if (!empty($parameterArray['itemFormElValue'])) {
            $itemFormElValue = (string)$parameterArray['itemFormElValue'];
        }

        $fieldWizardResult = $this->renderFieldWizard();
        $fieldWizardHtml = $fieldWizardResult['html'];
        $resultArray = $this->mergeChildReturnIntoExistingResult($resultArray, $fieldWizardResult, false);

        $fieldId = StringUtility::getUniqueId('tceforms-bootstrapborder-');

        // get 'form' plugin settings
        /** @var FlexFormService $flexFormService */
        $flexFormService = GeneralUtility::makeInstance(FlexFormService::class);
        $pluginSettings = $flexFormService->getPluginSettings();

        // create html
        $inputHtml = '';

        // create select tags ...
        // ... border
        if (!isset($pluginSettings['BootstrapBorder.']) || !is_array($pluginSettings['BootstrapBorder.'])) {
            throw new RuntimeException('You have to define key values pairs in plugin.tx_bootstrap.settings.form.element.BootstrapBorder in TsSetup!', 1646131737);
        }
        $inputHtml .= FormElementUtility::createInlineSelectTag(
            $fieldId . '-border',
            $this->getLanguageService()->sL('LLL:EXT:bootstrap/Resources/Private/Language/flexform.xlf:border'),
            implode(LF, FormElementUtility::createOptionTags($pluginSettings['BootstrapBorder.'])),
            'me-2'
        );

        // ... border width
        if (!isset($pluginSettings['BootstrapBorderWidth.']) || !is_array($pluginSettings['BootstrapBorderWidth.'])) {
            throw new RuntimeException('You have to define key values pairs in plugin.tx_bootstrap.settings.form.element.BootstrapBorderWidth in TsSetup!', 1646131741);
        }
        $inputHtml .= FormElementUtility::createInlineSelectTag(
            $fieldId . '-borderwidth',
            $this->getLanguageService()->sL('LLL:EXT:bootstrap/Resources/Private/Language/flexform.xlf:border_width'),
            implode(LF, FormElementUtility::createOptionTags($pluginSettings['BootstrapBorderWidth.'])),
            'me-2'
        );

        // ... border color
        if (!isset($pluginSettings['BootstrapBorderColor.']) || !is_array($pluginSettings['BootstrapBorderColor.'])) {
            throw new RuntimeException('You have to define key values pairs in plugin.tx_bootstrap.settings.form.element.BootstrapBorderColor in TsSetup!', 1646131738);
        }
        $inputHtml .= FormElementUtility::createInlineSelectTag(
            $fieldId . '-bordercolor',
            $this->getLanguageService()->sL('LLL:EXT:bootstrap/Resources/Private/Language/flexform.xlf:border_color'),
            implode(LF, FormElementUtility::createOptionTags($pluginSettings['BootstrapBorderColor.'])),
            'me-2'
        );

        // ... rounded
        if (!isset($pluginSettings['BootstrapRounded.']) || !is_array($pluginSettings['BootstrapRounded.'])) {
            throw new RuntimeException('You have to define key values pairs in plugin.tx_bootstrap.settings.form.element.BootstrapRounded in TsSetup!', 1646131739);
        }
        $inputHtml .= FormElementUtility::createInlineSelectTag(
            $fieldId . '-rounded',
            $this->getLanguageService()->sL('LLL:EXT:bootstrap/Resources/Private/Language/flexform.xlf:rounded'),
            implode(LF, FormElementUtility::createOptionTags($pluginSettings['BootstrapRounded.'])),
            'me-2'
        );

        // ... shadow
        if (!isset($pluginSettings['BootstrapShadow.']) || !is_array($pluginSettings['BootstrapShadow.'])) {
            throw new RuntimeException('You have to define key values pairs in plugin.tx_bootstrap.settings.form.element.BootstrapShadow in TsSetup!', 1646131740);
        }
        $inputHtml .= FormElementUtility::createInlineSelectTag(
            $fieldId . '-shadow',
            $this->getLanguageService()->sL('LLL:EXT:bootstrap/Resources/Private/Language/flexform.xlf:shadow'),
            implode(LF, FormElementUtility::createOptionTags($pluginSettings['BootstrapShadow.']))
        );

        // create hidden element with value
        $inputHtml .= FormElementUtility::createHiddenInputTag(
            $this->data['parameterArray']['itemFormElName'],
            $itemFormElValue,
            $fieldId . '-hidden'
        );

        // create final html markup
        $resultArray['html'] = FormElementUtility::createFormControlWrap($inputHtml, $fieldWizardHtml);

        // require JS
        $resultArray['requireJsModules'][] = JavaScriptModuleInstruction::forRequireJS(
            'TYPO3/CMS/Bootstrap/FormEngine/Element/BootstrapBorderElement'
        )->instance($fieldId);

        return $resultArray;
    }
}
