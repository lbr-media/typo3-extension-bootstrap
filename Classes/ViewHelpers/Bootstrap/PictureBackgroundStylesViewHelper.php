<?php

namespace LBRmedia\Bootstrap\ViewHelpers\Bootstrap;

use LBRmedia\Bootstrap\Utility\Picture\BootstrapPictureBackgroundStyles as PictureBackgroundStyles;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3Fluid\Fluid\Core\ViewHelper\TagBuilder;

class PictureBackgroundStylesViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
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

    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     */
    protected $objectManager = null;

    /**
     * return \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager.
     */
    protected function getObjectManager(): ObjectManager
    {
        if (null === $this->objectManager) {
            $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        }

        return $this->objectManager;
    }

    public function initializeArguments(): void
    {
        $this->registerArgument('file', 'object', 'The original FileReference with some alternative images', true);
        $this->registerArgument('id', 'string', 'css selector', true, '');
        $this->registerArgument('position', 'string', 'Place the styles in \'head\' tag or \'inline\'?', false, 'head');
        $this->registerArgument('displayWidth', 'array', 'array with keys xs, sm, md, lg and xl with percent values of the full window width', false, []);
    }

    /**
     * Creates an picture-tag with some sources related to the alternative images append as child of a FileReference.
     *
     * @return string HTML Style-Tag
     *
     * @author Marcel Briefs <marcel.briefs@lbrmedia.de>
     *
     * @api
     */
    public function render(): string
    {
        try {
            // build styles
            $PictureBackgroundStyles = $this->getObjectManager()->get(PictureBackgroundStyles::class);
            $styles = $PictureBackgroundStyles->render($this->arguments['file'], $this->arguments['id'], $this->arguments['displayWidth']);

            if ('inline' === $this->arguments['position']) {
                // build style tag
                $styleTag = $this->getObjectManager()->get(TagBuilder::class);
                $styleTag->setTagName('style');
                $styleTag->forceClosingTag(true);
                //$styleTag->addAttribute("type", "text/css");
                $styleTag->addAttribute('scoped', null);

                // add styles to style-tag
                $styleTag->setContent("\n".$styles."\n");

                return $styleTag->render();
            } else {
                $pageRenderer = $this->getObjectManager()->get(PageRenderer::class);
                $pageRenderer->addCssInlineBlock($this->arguments['id'].': background_image', $styles);

                return '';
            }
        } catch (\Exception $e) {
            return '<!--'.$e->getMessage().'-->';
        }
    }
}
