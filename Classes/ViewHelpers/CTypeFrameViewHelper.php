<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\ViewHelpers;

use LBRmedia\Bootstrap\Utility\GeneralUtility as BootstrapGeneralUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\TagBuilder;

/**
 * Builds main headlines in content elements while using fields header, subheader, header_layout, tx_bootstrap_header_layout, header_position and header_link.
 *
 * Examples
 * ========
 *
 * ::
 *
 *    {bs:CTypeFrame(contentElementData:data, content:'foo')}.
 */
class CTypeFrameViewHelper extends AbstractTagBasedViewHelper
{
    /**
     * main tag name.
     *
     * @var string
     */
    protected $tagName = 'div';

    /**
     * Children must not be escaped, to be able to pass {bodytext} directly to it.
     *
     * @var bool
     */
    protected $escapeChildren = false;

    /**
     * The output may contain HTML and can not be escaped.
     *
     * @var bool
     */
    protected $escapeOutput = false;

    /**
     * List of classes to add to the container.
     */
    protected $classesList = [];

    /**
     * List of classes to add to an additional element outside the container (parent element).
     */
    protected $classesOuterList = [];

    /**
     * List of params (property=>value) to add to main tag.
     */
    protected $additionalAttributes = [];

    /**
     * List of params (property=>value) to add to an additional element outside the container (parent element).
     */
    protected $additionalOuterAttributes = [];

    /**
     * @var array
     */
    protected $outerWrap = [
        'before' => [],
        'after' => [],
    ];

    /**
     * @var array
     */
    protected $innerWrap = [
        'before' => [],
        'after' => [],
    ];

    public function initializeArguments(): void
    {
        $this->registerArgument('contentElementData', 'array', 'data from content element');
        $this->registerArgument('content', 'string', '');
    }

    public function render(): string
    {
        $data = $this->arguments['contentElementData'];
        $content = $this->arguments['content'] ? $this->arguments['content'] : $this->renderChildren();

        if ('none' === $data['frame_class']) {
            return '<div id="c'.$data['uid'].'"></div>'.$content;
        }

        // AdditionalStyles
        if ($data['tx_bootstrap_additional_styles']) {
            // get the TS setup
            $pluginSettings = BootstrapGeneralUtility::getFormElementPluginSettings();
            $additionalStyles = explode(',', $data['tx_bootstrap_additional_styles']);
            if (isset($pluginSettings['AdditionalStyles.']) && count($additionalStyles)) {
                foreach ($additionalStyles as $key) {
                    if (isset($pluginSettings['AdditionalStyles.'][$key.'.'])) {
                        $this->prepareAdditionals($pluginSettings['AdditionalStyles.'][$key.'.']);
                    }
                }

                // include innerWrap before all others
                $this->renderInnerWrap($content);
            }
        }

        // wrap content with inner frame class
        if ($data['tx_bootstrap_inner_frame_class']) {
            $innerFrameTag = new TagBuilder('div');
            $innerFrameTag->forceClosingTag(true);
            $innerFrameTag->addAttribute('class', $data['tx_bootstrap_inner_frame_class']);
            $innerFrameTag->setContent($content);
            $content = $innerFrameTag->render();
        }

        // create main tag
        $mainTag = new TagBuilder($this->tagName);
        $mainTag->forceClosingTag(true);

        // basic container class
        if ('list' === $data['CType'] && $data['list_type']) {
            // additional class when it is a plugin
            $this->classesList[] = 'container-list container-list--'.$data['list_type'];
        } elseif ('gridelements_pi1' === $data['CType'] && $data['tx_gridelements_backend_layout']) {
            // additional class when it is a gridelement
            $this->classesList[] = 'container-grid container-grid--'.$data['tx_gridelements_backend_layout'];
        } else {
            // default class for normal CTypes
            $this->classesList[] = 'container-'.$data['CType'];
        }

        // layout class
        if ($data['layout']) {
            $this->classesList[] = 'container--layout-'.$data['layout'];
        }

        // space before class
        if ($data['space_before_class']) {
            $this->classesList[] = 'container--space-before-'.$data['space_before_class'];
        }

        // space after class
        if ($data['space_after_class']) {
            $this->classesList[] = 'container--space-after-'.$data['space_after_class'];
        }

        // text color class
        if ($data['tx_bootstrap_text_color']) {
            $this->classesList[] = $data['tx_bootstrap_text_color'];
        }

        // prepare frame_class
        $frameClass = '';
        if ('default' !== $data['frame_class']) {
            if ('container-' === substr($data['frame_class'], 0, 10)) {
                $frameClass = 'container '.$data['frame_class'];
            } else {
                $frameClass = $data['frame_class'];
            }
        }

        // background-color class
        if ($data['tx_bootstrap_background_color']) {
            $this->classesList[] = $data['tx_bootstrap_background_color'];

            // create inner div with frame_class (p.e. container-xl)
            // (but only, if frame_class is not the default one)
            if ($frameClass) {
                $innerTag = new TagBuilder($this->tagName);
                $innerTag->forceClosingTag(true);
                $innerTag->addAttribute('class', $frameClass);
                $innerTag->setContent($content);
                $mainTag->setContent($innerTag->render());
            } else {
                $mainTag->setContent($content);
            }
        } else {
            // there is no background color: set the frame_class (p.e. container-xl) to the main tag
            if ($frameClass) {
                $this->classesList[] = $frameClass;
            }
            $mainTag->setContent($content);
        }

        // add classes to main tag
        $mainTag->addAttribute('class', BootstrapGeneralUtility::cleanCssClassesString($this->classesList));

        // add additional attributes
        if (count($this->additionalAttributes)) {
            $mainTag->addAttributes($this->additionalAttributes);
        }

        // outer div for AdditionalStyles->additionalOuterClass
        if (count($this->classesOuterList) || count($this->additionalOuterAttributes)) {
            $tagHtml = $mainTag->render();

            // include outerWrap after all inner stuff
            $this->renderOuterWrap($tagHtml);

            // generate outer div with classes
            $outerTag = new TagBuilder('div');
            $outerTag->forceClosingTag(true);
            $outerTag->addAttribute('id', 'c'.$data['uid']); // set id to outer classes element instead to the main tag
            if (count($this->classesOuterList)) {
                $outerTag->addAttribute('class', BootstrapGeneralUtility::cleanCssClassesString($this->classesOuterList));
            }
            if (count($this->additionalOuterAttributes)) {
                $outerTag->addAttributes($this->additionalOuterAttributes);
            }
            $outerTag->setContent($tagHtml);
            $tagHtml = $outerTag->render();
        } else {
            $mainTag->addAttribute('id', 'c'.$data['uid']);
            $tagHtml = $mainTag->render();

            // include outerWrap after all inner stuff
            $this->renderOuterWrap($tagHtml);
        }

        // return and build tag and prepend localized id
        return (isset($data['_LOCALIZED_UID']) && $data['_LOCALIZED_UID'] ? '<div id="c'.$data['_LOCALIZED_UID'].'"></div>' : '').$tagHtml;
    }

