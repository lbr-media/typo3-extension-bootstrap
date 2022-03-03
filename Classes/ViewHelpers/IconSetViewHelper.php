<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\ViewHelpers;

use LBRmedia\Bootstrap\Utility\BootstrapUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Creates an icon of an icon set and wraps all with classes
 *
 * Examples
 * ========
 *
 * ::
 *    {bs:IconSet(value:'iconset;classname;position;size;color', content:'foo')}.
 *    {bs:IconSet(value:'bsicon;bi-info-circle;start;fs-3;text-primary', content:'foo')}.
 */
class IconSetViewHelper extends AbstractViewHelper
{
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
        $this->registerArgument('value', 'string', 'Icon set configuration: iconset;classname;position;size;color', true, '');
        $this->registerArgument('content', 'string', '', false, '', false);
    }

    public function render(): string
    {
        return BootstrapUtility::renderIconSet($this->arguments['value'], $this->arguments['content'] ? $this->arguments['content'] : $this->renderChildren());
    }
}
