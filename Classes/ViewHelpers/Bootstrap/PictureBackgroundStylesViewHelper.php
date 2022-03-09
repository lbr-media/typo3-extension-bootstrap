<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\ViewHelpers\Bootstrap;

use LBRmedia\Bootstrap\Service\PictureServiceBackgroundStyles;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Service\ImageService;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\TagBuilder;

/**
 * Creates background styles for an image.
 * Uses the cropVariants xs-xxl and creates a style for each media.
 */
class PictureBackgroundStylesViewHelper extends AbstractViewHelper
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
     * @var PictureServiceBackgroundStyles $pictureServiceBackgroundStyles
     */
    protected $pictureServiceBackgroundStyles;

    /**
     * @param ImageService $imageService
     */
    public function __construct(ImageService $imageService)
    {
        $this->pictureServiceBackgroundStyles = GeneralUtility::makeInstance(PictureServiceBackgroundStyles::class, $imageService);
    }

    /**
     * Arguments for this view helper:
     * - file           The original FileReference with some alternative images
     * - id             CSS selector
     * - position       Place the styles in 'head' tag or 'inline'?
     * - displayWidth   Array with keys xs, sm, md, lg and xl with percent values of the full window width.
     */
    public function initializeArguments(): void
    {
        $this->registerArgument('file', 'object', 'The original FileReference with some alternative images', true);
        $this->registerArgument('id', 'string', 'CSS selector', true, '');
        $this->registerArgument('position', 'string', 'Place the styles in \'head\' tag or \'inline\'?', false, 'head');
        $this->registerArgument('displayWidth', 'array', 'Array with keys xs, sm, md, lg and xl with percent values of the full window width', false, []);
    }

    /**
     * Creates a style tag with background-image definitions for each Bootstrap breakpoint.
     *
     * @return string HTML Style-Tag
     */
    public function render(): string
    {
        try {
            // build styles
            $styles = $this->pictureServiceBackgroundStyles->render($this->arguments['file'], $this->arguments['id'], $this->arguments['displayWidth']);

            if ('inline' === $this->arguments['position']) {
                // build style tag
                $styleTag =  new TagBuilder('style');
                $styleTag->forceClosingTag(true);
                //$styleTag->addAttribute("type", "text/css");
                $styleTag->addAttribute('scoped', null);

                // add styles to style-tag
                $styleTag->setContent("\n" . $styles . "\n");

                return $styleTag->render();
            }
            $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
            $pageRenderer->addCssInlineBlock($this->arguments['id'] . ': background_image', $styles);

            return '';
        } catch (\Exception $e) {
            return '<!--' . $e->getMessage() . '-->';
        }
    }
}
