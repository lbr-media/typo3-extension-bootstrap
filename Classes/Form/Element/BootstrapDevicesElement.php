<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Form\Element;

use LBRmedia\Bootstrap\Service\FlexFormService;
use LBRmedia\Bootstrap\Utility\FormElementUtility;
use RuntimeException;
use TYPO3\CMS\Backend\Form\Element\AbstractFormElement;
use TYPO3\CMS\Core\Page\JavaScriptModuleInstruction;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\StringUtility;

/**
 * This is rendered for type=text, renderType=bootstrapDevices.
 */
class BootstrapDevicesElement extends AbstractFormElement
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
     * Renders select fields for each Bootstrap device:
     * - xs
     * - sm
     * - md
     * - lg
     * - xl
     * - xxl
     *
     * Stores the values in a semicolon separated string: 'xs;sm;md;lg;xl;xxl'.
     *
     * Requires a configuration parameter 'elementConfiguration' which points to a path in TypoScript Setup:
     * plugin.tx_bootstrap.settings.form.element.{elementConfiguration}
     *
     * Example TCA
     * ===========
     *
     * @code{.xml}
     * <field index="col">
     *     <value index="TCEforms">
     *         <label>Columns</label>
     *         <config>
     *             <type>user</type>
     *             <renderType>bootstrapDevices</renderType>
     *             <default>2;3;4;;;</default>
     *             <elementConfiguration>BootstrapColumns</elementConfiguration>
     *         </config>
     *     </value>
     * </field>
     * @encode
     *
     * @return array As defined in initializeResultArray() of AbstractNode
     * @throws RuntimeException with invalid configuration
     */
    public function render(): array
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

        $fieldId = StringUtility::getUniqueId('tceforms-devices-');

        // get 'form' plugin settings
        /** @var FlexFormService $flexformService */
        $flexFormService = GeneralUtility::makeInstance(FlexFormService::class);
        $pluginSettings = $flexFormService->getPluginSettings();

        if (!isset($pluginSettings[$config['elementConfiguration'] . '.']) || !is_array($pluginSettings[$config['elementConfiguration'] . '.'])) {
            throw new RuntimeException('You have to define key values pairs in plugin.tx_bootstrap.settings.form.element.' . $config['elementConfiguration'] . ' in TsConfig!', 1495437999);
        }

        // create html
        $inputHtml = '';

        // create options (equal in each select)
        $options = implode(LF, FormElementUtility::createOptionTags($pluginSettings[$config['elementConfiguration'] . '.']));

        // create select tags
        $inputHtml .= FormElementUtility::createInlineSelectTag(
            $fieldId . '-xs',
            $this->getLanguageService()->sL('LLL:EXT:bootstrap/Resources/Private/Language/flexform.xlf:device.xs'),
            $options,
            'me-2'
        );
        $inputHtml .= FormElementUtility::createInlineSelectTag(
            $fieldId . '-sm',
            $this->getLanguageService()->sL('LLL:EXT:bootstrap/Resources/Private/Language/flexform.xlf:device.sm'),
            $options,
            'me-2'
        );
        $inputHtml .= FormElementUtility::createInlineSelectTag(
            $fieldId . '-md',
            $this->getLanguageService()->sL('LLL:EXT:bootstrap/Resources/Private/Language/flexform.xlf:device.md'),
            $options,
            'me-2'
        );
        $inputHtml .= FormElementUtility::createInlineSelectTag(
            $fieldId . '-lg',
            $this->getLanguageService()->sL('LLL:EXT:bootstrap/Resources/Private/Language/flexform.xlf:device.lg'),
            $options,
            'me-2'
        );
        $inputHtml .= FormElementUtility::createInlineSelectTag(
            $fieldId . '-xl',
            $this->getLanguageService()->sL('LLL:EXT:bootstrap/Resources/Private/Language/flexform.xlf:device.xl'),
            $options,
            'me-2'
        );
        $inputHtml .= FormElementUtility::createInlineSelectTag(
            $fieldId . '-xxl',
            $this->getLanguageService()->sL('LLL:EXT:bootstrap/Resources/Private/Language/flexform.xlf:device.xxl'),
            $options
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
            'TYPO3/CMS/Bootstrap/FormEngine/Element/BootstrapDevicesElement'
        )->instance($fieldId);

        return $resultArray;
    }
}
