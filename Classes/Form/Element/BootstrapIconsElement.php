<?php

namespace LBRmedia\Bootstrap\Form\Element;

use LBRmedia\Bootstrap\Service\FlexFormService;
use LBRmedia\Bootstrap\Utility\FormElementUtility;
use RuntimeException;
use TYPO3\CMS\Backend\Form\Element\AbstractFormElement;
use TYPO3\CMS\Core\Imaging\Icon;
// use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Page\JavaScriptModuleInstruction;
use TYPO3\CMS\Core\TypoScript\TypoScriptService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\StringUtility;

/**
 * This is rendered for type=text, renderType=bootstrapBorderElement.
 */
class BootstrapIconsElement extends AbstractFormElement
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
        $itemFormElValue = isset($config['default']) ? $config['default'] : "";
        if (!empty($parameterArray['itemFormElValue'])) {
            $itemFormElValue = (string) $parameterArray['itemFormElValue'];
        }

        $renderIconPosition = isset($config['renderIconPosition']) && $config['renderIconPosition'] === true ? true : false;
        $renderIconSize = isset($config['renderIconSize']) && $config['renderIconSize'] === true ? true : false;

        $fieldWizardResult = $this->renderFieldWizard();
        $fieldWizardHtml = $fieldWizardResult['html'];
        $resultArray = $this->mergeChildReturnIntoExistingResult($resultArray, $fieldWizardResult, false);

        $fieldId = StringUtility::getUniqueId('tceforms-bootstrapborder-');

        // get 'form' plugin settings
        /** @var FlexFormService $flexFormService */
        $flexFormService = GeneralUtility::makeInstance(FlexFormService::class);
        $pluginSettings = $flexFormService->getPluginSettings();

        if (!isset($pluginSettings['BootstrapIcons.']) || !is_array($pluginSettings['BootstrapIcons.'])) {
            throw new RuntimeException('You have to define icon-set configurations in plugin.tx_bootstrap.settings.form.element.BootstrapIcons in TsSetup!', 1646202751);
        }

        

        // create select tags ...
        
        /** @var TypoScriptService $typoScriptService */
        $typoScriptService = GeneralUtility::makeInstance(TypoScriptService::class);
        $options = [];
        $configurations = [];
        foreach ($pluginSettings['BootstrapIcons.'] as $key => $iconSetConfiguration) {
            if (!isset($iconSetConfiguration['label']) || !is_string($iconSetConfiguration['label'])) {
                throw new RuntimeException("You have to define a label in plugin.tx_bootstrap.settings.form.element.BootstrapIcons{$key}label in TsSetup!", 1646202752);
            }
            if (!isset($iconSetConfiguration['key']) || !is_string($iconSetConfiguration['key'])) {
                throw new RuntimeException("You have to define a key in plugin.tx_bootstrap.settings.form.element.BootstrapIcons{$key}key in TsSetup!", 1646202753);
            }

            // create select optione
            $options[] = '<option value="' . htmlspecialchars((string) $iconSetConfiguration['key']) . '"'.(count($options) === 0 ? ' selected="selected"' : '').'>' . htmlspecialchars((string) $iconSetConfiguration['label']) . '</option>';

            // get configuration as plain array for JavaScript
            $configurations[] = $typoScriptService->convertTypoScriptArrayToPlainArray($iconSetConfiguration);
        }

        // create html ...
        $inputHtml = "";
        
        // ... iconset type
        $inputHtml .= FormElementUtility::createInlineSelectTag(
            $fieldId.'-iconset',
            "Icon-Set",
            implode(LF, $options),
            "me-2"
        );
        
        // create input for current selected icon
        /** @var IconFactor $iconFactory */
        // $iconFactory = GeneralUtility::makeInstance(IconFactory::class);
        $closeIcon = $this->iconFactory->getIcon('actions-close', Icon::SIZE_SMALL);
        $inputHtml .= <<<EOT
<div class="form-control-inline-element me-2">
    <label for="{$fieldId}-value">Icon-Name</label>
    <div class="input-group">
        <span class="input-group-text" id="{$fieldId}-icon-preview">–</span>
        <input type="text" class="form-control" placeholder="Icon class" id="{$fieldId}-value" readonly>
        <span class="input-group-text" id="{$fieldId}-remove" style="cursor:pointer;">{$closeIcon}</span>
    </div>
</div>
EOT;

        // ... iconset position
        if ($renderIconPosition) {
            if (!isset($pluginSettings['BootstrapIconPositions.']) || !is_array($pluginSettings['BootstrapIconPositions.'])) {
                throw new RuntimeException('You have to define key values pairs in plugin.tx_bootstrap.settings.form.element.BootstrapIconPositions in TsSetup!', 1646218823);
            }

            $positionOptions = implode(LF, FormElementUtility::createOptionTags($pluginSettings['BootstrapIconPositions.'], true));
            $inputHtml .= FormElementUtility::createInlineSelectTag(
                $fieldId.'-position',
                "Position",
                $positionOptions,
                "me-2"
            );
        }

        // ... iconset size
        if ($renderIconPosition) {
            if (!isset($pluginSettings['BootstrapIconSize.']) || !is_array($pluginSettings['BootstrapIconSize.'])) {
                throw new RuntimeException('You have to define key values pairs in plugin.tx_bootstrap.settings.form.element.BootstrapIconSize in TsSetup!', 1646218824);
            }

            $positionOptions = implode(LF, FormElementUtility::createOptionTags($pluginSettings['BootstrapIconSize.'], true));
            $inputHtml .= FormElementUtility::createInlineSelectTag(
                $fieldId.'-size',
                "Size",
                $positionOptions,
                "me-2"
            );
        }

        // create input for filter
        $inputHtml .= <<<EOT
<div class="form-control-inline-element">
    <label for="{$fieldId}-filter">Filter</label>
    <input type="search" class="form-control" placeholder="Filter" id="{$fieldId}-filter">
</div>
EOT;

        // create container for selection
        $inputHtml .= <<<EOT
<div class="form-group" id="{$fieldId}-container" style="max-height: 28em; overflow: auto; margin-top: 0.5rem;">
    container
</div>
EOT;

        // create hidden element with values
        $inputHtml .= FormElementUtility::createHiddenInputTag(
            $this->data['parameterArray']['itemFormElName'],
            $itemFormElValue,
            $fieldId.'-hidden'
        );

        // create final html markup
        $resultArray['html'] = FormElementUtility::createFormControlWrap($inputHtml, $fieldWizardHtml);

        // require JS
        $resultArray['requireJsModules'][] = JavaScriptModuleInstruction::forRequireJS(
            'TYPO3/CMS/Bootstrap/FormEngine/Element/BootstrapIconsElement'
        )->instance($fieldId, json_encode($configurations, JSON_PRETTY_PRINT));

        return $resultArray;
    }
}
