<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Service;

use TYPO3\CMS\Core\Imaging\ImageManipulation\CropVariantCollection;
use TYPO3\CMS\Core\Resource\FileReference;
use TYPO3\CMS\Extbase\Service\ImageService;

class PictureService
{
    /**
     * @var array
     */
    public $displayWidths = [];

    /**
     * The fileReference to process.
     *
     * @var FileReference
     */
    protected $fileReference;

    /**
     * The image to process.
     *
     * @var FileReference
     */
    protected $image;

    /**
     * @var array
     */
    public $cropVariantsProcessingInstructions = [];

    /**
     * @var ImageService
     */
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
        $this->__reset();
    }

    public function __reset(): self
    {
        $this->displayWidths = [];
        $this->fileReference = null;
        $this->image = null;
        $this->cropVariantsProcessingInstructions = [];

        return $this;
    }

    /**
     * Get the fileReference to process.
     *
     * @return FileReference
     */
    public function getFileReference()
    {
        return $this->fileReference;
    }

    /**
     * Set the fileReference to process.
     *
     * @param FileReference $fileReference The fileReference to process
     */
    public function setFileReference(FileReference $fileReference): self
    {
        $this->fileReference = $fileReference;

        return $this;
    }

    /**
     * Get the image to process.
     *
     * @return FileReference
     */
    public function getImage(): ?FileReference
    {
        if (null === $this->image) {
            $this->image = $this->imageService->getImage('', $this->fileReference, true);
        }

        return $this->image;
    }

    /**
     * Returns the displayWidths for each device.
     */
    public function getDisplayWidths(): array
    {
        return $this->displayWidths;
    }

    /**
     * Returns the displayWidth for one device.
     */
    public function getDisplayWidth($device): float
    {
        return $this->displayWidths[$device];
    }

    /**
     * Sets a display width for a device,.
     */
    public function setDisplayWidth(string $device, float $width): self
    {
        $this->displayWidths[$device] = $width;

        return $this;
    }

    /**
     * Fetches the cropVariants from image/fileReference and builds an array for the devices.
     *
     * @param string $cropVariantToForce If this key is set (xs, sm, md...) the cropVariant of this key is used for all
     */
    public function initializeCropVariantsProcessingInstructions(string $cropVariantToForce = ''): self
    {
        if ($this->fileReference->hasProperty('crop') && $this->fileReference->getProperty('crop')) {
            $cropVariantCollection = CropVariantCollection::create((string)$this->fileReference->getProperty('crop'));
            foreach ($this->cropVariantsProcessingInstructions as $device => &$processingInstructions) {
                $cropArea = $cropVariantCollection->getCropArea($cropVariantToForce ? $cropVariantToForce : $device);
                $processingInstructions = $cropArea->isEmpty() ? null : $cropArea->makeAbsoluteBasedOnFile($this->fileReference);
            }
        }

        return $this;
    }

    /**
     * Returns the cropVariants processing instructions for each device.
     * Run initializeCropVariantsProcessingInstructions() before!
     */
    public function getCropVariantsProcessingInstructions(): array
    {
        return $this->cropVariantsProcessingInstructions;
    }

    /**
     * creates an image while pay attention to crop and max-width.
     */
    public function getImageSource(string $device, int $maxWidth = 0): string
    {
        if (0 === $maxWidth) {
            $maxWidth = $this->getDisplayWidth($device);
        }

        // render image
        $processedImage = $this->imageService->applyProcessingInstructions(
            $this->getImage(),
            [
                'maxWidth' => $maxWidth,
                'crop' => $this->cropVariantsProcessingInstructions[$device],
            ]
        );

        return $this->imageService->getImageUri($processedImage);
    }
}
