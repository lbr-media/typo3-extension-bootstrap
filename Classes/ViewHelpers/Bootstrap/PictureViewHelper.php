<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\ViewHelpers\Bootstrap;

use LBRmedia\Bootstrap\Service\PictureServiceBootstrap;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\TagBuilder;

class PictureViewHelper extends AbstractTagBasedViewHelper
{
    /**
     * main tag name.
     *
     * @var string
     */
    protected $tagName = 'picture';

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
     * @var PictureServiceBootstrap
     */
    protected $pictureService;

    public function __construct(PictureServiceBootstrap $pictureService)
    {
        $this->pictureService = $pictureService;
        $this->pictureService->__reset();
        parent::__construct();
    }

    /**
     * Undocumented function.
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
    }

    /**
     * Creates an picture-tag with some sources related to the alternative images append as child of a FileReference.
     *
     * @return string HTML
     *
     * @author Marcel Briefs <marcel.briefs@lbrmedia.de>
     *
     * @api
     */
    public function render(): string
    {
        try {
            $file = $this->arguments['file'];

            if ($file instanceof \TYPO3\CMS\Extbase\Domain\Model\FileReference) {
                $file = $file->getOriginalResource();
            } elseif (!$file instanceof \TYPO3\CMS\Core\Resource\FileReference) {
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
                    $pictureContent[] = '<!--' . $device . ' cdw:' . $this->pictureService->getDisplayWidth($device) . 'px -->' . $sourceTag->render();
                }
            }

            // build fallback image and tag
            $imgTag = new TagBuilder('img');
            $imgTag->forceClosingTag(false);
            //$imgTag->addAttribute("src", $this->getImageSource($defaultImage, 768));
            $imgTag->addAttribute('src', 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==');
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
     */
    protected function buildSourceTagParams(string $device, string $media): array
    {
        $maxWidth = $this->pictureService->getDisplayWidth($device);
        $targetWidth = 575;
        while ($targetWidth < $maxWidth) {
            $targetWidth += 575;
        }

        // build 1x source
        $sources = [
            $this->pictureService->getImageSource($device, $targetWidth) . ' 1x',
        ];

        // build 2x source
        if ($targetWidth * 2 <= 575 * 4) {
            $sources[] = $this->pictureService->getImageSource($device, $targetWidth * 2) . ' 2x';
        }

        // build 3x source
        //if ($targetWidth * 3 <= 480 * 3) {
        //    $sources[] = $this->getImageSource($device, $targetWidth * 3) . " 3x";
        //}

        return [
            'source' => 1 === count($sources) ? substr(implode(', ', $sources), 0, -3) : implode(', ', $sources),
            'media' => $media,
        ];
    }
}
