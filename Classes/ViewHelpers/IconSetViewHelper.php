<?php

declare(strict_types=1);

/*
 * @package LBRmedia Bootstrap Template - Provides Twitter Bootstrap 5 and some content elements.
 * @version 1.0.22
 * @author Marcel Briefs <mb@lbrmedia.de>
 * @copyright 2022 LBRmedia
 * @link https://github.com/lbr-media/typo3-extension-bootstrap
 * @license GPL-2.0-or-later
 */

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
 *    {bs:IconSet(value:'iconset;classname;position;size;color', content:'foo', additionalConfiguration:"{additionalClass:'d-inline-flex', positionClasses:'iconset-top-center iconset-md-top-left'}")}.
 *    {bs:IconSet(value:'bsicon;bi-info-circle;start;fs-3;text-primary', content:'foo', additionalConfiguration:"{additionalClass:'d-inline-flex'}")}.
 * @endcode
 *
 * Will produce something like this:
 *
 * @code{.html}
 * <span class="iconset iconset-{position}|{positionClasses} {additionalClass}>
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
 *
 * The 'additionalConfiguration' array has at this time two keys:
 * - 'additionalClasses' to add CSS classes to the wrapper
 * - 'positionClasses' to overwrite the default 'iconset-{position}' class. It can be used for device position settings.
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
     * - value (Icon set configuration: iconset;classname;position;size;color.)
     * - content (The html markup beneath the icon.)
     * - additionalConfiguration (Additional parameters like 'additionalClasses' in the wrapper or overwriting the 'positionClasses'.)
     * - alignment (If set the value of the *_alignment fields is expected. Something like: 'top-center;;middle-left;;;'. They will be transformed to icon position classes.)
     */
    public function initializeArguments(): void
    {
        $this->registerArgument('value', 'string', 'Icon set configuration: iconset;classname;position;size;color.', true, '');
        $this->registerArgument('content', 'string', 'The html markup beneath the icon.', false, '', false);
        $this->registerArgument('additionalConfiguration', 'array', 'Additional parameters like \'additionalClass\' in the wrapper or overwriting the \'positionClasses\'.', false, [], false);
        $this->registerArgument('alignment', 'string', 'If set the value of the *_alignment fields is expected. Something like: \'top-center;;middle-left;;;\'. They will be transformed to icon position classes.', false, '', false);
    }

    /**
     * Renders the icon set.
     *
     * @return string
     */
    public function render(): string
    {
        if ($this->arguments['alignment']) {
            if (!isset($this->arguments['additionalConfiguration']['positionClasses'])) {
                $this->arguments['additionalConfiguration']['positionClasses'] = BootstrapUtility::getDeviceClasses($this->arguments['alignment'], 'iconset-');
            } else {
                $this->arguments['additionalConfiguration']['positionClasses'] .= ' ' . BootstrapUtility::getDeviceClasses($this->arguments['alignment'], 'iconset-');
            }
        }

        return BootstrapUtility::renderIconSet(
            $this->arguments['value'],
            $this->arguments['content'] ? $this->arguments['content'] : $this->renderChildren(),
            $this->arguments['additionalConfiguration']
        );
    }
}
