<?php

namespace LBRmedia\Bootstrap\Form\Element;

use LBRmedia\Bootstrap\Service\FlexFormService;
use LBRmedia\Bootstrap\Utility\BootstrapUtility;
use LBRmedia\Bootstrap\Utility\FormElementUtility;
use RuntimeException;
use TYPO3\CMS\Backend\Form\Element\AbstractFormElement;
use TYPO3\CMS\Core\Imaging\Icon;
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
     * @var array $defaultFieldInformation
     */
    protected $defaultFieldInformation = [
        'tcaDescription' => [
            'renderType' => 'tcaDescription',
        ],
    ];

    /**
     * Default field wizards enabled for this element.
     *
     * @var array $defaultFieldWizard
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
     * Renders input fields for:
     * - iconset (select; will be shown only when there is more than one icon set)
     * - icon (a combined field for preview, icon class name and a reset button)
     * - icon position (select)
     * - icon size (select)
     * - icon color (select)
     * - filter (search field)
     *
     * Stores the values in a semicolon separated string: '{iconset};{iconclass};{position};{sizeclass}'
     *
     * Configuration parameters in TypoScript Setup: plugin.tx_bootstrap.settings.form.element.
     * - BootstrapIcons
     * - BootstrapIconPositions
     * - BootstrapIconSize
     * - BootstrapIconColor
     *
     * Example TCA
     * ===========
     *
     * @code{.php}
     * 'iconset' => [
     *     'label' => 'Icon set',
     *     'config' => [
     *         'type' => 'user',
     *         'renderType' => 'bootstrapIcons',
     *         'renderIconPosition' => true,
     *         'renderIconSize' => true,
     *         'renderIconColor' => true,
     *     ],
     * ],
     * @endcode
     *
     * @see BootstrapUtility::renderIconSet()
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
            $options[] = '<option value="' . htmlspecialchars((string)$iconSetConfiguration['key']) . '"' . (count($options) === 0 ? ' selected="selected"' : '') . '>' . htmlspecialchars((string)$iconSetConfiguration['label']) . '</option>';

            // get configuration as plain array for JavaScript
            $configurations[] = $typoScriptService->convertTypoScriptArrayToPlainArray($iconSetConfiguration);
        }

        if (count($configurations) === 0) {
            throw new RuntimeException('Cannot find any configurations in plugin.tx_bootstrap.settings.form.element.BootstrapIcons in TsSetup!', 1646233004);
        }

        // create html ...
        $inputHtml = '';

        // ... iconset type
        if (count($configurations) > 1) {
            // create select when there are more than one configuration
            $inputHtml .= FormElementUtility::createInlineSelectTag(
                $fieldId . '-iconset',
                $this->getLanguageService()->sL('LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:bootstrapIcons.iconset'),
                implode(LF, $options),
                'me-2'
            );
        } else {
            // create hidden element when there is only one configuration
            $inputHtml .= '<input type="hidden" id="' . $fieldId . '-iconset" value="' . htmlspecialchars((string)$configurations[0]['key']) . '">';
        }

        // create input for current selected icon
        /** @var IconFactor $iconFactory */
        // $iconFactory = GeneralUtility::makeInstance(IconFactory::class);
        $closeIcon = $this->iconFactory->getIcon('actions-close', Icon::SIZE_SMALL);
        $nameLabel = $this->getLanguageService()->sL('LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:bootstrapIcons.name');
        $namePlaceholder = $this->getLanguageService()->sL('LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:bootstrapIcons.name.placeholder');
        $inputHtml .= <<<EOT
<div class="form-control-inline-element me-2">
    <label for="{$fieldId}-value">{$nameLabel}</label>
    <div class="input-group">
        <span class="input-group-text" id="{$fieldId}-icon-preview">–</span>
        <input type="text" class="form-control" placeholder="{$namePlaceholder}" id="{$fieldId}-value" readonly>
        <span class="input-group-text" id="{$fieldId}-remove" style="cursor:pointer;">{$closeIcon}</span>
    </div>
</div>
EOT;

        // ... iconset position
        if (isset($config['renderIconPosition']) && $config['renderIconPosition']) {
            if (!isset($pluginSettings['BootstrapIconPositions.']) || !is_array($pluginSettings['BootstrapIconPositions.'])) {
                throw new RuntimeException('You have to define key values pairs in plugin.tx_bootstrap.settings.form.element.BootstrapIconPositions in TsSetup!', 1646218823);
            }

            $positionOptions = implode(LF, FormElementUtility::createOptionTags($pluginSettings['BootstrapIconPositions.'], true));
            $inputHtml .= FormElementUtility::createInlineSelectTag(
                $fieldId . '-position',
                $this->getLanguageService()->sL('LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:bootstrapIcons.position'),
                $positionOptions,
                'me-2'
            );
        }

        // ... iconset size
        if (isset($config['renderIconSize']) && $config['renderIconSize']) {
            if (!isset($pluginSettings['BootstrapIconSize.']) || !is_array($pluginSettings['BootstrapIconSize.'])) {
                throw new RuntimeException('You have to define key values pairs in plugin.tx_bootstrap.settings.form.element.BootstrapIconSize in TsSetup!', 1646218824);
            }

            $positionOptions = implode(LF, FormElementUtility::createOptionTags($pluginSettings['BootstrapIconSize.'], true));
            $inputHtml .= FormElementUtility::createInlineSelectTag(
                $fieldId . '-size',
                $this->getLanguageService()->sL('LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:bootstrapIcons.size'),
                $positionOptions,
                'me-2'
            );
        }

        // ... iconset color
        if (isset($config['renderIconColor']) && $config['renderIconColor']) {
            if (!isset($pluginSettings['BootstrapIconColor.']) || !is_array($pluginSettings['BootstrapIconColor.'])) {
                throw new RuntimeException('You have to define key values pairs in plugin.tx_bootstrap.settings.form.element.BootstrapIconColor in TsSetup!', 1646233527);
            }

            $positionOptions = implode(LF, FormElementUtility::createOptionTags($pluginSettings['BootstrapIconColor.'], true));
            $inputHtml .= FormElementUtility::createInlineSelectTag(
                $fieldId . '-color',
                $this->getLanguageService()->sL('LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:bootstrapIcons.color'),
                $positionOptions,
                'me-2'
            );
        }

        // create input for filter
        $filterLabel = $this->getLanguageService()->sL('LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:bootstrapIcons.filter');
        $filterPlaceholder = $this->getLanguageService()->sL('LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:bootstrapIcons.filter.placeholder');
        $inputHtml .= <<<EOT
<div class="form-control-inline-element">
    <label for="{$fieldId}-filter">{$filterLabel}</label>
    <input type="search" class="form-control" placeholder="{$filterPlaceholder}" id="{$fieldId}-filter">
</div>
EOT;

        // create container for selection
        $inputHtml .= <<<EOT
<div class="form-group" id="{$fieldId}-container" style="max-height: 20em; overflow: auto; margin-top: 0.5rem;">
    container
</div>
EOT;

        // create hidden element with values
        $inputHtml .= FormElementUtility::createHiddenInputTag(
            $this->data['parameterArray']['itemFormElName'],
            $itemFormElValue,
            $fieldId . '-hidden'
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
