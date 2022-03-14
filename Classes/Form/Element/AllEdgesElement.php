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

namespace LBRmedia\Bootstrap\Form\Element;

use LBRmedia\Bootstrap\Service\FlexFormService;
use LBRmedia\Bootstrap\Utility\FormElementUtility;
use RuntimeException;
use TYPO3\CMS\Backend\Form\Element\AbstractFormElement;
use TYPO3\CMS\Core\Page\JavaScriptModuleInstruction;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\StringUtility;

/**
 * This is rendered for type=text, renderType=allEdges.
 */
class AllEdgesElement extends AbstractFormElement
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
     * Renders select fields for each edges/sides:
     * - left
     * - right
     * - horizontal
     * - top
     * - bottom
     * - vertical
     * - all
     *
     * Stores the values in a semicolon separated string: '{left};{right};{horizontal};{top};{bottom};{vertical};{all}'
     *
     * Requires a configuration parameter 'elementConfiguration' which points to a path in TypoScript Setup:
     * plugin.tx_bootstrap.settings.form.element.{elementConfiguration}
     *
     * Example TCA
     * ===========
     *
     * @code{.xml}
     * <field index="space_inner_xs">
     *     <value index="TCEforms">
     *         <label>Space inner XS</label>
     *         <config>
     *             <type>user</type>
     *             <renderType>allEdges</renderType>
     *             <elementConfiguration>BootstrapPaddingSpaces</elementConfiguration>
     *             <prependEmptyOption>1</prependEmptyOption>
     *         </config>
     *     </value>
     * </field>
     * @endcode
     *
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

        $fieldId = StringUtility::getUniqueId('tceforms-alledges-');

        /** @var FlexFormService $flexformService */
        $flexFormService = GeneralUtility::makeInstance(FlexFormService::class);
        $pluginSettings = $flexFormService->getPluginSettings();

        if (!isset($pluginSettings[$config['elementConfiguration'] . '.']) || !is_array($pluginSettings[$config['elementConfiguration'] . '.'])) {
            throw new RuntimeException('You have to define key values pairs in plugin.tx_bootstrap.settings.form.element.' . $config['elementConfiguration'] . ' in TsConfig!', 1495437999);
        }

        // create html
        $inputHtml = '';

        // create options (equal in each select)
        $prependEmptyOption = isset($config['prependEmptyOption']) && ($config['prependEmptyOption'] === true || $config['prependEmptyOption'] === 'true' || $config['prependEmptyOption'] === '1' || $config['prependEmptyOption'] === 1) ? true : false;
        $options = implode(LF, FormElementUtility::createOptionTags($pluginSettings[$config['elementConfiguration'] . '.'], $prependEmptyOption));

        // create select tags
        $inputHtml .= FormElementUtility::createInlineSelectTag(
            $fieldId . '-left',
            $this->getLanguageService()->sL('LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:edge.left'),
            $options,
            'me-2'
        );
        $inputHtml .= FormElementUtility::createInlineSelectTag(
            $fieldId . '-right',
            $this->getLanguageService()->sL('LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:edge.right'),
            $options,
            'me-2'
        );
        $inputHtml .= FormElementUtility::createInlineSelectTag(
            $fieldId . '-horizontal',
            $this->getLanguageService()->sL('LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:edge.horizontal'),
            $options,
            'me-2'
        );
        $inputHtml .= FormElementUtility::createInlineSelectTag(
            $fieldId . '-top',
            $this->getLanguageService()->sL('LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:edge.top'),
            $options,
            'me-2'
        );
        $inputHtml .= FormElementUtility::createInlineSelectTag(
            $fieldId . '-bottom',
            $this->getLanguageService()->sL('LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:edge.bottom'),
            $options,
            'me-2'
        );
        $inputHtml .= FormElementUtility::createInlineSelectTag(
            $fieldId . '-vertical',
            $this->getLanguageService()->sL('LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:edge.vertical'),
            $options,
            'me-2'
        );
        $inputHtml .= FormElementUtility::createInlineSelectTag(
            $fieldId . '-all',
            $this->getLanguageService()->sL('LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:edge.all'),
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

        $resultArray['requireJsModules'][] = JavaScriptModuleInstruction::forRequireJS(
            'TYPO3/CMS/Bootstrap/FormEngine/Element/AllEdgesElement'
        )->instance($fieldId);

        return $resultArray;
    }
}
