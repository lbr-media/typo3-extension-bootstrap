<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

/**
 * Builds main headlines in content elements while using fields header, subheader, header_layout, tx_bootstrap_header_layout, header_position and header_link.
 *
 * Examples
 * ========
 *
 * ::
 *
 *    {bs:Tag(tag:'span', forceClosingTag:'true', content:'foo')}.
 */
class TagViewHelper extends AbstractTagBasedViewHelper
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

    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerUniversalTagAttributes();
        $this->registerArgument('tag', 'string', 'the tag to create', false, 'div');
        $this->registerArgument('content', 'string', '', false, '', false);
        $this->registerArgument('forceClosingTag', 'bool', '', false, true);
        $this->registerArgument('additionalAttributesIfNotEmpty', 'array', 'Additional tag attributes which are only set when not empty. This is to avoid produce unnessecary output.', false);
    }

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

        return $this->tag->render();
    }
}
