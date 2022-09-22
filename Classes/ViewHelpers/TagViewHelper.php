<?php

declare(strict_types=1);

/*
 * @package LBRmedia Bootstrap Template - Provides Twitter Bootstrap 5 and some content elements.
 * @version 1.0.23
 * @author Marcel Briefs <mb@lbrmedia.de>
 * @copyright 2022 LBRmedia
 * @link https://github.com/lbr-media/typo3-extension-bootstrap
 * @license GPL-2.0-or-later
 */

namespace LBRmedia\Bootstrap\ViewHelpers;

use LBRmedia\Bootstrap\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

/**
 * Builds a html tag.
 * Inherits from TagBasedViewHelper. All its arguments are available.
 *
 * Examples
 * ========
 *
 * @code{.html}
 * {bs:Tag(tag:'span', forceClosingTag:'true', content:'foo')}.
 * @encode
 *
 * ... will produce:
 *
 * @code{.html}
 * <span>foo</span>
 * @encode
 *
 * You can use 'additionalAttributesIfNotEmpty' which will only be set when there is a value.
 * In p.e target- and rel-attributes are only set when they are set.
 *
 * @code{.html}
 * <bs:Tag tag="a" forceClosingTag="true" title="{item.title}" additionalAttributesIfNotEmpty="{
 *     href: item.link,
 *     class: settings.bootstrap.nav_link_active_classes,
 *     target: item.target,
 *     rel: '{f:if(condition:item.data.no_follow, then:\'nofollow\')}'
 * }">{item.title}</bs:Tag>
 * @encode
 */
class TagViewHelper extends AbstractTagBasedViewHelper
{
    /**
     * Main tag name.
     *
     * @var string $tagName
     */
    protected $tagName = 'div';

    /**
     * Children must not be escaped, to be able to pass {bodytext} directly to it.
     *
     * @var bool $escapeChildren
     */
    protected $escapeChildren = false;

    /**
     * The output may contain HTML and can not be escaped.
     *
     * @var bool $escapeOutput
     */
    protected $escapeOutput = false;

    /**
     * Additional arguments for this view helper:
     * - tag
     * The tag to create.
     * - content
     * The content html.
     * - forceClosingTag
     * Should the tag to be forced to close.
     * - additionalAttributesIfNotEmpty
     * Additional tag attributes which are only set when not empty. This is to avoid produce unnessecary output.
     * - classes
     * CSS-classes array to merge with class atribute.
     */
    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerUniversalTagAttributes();
        $this->registerArgument('tag', 'string', 'The tag to create.', false, 'div');
        $this->registerArgument('content', 'string', '', false, '', false);
        $this->registerArgument('forceClosingTag', 'bool', '', false, true);
        $this->registerArgument('additionalAttributesIfNotEmpty', 'array', 'Additional tag attributes which are only set when not empty. This is to avoid produce unnessecary output.', false);
        $this->registerArgument('classes', 'array', 'CSS-classes array to merge with class atribute.', false);
    }

    /**
     * Renders the tag.
     *
     * @return string
     */
    public function render(): string
    {
        // change tag name
        if ($this->arguments['tag']) {
            $this->tagName = $this->arguments['tag'];
            $this->tag->setTagName($this->tagName);
        }

        // set (or not) closing tag
        $this->tag->forceClosingTag($this->arguments['forceClosingTag']);

        // set content
        $this->tag->setContent($this->arguments['content'] ? $this->arguments['content'] : $this->renderChildren());

        // set additional attributes (only when not empty)
        if (is_array($this->arguments['additionalAttributesIfNotEmpty'])) {
            foreach ($this->arguments['additionalAttributesIfNotEmpty'] as $attributeName => $value) {
                if ($value && '' !== trim((string)$value)) {
                    $this->tag->addAttribute($attributeName, trim($value));
                }
            }
        }

        if (is_array($this->arguments['classes'])) {
            $classes = $this->tag->getAttribute('class')
                ? array_merge([$this->tag->getAttribute('class')], $this->arguments['classes'])
                : $this->arguments['classes'];
            $this->tag->addAttribute('class', GeneralUtility::cleanCssClassesString($classes));
        }

        return $this->tag->render();
    }
}
