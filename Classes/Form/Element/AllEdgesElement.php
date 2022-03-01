<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Form\Element;

use LBRmedia\Bootstrap\Service\FlexFormService;
use LBRmedia\Bootstrap\Utility\FormElementUtility;
use RuntimeException;
use TYPO3\CMS\Backend\Form\Element\AbstractFormElement;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\StringUtility;
use TYPO3\CMS\Core\Page\JavaScriptModuleInstruction;

/**
 * This is rendered for type=text, renderType=allEdges.
 */
class AllEdgesElement extends AbstractFormElement
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
    public function render(): array
    {
        $resultArray = $this->initializeResultArray();

        $parameterArray = $this->data['parameterArray'];
        $config = $parameterArray['fieldConf']['config'];
        $itemFormElValue = isset($config['default']) ? $config['default'] : "";
        if (!empty($parameterArray['itemFormElValue'])) {
            $itemFormElValue = (string) $parameterArray['itemFormElValue'];
        }

        $fieldWizardResult = $this->renderFieldWizard();
        $fieldWizardHtml = $fieldWizardResult['html'];
        $resultArray = $this->mergeChildReturnIntoExistingResult($resultArray, $fieldWizardResult, false);

        $fieldId = StringUtility::getUniqueId('tceforms-alledges-');

        /** @var FlexFormService $flexformService */
        $flexFormService = GeneralUtility::makeInstance(FlexFormService::class);
        $pluginSettings = $flexFormService->getPluginSettings();

        if (!isset($pluginSettings[$config['elementConfiguration'] . '.']) || !is_array($pluginSettings[$config['elementConfiguration'] . '.'])) {
            throw new RuntimeException('You have to define key values pairs in plugin.tx_bootstrap.settings.form.element.' . $config['elementConfiguration'] . ' in TsConfig!', 1495437999);
        }

        // create html
        $inputHtml = "";

        // create options (equal in each select)
        $options = implode(LF, FormElementUtility::createOptionTags($pluginSettings[$config['elementConfiguration'] . '.']));

        // create select tags
        $inputHtml .= FormElementUtility::createInlineSelectTag(
            $fieldId.'-left',
            $this->getLanguageService()->sL('LLL:EXT:bootstrap/Resources/Private/Language/flexform.xlf:edge.left'),
            $options
        );
        $inputHtml .= FormElementUtility::createInlineSelectTag(
            $fieldId.'-right',
            $this->getLanguageService()->sL('LLL:EXT:bootstrap/Resources/Private/Language/flexform.xlf:edge.right'),
            $options
        );
        $inputHtml .= FormElementUtility::createInlineSelectTag(
            $fieldId.'-horizontal',
            $this->getLanguageService()->sL('LLL:EXT:bootstrap/Resources/Private/Language/flexform.xlf:edge.horizontal'),
            $options
        );
        $inputHtml .= FormElementUtility::createInlineSelectTag(
            $fieldId.'-top',
            $this->getLanguageService()->sL('LLL:EXT:bootstrap/Resources/Private/Language/flexform.xlf:edge.top'),
            $options
        );
        $inputHtml .= FormElementUtility::createInlineSelectTag(
            $fieldId.'-bottom',
            $this->getLanguageService()->sL('LLL:EXT:bootstrap/Resources/Private/Language/flexform.xlf:edge.bottom'),
            $options
        );
        $inputHtml .= FormElementUtility::createInlineSelectTag(
            $fieldId.'-vertical',
            $this->getLanguageService()->sL('LLL:EXT:bootstrap/Resources/Private/Language/flexform.xlf:edge.vertical'),
            $options
        );
        $inputHtml .= FormElementUtility::createInlineSelectTag(
            $fieldId.'-all',
            $this->getLanguageService()->sL('LLL:EXT:bootstrap/Resources/Private/Language/flexform.xlf:edge.all'),
            $options
        );

        // create hidden element with value
        $inputHtml .= FormElementUtility::createHiddenInputTag(
            $this->data['parameterArray']['itemFormElName'],
            $itemFormElValue,
            $fieldId.'-hidden'
        );

        // create final html markup
        $resultArray['html'] = FormElementUtility::createFormControlWrap($inputHtml, $fieldWizardHtml);

        $resultArray['requireJsModules'][] = JavaScriptModuleInstruction::forRequireJS(
            'TYPO3/CMS/Bootstrap/FormEngine/Element/AllEdgesElement'
        )->instance($fieldId);

        return $resultArray;
    }
}