    protected function renderInnerWrap(string &$content): void
    {
        if (count($this->innerWrap['before'])) {
            $content = implode('', $this->innerWrap['before']).$content.implode('', array_reverse($this->innerWrap['after']));
        }
    }

    protected function renderOuterWrap(string &$content): void
    {
        if (count($this->outerWrap['before'])) {
            $content = implode('', $this->outerWrap['before']).$content.implode('', array_reverse($this->outerWrap['after']));
        }
    }

    /**
     * prepares the values for additional styles.
     */
    protected function prepareAdditionals(array $config): void
    {
        if (isset($config['additionalClass']) && $config['additionalClass']) {
            $this->classesList[] = $config['additionalClass'];
        }

        if (isset($config['additionalOuterClass']) && $config['additionalOuterClass']) {
            $this->classesOuterList[] = $config['additionalOuterClass'];
        }

        if (isset($config['outerWrap']) && $config['outerWrap']) {
            $wrap = GeneralUtility::trimExplode('|', $config['outerWrap']);
            $this->outerWrap['before'][] = $wrap[0];
            $this->outerWrap['after'][] = $wrap[1];
        }

        if (isset($config['innerWrap']) && $config['innerWrap']) {
            $wrap = GeneralUtility::trimExplode('|', $config['innerWrap']);
            $this->innerWrap['before'][] = $wrap[0];
            $this->innerWrap['after'][] = $wrap[1];
        }

        if (isset($config['additionalAttributes.']) && is_array($config['additionalAttributes.'])) {
            foreach ($config['additionalAttributes.'] as $attribute => $value) {
                if (is_string($value)) {
                    $this->additionalAttributes[$attribute] = $value;
                }
            }
        }

        if (isset($config['additionalOuterAttributes.']) && is_array($config['additionalOuterAttributes.'])) {
            foreach ($config['additionalOuterAttributes.'] as $attribute => $value) {
                if (is_string($value)) {
                    $this->additionalOuterAttributes[$attribute] = $value;
                }
            }
        }
    }
}
