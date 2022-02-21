<?php

namespace LBRmedia\Bootstrap\ViewHelpers\Bootstrap;

use LBRmedia\Bootstrap\Utility\Picture\BootstrapPictureUtility as PictureUtilty;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
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
     * The image to process.
     *
     * @var \TYPO3\CMS\Core\Resource\FileReference
     */
    protected $image = null;

    /**
     * @var \LBRmedia\Bootstrap\Utility\Picture\BootstrapPictureUtility
     */
    protected $pictureUtility = null;

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

    /**
     * return \LBRmedia\Bootstrap\Utility\Picture\BootstrapPictureUtility $pictureUtility.
     */
    protected function getPictureUtility(): PictureUtilty
    {
        if (null === $this->pictureUtility) {
            $this->pictureUtility = GeneralUtility::makeInstance(PictureUtilty::class);
        }

        return $this->pictureUtility;
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
        $this->registerArgument('displayWidth', 'array', 'array with keys std, sm, md, lg, xl and xxl with percent values of the full window width', false, []);
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
            $this->getPictureUtility()->setFileReference($file);

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
                $imgTag = $this->getObjectManager->get(TagBuilder::class);
                $imgTag->setTagName('img');
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
            $this->getPictureUtility()
                ->initializeCropVariantsProcessingInstructions($this->arguments['forceCropVariant']);

            // determine/override widths by viewhelper argument
            if ($this->arguments['displayWidth']) {
                $this->getPictureUtility()->overwriteDisplayWidthsWithViewHelperArgument($this->arguments['displayWidth']);
            }

            // create sources
            $sources = [];
            foreach (PictureUtilty::DEVICES as $device) {
                $sources[$device] = $this->buildSourceTagParams($device, PictureUtilty::MEDIA_QUERIES[$device]);
            }

            // build source tags
            $pictureContent = [];
            if (count($sources)) {
                foreach ($sources as $device => $source) {
                    $sourceTag = $this->getObjectManager()->get(TagBuilder::class);
                    $sourceTag->setTagName('source');
                    $sourceTag->forceClosingTag(false);
                    $sourceTag->addAttribute('media', $source['media']);
                    $sourceTag->addAttribute('srcset', $source['source']);
                    $pictureContent[] = '<!--'.$device.' cdw:'.$this->getPictureUtility()->getDisplayWidth($device).'px -->'.$sourceTag->render();
                }
            }

            // build fallback image and tag
            $imgTag = $this->getObjectManager()->get(TagBuilder::class);
            $imgTag->setTagName('img');
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
        $maxWidth = $this->getPictureUtility()->getDisplayWidth($device);
        $targetWidth = 575;
        while ($targetWidth < $maxWidth) {
            $targetWidth += 575;
        }

        // build 1x source
        $sources = [
            $this->getPictureUtility()->getImageSource($device, $targetWidth).' 1x',
        ];

        // build 2x source
        if ($targetWidth * 2 <= 575 * 4) {
            $sources[] = $this->getPictureUtility()->getImageSource($device, $targetWidth * 2).' 2x';
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
