<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Service;

use TYPO3\CMS\Core\Utility\GeneralUtility;

class PictureServiceBackgroundStyles
{
    /**
     * @var PictureServiceBootstrap
     */
    protected $pictureService = null;

    /**
     * @return PictureServiceBootstrap $pictureUtility.
     */
    protected function getPictureService():PictureServiceBootstrap
    {
        if (null === $this->pictureService) {
            $this->pictureService = GeneralUtility::makeInstance(PictureServiceBootstrap::class);
        }

        return $this->pictureService;
    }

    /**
     * Creates a picture-tag with some sources related to the alternative images append as child of a FileReference.
     *
     * @param object $file                  The original FileReference with some alternative images
     * @param string $cssSelector           The Selector for the background image
     * @param array  $displayWidthArguments array with keys xs, sm, md, lg and xl with percent values of the full window width
     *
     * @return string HTML Style-Tag
     *
     * @author Marcel Briefs <marcel.briefs@lbrmedia.de>
     */
    public function render($file, string $cssSelector, $displayWidthArguments = []): string
    {
        try {
            if ($file instanceof \TYPO3\CMS\Extbase\Domain\Model\FileReference) {
                $file = $file->getOriginalResource();
            } elseif (!$file instanceof \TYPO3\CMS\Core\Resource\FileReference) {
                throw new \Exception('The image file must be an instance of \\TYPO3\\CMS\\Extbase\\Domain\\Model\\FileReference or \\TYPO3\\CMS\\Core\\Resource\\FileReference', 1509795323);
            }

            // initialize picture utility
            $this->getPictureService()
                ->setFileReference($file)
                ->initializeCropVariantsProcessingInstructions();

            // determine/override widths by viewhelper argument
            if ($displayWidthArguments) {
                $this->getPictureService()->overwriteDisplayWidthsWithViewHelperArgument($displayWidthArguments);
            }

            $styles = [];

            // build XS image
            $styles[] = $cssSelector . " { background-image:url('" . $this->getImageSource('xs') . "' ); }";

            // build SM image
            $styles[] = '@media (min-width: 576px) { ' . $cssSelector . " { background-image:url('" . $this->getImageSource('sm') . "'); } }";

            // build MD image
            $styles[] = '@media (min-width: 768px) { ' . $cssSelector . " { background-image:url('" . $this->getImageSource('md') . "'); } }";

            // build LG image
            $styles[] = '@media (min-width: 992px) { ' . $cssSelector . " { background-image:url('" . $this->getImageSource('lg') . "'); } }";

            // build XL image
            $styles[] = '@media (min-width: 1200px) { ' . $cssSelector . " { background-image:url('" . $this->getImageSource('xl') . "'); } }";

            // build XXL image
            $styles[] = '@media (min-width: 1400px) { ' . $cssSelector . " { background-image:url('" . $this->getImageSource('xxl') . "'); } }";

            // add styles to style-tag
            return implode("", $styles);
        } catch (\Exception $e) {
            return '';
        }
    }

    /**
     * creates an image while pay attention to crop and max-width.
     */
    protected function getImageSource(string $device): string
    {
        $targetWidth = 575;
        $maxWidth = $this->getPictureService()->getDisplayWidth($device);
        while ($targetWidth < $maxWidth) {
            $targetWidth += 575;
        }

        return $this->getPictureService()->getImageSource($device, $targetWidth);
    }
}
