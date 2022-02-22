<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Utility\Picture;

use LBRmedia\Bootstrap\Utility\GeneralUtility as BootstrapGeneralUtility;
use TYPO3\CMS\Core\Imaging\ImageManipulation\CropVariantCollection;
use TYPO3\CMS\Core\Resource\FileReference;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Service\ImageService;

class GeneralPictureUtility
{
    public static function getTcaCropVariantsOverride(array $enabledCropVariants): array
    {
        $pageTsConfig = \TYPO3\CMS\Backend\Utility\BackendUtility::getPagesTSconfig(BootstrapGeneralUtility::getTcaCropVariantsOverridePid());
        $pageTsConfig_cropVariants = isset($pageTsConfig['TCEFORM.']['sys_file_reference.']['crop.']['config.']['cropVariants.']) ? $pageTsConfig['TCEFORM.']['sys_file_reference.']['crop.']['config.']['cropVariants.'] : [];

        $cropVariants = [];
        if (is_array($pageTsConfig_cropVariants)) {
            foreach ($pageTsConfig_cropVariants as $cropVariant => $config) {
                $cropVariant = rtrim($cropVariant, '.');
                $cropVariants[$cropVariant]['disabled'] = in_array($cropVariant, $enabledCropVariants) ? false : true;
            }
        }

        return $cropVariants;
    }

    /**
     * @var array
     */
    public $displayWidths = [];

    /**
     * The fileReference to process.
     *
     * @var \TYPO3\CMS\Core\Resource\FileReference
     */
    protected $fileReference = null;

    /**
     * The image to process.
     *
     * @var \TYPO3\CMS\Core\Resource\FileReference
     */
    protected $image = null;

    /**
     * @var array
     */
    public $cropVariantsProcessingInstructions = [];

    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     */
    protected $objectManager = null;

    /**
     * @var \TYPO3\CMS\Extbase\Service\ImageService
     */
    protected $imageService = null;

    /**
     * Get the fileReference to process.
     *
     * @return \TYPO3\CMS\Core\Resource\FileReference
     */
    public function getFileReference()
    {
        return $this->fileReference;
    }

    /**
     * Set the fileReference to process.
     *
     * @param \TYPO3\CMS\Core\Resource\FileReference $fileReference The fileReference to process
     */
    public function setFileReference(\TYPO3\CMS\Core\Resource\FileReference $fileReference): self
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
            $this->image = $this->getImageService()->getImage('', $this->fileReference, true);
        }

        return $this->image;
    }

    public function getImageService(): ImageService
    {
        if (null === $this->imageService) {
            $this->imageService = GeneralUtility::makeInstance(ImageService::class);
        }

        return $this->imageService;
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
            $cropVariantCollection = CropVariantCollection::create((string) $this->fileReference->getProperty('crop'));
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
        $processedImage = $this->getImageService()->applyProcessingInstructions(
            $this->getImage(),
            [
                'maxWidth' => $maxWidth,
                'crop' => $this->cropVariantsProcessingInstructions[$device],
            ]
        );

        return $this->getImageService()->getImageUri($processedImage);
    }
}
