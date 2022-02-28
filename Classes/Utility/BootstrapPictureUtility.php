<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Utility;

class BootstrapPictureUtility extends PictureUtility
{
    const DEVICES = [
        'xs',
        'sm',
        'md',
        'lg',
        'xl',
        'xxl',
    ];

    const DISPLAY_WIDTH_XS = 576;
    const DISPLAY_WIDTH_SM = 768;
    const DISPLAY_WIDTH_MD = 992;
    const DISPLAY_WIDTH_LG = 1200;
    const DISPLAY_WIDTH_XL = 1600;
    const DISPLAY_WIDTH_XXL = 1920;

    const MEDIA_QUERIES = [
        'xs' => '(max-width: 575.98px)', // Extra small devices (portrait phones, less than 576px)
        'sm' => '(min-width: 576px) and (max-width: 767.98px)', // Small devices (landscape phones, 576px and up)
        'md' => '(min-width: 768px) and (max-width: 991.98px)', // Medium devices (tablets, 768px and up)
        'lg' => '(min-width: 992px) and (max-width: 1199.98px)', // Large devices (desktops, 992px and up)
        'xl' => '(min-width: 1200px) and (max-width: 1499.98px)', // Extra large devices (large desktops, 1200px and up)
        'xxl' => '(min-width: 1400px)', // Extra extra large devices (large desktops, 1400px and up)
    ];

    const DISPLAY_WIDTHS = [
        'xs' => self::DISPLAY_WIDTH_XS,
        'sm' => self::DISPLAY_WIDTH_SM,
        'md' => self::DISPLAY_WIDTH_MD,
        'lg' => self::DISPLAY_WIDTH_LG,
        'xl' => self::DISPLAY_WIDTH_XL,
        'xxl' => self::DISPLAY_WIDTH_XXL,
    ];

    public $displayWidths = self::DISPLAY_WIDTHS;

    /**
     * @var array
     */
    public $cropVariantsProcessingInstructions = [
        'xs' => null,
        'sm' => null,
        'md' => null,
        'lg' => null,
        'xl' => null,
        'xxl' => null,
    ];

    /**
     * @param array $displayWidthArgument array with keys xs, sm, md, lg and xl with percent values of the full window width of each device.
     */
    public function overwriteDisplayWidthsWithViewHelperArgument(array $displayWidthArgument): self
    {
        foreach ($displayWidthArgument as $device => $percentValue) {
            if (is_numeric($percentValue) && (float) $percentValue > 0 && (float) $percentValue <= 100) {
                switch ($device) {
                    case 'xs':
                        $this->setDisplayWidth('xs', self::DISPLAY_WIDTH_XS / 100 * (float) $percentValue);
                        break;
                    case 'sm':
                        $this->setDisplayWidth('sm', self::DISPLAY_WIDTH_SM / 100 * (float) $percentValue);
                        break;
                    case 'md':
                        $this->setDisplayWidth('md', self::DISPLAY_WIDTH_MD / 100 * (float) $percentValue);
                        break;
                    case 'lg':
                        $this->setDisplayWidth('lg', self::DISPLAY_WIDTH_LG / 100 * (float) $percentValue);
                        break;
                    case 'xl':
                        $this->setDisplayWidth('xl', self::DISPLAY_WIDTH_XL / 100 * (float) $percentValue);
                        break;
                    case 'xxl':
                        $this->setDisplayWidth('xxl', self::DISPLAY_WIDTH_XXL / 100 * (float) $percentValue);
                        break;
                }
            }
        }

        return $this;
    }
}
