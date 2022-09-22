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

namespace LBRmedia\Bootstrap\ViewHelpers\Bootstrap;

use LBRmedia\Bootstrap\Service\PictureServiceBootstrap;
use TYPO3\CMS\Core\Resource\FileReference as CoreFileReference;
use TYPO3\CMS\Extbase\Domain\Model\FileReference as ExtbaseFileReference;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\TagBuilder;

/**
 * Creates a picture-tag with source-tags. Each source has a srcset- and media-attribute related to a crop-variant and bootstrap breakpoint from xs till xxl.
 *
 * It will produce something like this:
 *
 * @code{.html}
 * <picture>
 *      <source media="(max-width: 575.98px)" srcset="...">
 *      <source media="(min-width: 576px) and (max-width: 767.98px)" srcset="...">
 *      <source media="(min-width: 768px) and (max-width: 991.98px)" srcset="...">
 *      <source media="(min-width: 992px) and (max-width: 1199.98px)" srcset="...">
 *      <source media="(min-width: 1200px) and (max-width: 1499.98px)" srcset="...">
 *      <source media="(min-width: 1400px)" srcset="...">
 *      <img src="..." alt="..." title="..." class="...">
 * </picture>
 * @endcode
 *
 * Examples
 * ========
 *
 * @code{.html}
 * {bs:Bootstrap.Picture(file:fileReference, displayWidth:'{
 *      xs:100,
 *      sm:50,
 *      md:33,
 *      lg:25,
 *      xl:25,
 *      xxl:25
 * }', additionalImgTagParams:'img-fluid')}
 * @endcode
 */
class PictureViewHelper extends AbstractTagBasedViewHelper
{
    /**
     * main tag name.
     *
     * @var string $tagName
     */
    protected $tagName = 'picture';

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
     * @var PictureServiceBootstrap $pictureService
     */
    protected $pictureService;

    /**
     * @param PictureServiceBootstrap $pictureService
     */
    public function __construct(PictureServiceBootstrap $pictureService)
    {
        $this->pictureService = $pictureService;
        $this->pictureService->__reset();
        parent::__construct();
    }

    /**
     * Arguments for this view helper:
     * - file
     * - title
     * - forceCropVariant
     * - alt
     * - additionalParams
     * - additionalImgTagParams
     * - displayWidth
     */
    public function initializeArguments(): void
    {
        parent::initializeArguments();
        //$this->registerUniversalTagAttributes();
        $this->registerArgument('file', 'object', 'The original FileReference with some alternative images', true);
        $this->registerArgument('title', 'string', 'title attribute', false, '');
        $this->registerArgument('forceCropVariant', 'string', 'uses this cropVariant for all produced images', false, '');
        $this->registerArgument('alt', 'string', 'alt attribute', false, '');
        $this->registerArgument('additionalParams', 'array', '', false, []);
        $this->registerArgument('additionalImgTagParams', 'array', '', false, []);
        $this->registerArgument('displayWidth', 'array', 'array with keys xs, sm, md, lg, xl and xxl with percent values of the full window width', false, []);
        $this->registerArgument('useSizes', 'boolean', 'Use sizes attribute in source tags instead of density.', false, true);
    }

