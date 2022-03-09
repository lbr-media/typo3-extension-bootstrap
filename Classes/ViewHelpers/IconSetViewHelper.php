<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\ViewHelpers;

use LBRmedia\Bootstrap\Utility\BootstrapUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Creates an icon of an icon set and wraps all with tags and classes.
 *
 * Examples
 * ========
 *
 * @code{.html}
 *    {bs:IconSet(value:'iconset;classname;position;size;color', content:'foo')}.
 *    {bs:IconSet(value:'bsicon;bi-info-circle;start;fs-3;text-primary', content:'foo')}.
 * @endcode
 *
 * Will produce something like this:
 *
 * @code{.html}
 * <span class="iconset iconset-{position}>
 *      <span class="iconset__icon {sizeclass}">
 *          <i class="bs {iconclass}"></i>
 *      </span>
 *      <span class="iconset__content">
 *          $content
 *      </span>
 * </span>
 * @endcode
 *
 * The 'value' is a string divided by semicolon in:
 * - iconset
 * - classname
 * - position
 * - size
 * - color
 *
 * Something like this:
 *
 * @code
 * bsicon;bi-info-circle;start;fs-3;text-primary
 * @endcode
 */
class IconSetViewHelper extends AbstractViewHelper
{
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
     * Arguments for this view helper:
     * - value
     * - content
     */
    public function initializeArguments(): void
    {
        $this->registerArgument('value', 'string', 'Icon set configuration: iconset;classname;position;size;color', true, '');
        $this->registerArgument('content', 'string', '', false, '', false);
    }

    /**
     * Renders the icon set.
     *
     * @return string
     */
    public function render(): string
    {
        return BootstrapUtility::renderIconSet($this->arguments['value'], $this->arguments['content'] ? $this->arguments['content'] : $this->renderChildren());
    }
}
