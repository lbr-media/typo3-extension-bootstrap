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

namespace LBRmedia\Bootstrap\Service;

use Exception;

class PictureServiceBackgroundStyles extends PictureServiceBootstrap
{
    /**
     * Creates styles for an image with all cropVariants between xs until xxl.
     *
     * @param object $file                  The original FileReference with some alternative images
     * @param string $cssSelector           The Selector for the background image
     * @param array  $displayWidthArguments array with keys xs, sm, md, lg and xl with percent values of the full window width
     *
     * @return string HTML Style-Tag
     *
     * @author Marcel Briefs <marcel.briefs@lbrmedia.de>
     */
    public function render($file, string $cssSelector, array $displayWidthArguments = []): string
    {
        try {
            if ($file instanceof \TYPO3\CMS\Extbase\Domain\Model\FileReference) {
                $file = $file->getOriginalResource();
            } elseif (!$file instanceof \TYPO3\CMS\Core\Resource\FileReference) {
                throw new Exception('The image file must be an instance of \\TYPO3\\CMS\\Extbase\\Domain\\Model\\FileReference or \\TYPO3\\CMS\\Core\\Resource\\FileReference', 1509795323);
            }

            // initialize picture utility
            $this->__reset()
                ->setFileReference($file)
                ->initializeCropVariantsProcessingInstructions();

            // determine/override widths by viewhelper argument
            if ($displayWidthArguments) {
                $this->overwriteDisplayWidthsWithViewHelperArgument($displayWidthArguments);
            }

            $styles = [];

            // build XS image
            $styles[] = $cssSelector . " { background-image:url('" . $this->getBackgroundImageSource('xs') . "' ); }";

            // build SM image
            $styles[] = '@media ' . self::MEDIA_QUERIES['sm'] . ' { ' . $cssSelector . " { background-image:url('" . $this->getBackgroundImageSource('sm') . "'); } }";

            // build MD image
            $styles[] = '@media ' . self::MEDIA_QUERIES['md'] . ' { ' . $cssSelector . " { background-image:url('" . $this->getBackgroundImageSource('md') . "'); } }";

            // build LG image
            $styles[] = '@media ' . self::MEDIA_QUERIES['lg'] . ' { ' . $cssSelector . " { background-image:url('" . $this->getBackgroundImageSource('lg') . "'); } }";

            // build XL image
            $styles[] = '@media ' . self::MEDIA_QUERIES['xl'] . ' { ' . $cssSelector . " { background-image:url('" . $this->getBackgroundImageSource('xl') . "'); } }";

            // build XXL image
            $styles[] = '@media ' . self::MEDIA_QUERIES['xxl'] . ' { ' . $cssSelector . " { background-image:url('" . $this->getBackgroundImageSource('xxl') . "'); } }";

            // add styles to style-tag
            return implode(LF, $styles);
        } catch (Exception $e) {
            return '';
        }
    }

    /**
     * Creates an image while pay attention to crop and max-width.
     *
     * @param string $device
     * @return string
     */
    protected function getBackgroundImageSource(string $device): string
    {
        $targetWidth = 575;
        $maxWidth = $this->getDisplayWidth($device);
        while ($targetWidth < $maxWidth) {
            $targetWidth += 575;
        }

        return $this->getImageSource($device, $targetWidth);
    }
}