    /**
     * Creates an picture-tag with some sources related to the alternative images append as child of a FileReference.
     *
     * @return string HTML
     */
    public function render(): string
    {
        try {
            $file = $this->arguments['file'];

            if ($file instanceof ExtbaseFileReference) {
                $file = $file->getOriginalResource();
            } elseif (!$file instanceof CoreFileReference) {
                throw new \Exception('The image file must be an instance of \\TYPO3\\CMS\\Extbase\\Domain\\Model\\FileReference or \\TYPO3\\CMS\\Core\\Resource\\FileReference', 1509795323);
            }

            $title = $this->arguments['title'];
            $alt = $this->arguments['alt'];
            $additionalParams = $this->arguments['additionalParams'];
            $additionalImgTagParams = $this->arguments['additionalImgTagParams'];

            // initialize picture utility
            $this->pictureService->setFileReference($file);

            /*
             * build picture tag
             */
            $this->tag->forceClosingTag(true);
            if (count($additionalParams)) {
                foreach ($additionalParams as $attribute => $value) {
                    $this->tag->addAttribute($attribute, $value);
                }
            }

            /*
             * Check for SVG image
             */
            if ('svg' === strtolower($file->getProperty('extension'))) {
                $imgTag = new TagBuilder('img');
                $imgTag->forceClosingTag(false);
                $imgTag->addAttribute('src', $file->getPublicUrl());
                $imgTag->addAttribute('alt', $alt ? $alt : $file->getProperty('alternative'));
                if ($title) {
                    $imgTag->addAttribute('title', $title);
                } elseif ($file->getProperty('title')) {
                    $imgTag->addAttribute('title', $file->getProperty('title'));
                }
                if (count($additionalImgTagParams)) {
                    foreach ($additionalImgTagParams as $attribute => $value) {
                        $imgTag->addAttribute($attribute, $value);
                    }
                }

                $this->tag->setContent($imgTag->render());

                return $this->tag->render();
            }

            // calculate/initialize display widths and crop processing instructions
            $this->pictureService
                ->initializeCropVariantsProcessingInstructions($this->arguments['forceCropVariant']);

            // determine/override widths by viewhelper argument
            if ($this->arguments['displayWidth']) {
                $this->pictureService->overwriteDisplayWidthsWithViewHelperArgument($this->arguments['displayWidth']);
            }

            // create sources
            $sources = [];
            foreach (PictureServiceBootstrap::DEVICES as $device) {
                $sources[$device] = $this->buildSourceTagParams($device, PictureServiceBootstrap::MEDIA_QUERIES[$device]);
            }

            // build source tags
            $pictureContent = [];
            if (count($sources)) {
                foreach ($sources as $device => $source) {
                    $sourceTag = new TagBuilder('source');
                    $sourceTag->forceClosingTag(false);
                    $sourceTag->addAttribute('media', $source['media']);
                    $sourceTag->addAttribute('srcset', $source['source']);
                    if ($this->arguments['useSizes']) {
                        $sourceTag->addAttribute('sizes', $source['sizes']);
                    }
                    $pictureContent[] = '<!--' . $device . ' cdw:' . $this->pictureService->getDisplayWidth($device) . 'px -->' . $sourceTag->render();
                }
            }

            // build fallback image and tag
            $imgTag = new TagBuilder('img');
            $imgTag->forceClosingTag(false);
            $imgTag->addAttribute('src', $this->pictureService->getImageSource($device, 575));
            // $imgTag->addAttribute('src', 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==');
            $imgTag->addAttribute('alt', $alt ? $alt : $file->getProperty('alternative'));
            if ($title) {
                $imgTag->addAttribute('title', $title);
            } elseif ($file->getProperty('title')) {
                $imgTag->addAttribute('title', $file->getProperty('title'));
            }
            if (count($additionalImgTagParams)) {
                foreach ($additionalImgTagParams as $attribute => $value) {
                    $imgTag->addAttribute($attribute, $value);
                }
            }

            $pictureContent[] = $imgTag->render();

            // add source- and img-tags to picture tag
            $this->tag->setContent(implode(PHP_EOL, $pictureContent));

            return $this->tag->render();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Creates source- and media params for source-tag.
     * Also creates the needed images.
     * The source image is the default image.
     *
     * @param string $device One of xs to xxl.
     * @param string $media Media query string.
     * @return array Array with keys 'source' and 'media'
     */
    protected function buildSourceTagParams(string $device, string $media): array
    {
        $maxWidth = $this->pictureService->getDisplayWidth($device);
        $targetWidth = 575;
        while ($targetWidth < $maxWidth) {
            $targetWidth += 575;
        }

        if ($this->arguments['useSizes']) {
            // build 1x source
            $sources = [
                $this->pictureService->getImageSource($device, $targetWidth) . ' ' . $targetWidth . 'w',
            ];

            // build 2x source
            if ($targetWidth * 2 <= 575 * 4) {
                $sources[] = $this->pictureService->getImageSource($device, $targetWidth) . ' ' . ($targetWidth * 2) . 'w';
            }

            // create sizes attribute
            // $size = ($this->arguments['displayWidth'] && isset($this->arguments['displayWidth'][$device]) && is_numeric($this->arguments['displayWidth'][$device]))
            //     ? (string) round((float) $this->arguments['displayWidth'][$device], 2)
            //     : '100';

            return [
                'source' => implode(', ', $sources),
                'media' => $media,
                // 'sizes' => $size . 'vw'
                'sizes' => $this->pictureService::DISPLAY_WIDTHS[$device] . 'px',
            ];
        }
        // build 1x source
        $sources = [
                $this->pictureService->getImageSource($device, $targetWidth) . ' 1x',
            ];

        // build 2x source
        if ($targetWidth * 2 <= 575 * 4) {
            $sources[] = $this->pictureService->getImageSource($device, $targetWidth * 2) . ' 2x';
        }

        return [
                'source' => 1 === count($sources) ? substr(implode(', ', $sources), 0, -3) : implode(', ', $sources),
                'media' => $media,
            ];
    }
}
