<?php

declare(strict_types=1);

/*
 * @package LBRmedia Bootstrap Template - Provides Twitter Bootstrap 5 and some content elements.
 * @version 1.0.17
 * @author Marcel Briefs <mb@lbrmedia.de>
 * @copyright 2022 LBRmedia
 * @link https://github.com/lbr-media/typo3-extension-bootstrap
 * @license GPL-2.0-or-later
 */

namespace LBRmedia\Bootstrap\Utility;

use LBRmedia\Bootstrap\Form\Element\AllEdgesElement;
use LBRmedia\Bootstrap\Form\Element\BootstrapBorderElement;
use LBRmedia\Bootstrap\Form\Element\BootstrapIconsElement;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\TagBuilder;

/**
 * Utility class to get some css classes from flexform values.
 * It also creates some HTML markup when processing flexform values.
 */
class BootstrapUtility
{
    const DEVICES = [
        'xs' => 'XS',
        'sm' => 'SM',
        'md' => 'MD',
        'lg' => 'LG',
        'xl' => 'XL',
        'xxl' => 'XXL',
    ];

    const DEVICE_INFIXES = [
        0 => '',
        1 => 'sm-',
        2 => 'md-',
        3 => 'lg-',
        4 => 'xl-',
        5 => 'xxl-',
    ];

    /**
     * Creates classes for all devices from xs to xxl.
     *
     * @param string $values  Semicolon separated list of values: xs;sm;md;lg;xl;xxl => start;end;;center;
     * @param string $prefix Something like 'col-', 'text-', 'justify-content-', 'align-items-', 'iconset-'
     * @return string The classes imploded by space.
     */
    public static function getDeviceClasses(string $values, string $prefix = ''): string
    {
        if (!trim($values)) {
            return '';
        }

        $e = explode(';', $values);
        $classes = [];

        foreach (self::DEVICE_INFIXES as $pos => $infix) {
            if (isset($e[$pos]) && $e[$pos]) {
                $classes[] = $prefix . $infix . $e[$pos];
            }
        }

        return implode(' ', $classes);
    }

    /**
     * Creates col-* classes for each device from xs to xxl.
     *
     * @param string $widths Semicolon divided string for xs, sm, md, lg, xl, xxl
     * @return string A CSS classes string.
     */
    public static function getColClasses(string $widths): string
    {
        $classes = self::getDeviceClasses($widths, 'col-');

        return $classes ? $classes : 'col';
    }

    /**
     * Creates padding classes for all devices from xs to xxl.
     *
     * @param string $paddings       Semicolon divided string for xs, sm, md, lg, xl, xxl
     * @param string $directionInfix just an empty string for all directions or the other bootstrap directions like x, y, s, t, e, b
     * @return string A CSS classes string.
     */
    public static function getDevicePaddingClasses(string $paddings, string $directionInfix = ''): string
    {
        return self::getDeviceClasses($paddings, 'p' . $directionInfix . '-');
    }

    /**
     * @param string $margins        Semicolon divided string for xs, sm, md, lg, xl, xxl
     * @param string $directionInfix Just an empty string for all directions or the other bootstrap directions like x, y, s, t, e, b
     * @return string A CSS classes string.
     */
    public static function getDeviceMarginClasses(string $margins, string $directionInfix = ''): string
    {
        return self::getDeviceClasses($margins, 'm' . $directionInfix . '-');
    }

    /**
     * Creates margin classes for all devices and sides.
     *
     * @code{.php}
     * $margins = [
     *     'xs' => 'left;right;horizontal;top;bottom;vertical;all',
     *     'sm' => ';;;;;;',
     *     'md' => ';;;;;;',
     *     'lg' => ';;;;;;',
     *     'xl' => ';;;;;;',
     *     'xxl' => ';;;;;;',
     * ]
     * @endcode
     *
     * @see AllEdgesElement::render()
     * @param array $margins
     * @return string A CSS classes string.
     */
    public static function getMarginClasses(array $margins): string
    {
        return self::getSpaceClasses($margins, 'm');
    }

    /**
     * Creates padding classes for all devices and sides.
     *
     * @code{.php}
     * $paddings [
     *     'xs' => 'left;right;horizontal;top;bottom;vertical;all',
     *     'sm' => ';;;;;;',
     *     'md' => ';;;;;;',
     *     'lg' => ';;;;;;',
     *     'xl' => ';;;;;;',
     *     'xxl' => ';;;;;;',
     * ]
     * @endcode
     *
     * @see AllEdgesElement::render()
     * @param array $paddings
     * @return string A CSS classes string.
     */
    public static function getPaddingClasses(array $paddings): string
    {
        return self::getSpaceClasses($paddings, 'p');
    }

    /**
     * Creates margin classes for all devices.
     *
     * @code{.php}
     * $spaces [
     *     'xs' => 'left;right;horizontal;top;bottom;vertical;all',
     *     'sm' => ';;;;;;',
     *     'md' => ';;;;;;',
     *     'lg' => ';;;;;;',
     *     'xl' => ';;;;;;',
     *     'xxl' => ';;;;;;',
     * ]
     * @endcode
     *
     * @see AllEdgesElement::render()
     * @param array $spaces
     * @param string $prefix
     * @return string A CSS classes string.
     */
    public static function getSpaceClasses(array $spaces, string $prefix): string
    {
        if (!is_array($spaces)) {
            return '';
        }

        $classes = [];
        $keys = [
            0 => 's', // left
            1 => 'e', // right
            2 => 'x', // horizontal
            3 => 't', // top
            4 => 'b', // bottom
            5 => 'y', // vertical
            6 => '', // all
        ];
        foreach (array_keys(self::DEVICES) as $device) {
            if (isset($spaces[$device]) && $spaces[$device]) {
                $finalDevice = 'xs' === $device ? '' : $device . '-';

                $values = explode(';', $spaces[$device]);

                foreach ($keys as $key => $class) {
                    if (!isset($values[$key])) {
                        break;
                    }
                    $value = $values[$key];
                    if ('' !== $value && 'default' !== $value) {
                        $classes[] = $prefix . $class . '-' . $finalDevice . $value;
                    }
                }
            }
        }

        return implode(' ', $classes);
    }

    /**
     * Transforms border option classes from semicolon separated list to space separated classes list.
     *
     * @see BootstrapBorderElement::render()
     * @param string $borderOptions border-class;border-width-class;border-color-class;rounded-class;shadow-class
     * @return string A CSS classes string.
     */
    public static function getBorderOptionClasses(string $borderOptions): string
    {
        if (!trim($borderOptions)) {
            return '';
        }

        $sections = explode(';', $borderOptions);
        $classes = [];
        foreach ($sections as $section) {
            if ($section) {
                $classes[] = $section;
            }
        }

        return implode(' ', $classes);
    }

    /**
     * Generates bootstrap gutter classes for grid elements to get equal space between columns.
     * Here x and y values will be processed.
     *
     * @see BootstrapUtility::getGridSpaceClasses() to get one value for x and y.
     * @param string $spaceX Six integer values for the devices "xs;sm;md;lg;xl;xxl"
     * @param string $spaceY Six integer values for the devices "xs;sm;md;lg;xl;xxl"
     * @return array
     */
    public static function getGridSpaceXYClasses(string $spaceX, string $spaceY): array
    {
        // determine space classes
        $rowClasses = [];
        $colClasses = [];

        if ($spaceX) {
            $spaces = explode(';', $spaceX);
            foreach (self::DEVICE_INFIXES as $pos => $device) {
                if (isset($spaces[$pos]) && is_numeric($spaces[$pos])) {
                    $rowClasses[] = 'gx-' . $device . $spaces[$pos];
                }
            }
        }

        if ($spaceY) {
            $spaces = explode(';', $spaceY);
            foreach (self::DEVICE_INFIXES as $pos => $device) {
                if (isset($spaces[$pos]) && is_numeric($spaces[$pos])) {
                    $rowClasses[] = 'gy-' . $device . $spaces[$pos];
                }
            }
        }

        return [
            'row' => implode(' ', $rowClasses),
            'col' => implode(' ', $colClasses),
        ];
    }

    /**
     * Generates bootstrap gutter classes for grid elements to get equal space between columns.
     * Here x and y will get the same value.
     *
     * @see BootstrapUtility::getGridSpaceXYClasses() for separated x and y values
     * @param string $space Six integer values for the devices "xs;sm;md;lg;xl;xxl"
     * @return string The classes imploded by space.
     */
    public static function getGridSpaceClasses(string $space): string
    {
        // determine space classes
        $classes = [];

        if ($space) {
            $spaces = explode(';', $space);
            foreach (self::DEVICE_INFIXES as $pos => $device) {
                if (isset($spaces[$pos]) && is_numeric($spaces[$pos])) {
                    $classes[] = 'g-' . $device . $spaces[$pos];
                }
            }
        }

        return implode(' ', $classes);
    }

    /**
     * Generates classes for grid elements to set the order related to the devices.
     *
     * @code{html}
     * <div class="row">
     *      <div class="col-text col order-[0|1]">
     *      <div class="col-media col order-[0|1]">
     * </div>
     * @endcode
     *
     * @param string $orderClasses Five string values either "", "text_media" or "media_text" for the devices "xs;sm;md;lg;xl;xxl"
     * @return array Array with text and media keys which holds each a class string.
     */
    public static function getGridDeviceOrderClasses(string $orderClasses): array
    {
        $textClasses = [];
        $mediaClasses = [];
        $deviceOrders = explode(';', $orderClasses);

        foreach (self::DEVICE_INFIXES as $pos => $device) {
            if (isset($deviceOrders[$pos])) {
                if ('text_media' === $deviceOrders[$pos]) {
                    $textClasses[] = ' order-' . $device . '0';
                    $mediaClasses[] = ' order-' . $device . '1';
                } elseif ('media_text' === $deviceOrders[$pos]) {
                    $textClasses[] = ' order-' . $device . '1';
                    $mediaClasses[] = ' order-' . $device . '0';
                }
            }
        }

        return [
            'text' => implode(' ', $textClasses),
            'media' => implode(' ', $mediaClasses),
        ];
    }

    /**
     * Creates float-* classes for the content element bootstrap_textmediafloat.
     *
     * @param string $floats Five string values (left|none|right) for the devices "xs;sm;md;lg;xl;xxl"
     * @return string The classes.
     */
    public static function getFloatClasses(string $floats): string
    {
        if (!trim($floats)) {
            return '';
        }

        $e = explode(';', $floats);

        $classes = [];

        foreach (self::DEVICE_INFIXES as $pos => $device) {
            if (isset($e[$pos]) && $e[$pos]) {
                $classes[] = 'float-' . $device . $e[$pos];
                if ('start' === $e[$pos] || 'end' === $e[$pos]) {
                    $classes[] = 'd-' . $device . 'block';
                } else {
                    $classes[] = 'd-' . $device . 'inline-block';
                }
            }
        }

        return implode(' ', $classes);
    }

    /**
     * Creates size classes for the content element bootstrap_textmediafloat.
     *
     * @param string $widths   Six int values from 1 to 12 or empty strings for the devices "xs;sm;md;lg;xl;xxl"
     * @param string $floats   Six string values (left|none|right) for the devices "xs;sm;md;lg;xl;xxl"
     * @param string $spaces_x Six int values from 1 to 5(?) or empty strings for the devices "xs;sm;md;lg;xl;xxl"
     * @param string $spaces_y Six int values from 1 to 5(?) or empty strings for the devices "xs;sm;md;lg;xl;xxl"
     * @return string The classes.
     */
    public static function getFloatMediaSizeClasses(string $widths, string $floats, string $spaces_x, string $spaces_y): string
    {
        if (!trim($widths)) {
            return '';
        }

        $classes = [];

        $w = explode(';', $widths);

        if ($spaces_y) {
            $y = explode(';', $spaces_y);
        }

        if ($spaces_x) {
            $x = explode(';', $spaces_x);
        }

        if ($floats) {
            $f = explode(';', $floats);
        }

        $lastFloat = 'none';
        foreach (self::DEVICE_INFIXES as $pos => $device) {
            // add width classes
            if (isset($w[$pos]) && $w[$pos]) {
                $classes[] = 'float-size-' . $device . $w[$pos];
            }

            // add space_y classes
            if (isset($y[$pos]) && is_numeric($y[$pos])) {
                $classes[] = 'mb-' . $device . $y[$pos];
            }

            if (isset($f[$pos]) && $f[$pos]) {
                $lastFloat = $f[$pos];
            }

            // add space_x classes
            if (isset($x[$pos]) && is_numeric($x[$pos])) {
                if ('start' === $lastFloat) {
                    $classes[] = 'me-' . $device . $x[$pos];
                    $classes[] = 'ms-' . $device . '0';
                } elseif ('end' === $lastFloat) {
                    $classes[] = 'ms-' . $device . $x[$pos];
                    $classes[] = 'me-' . $device . '0';
                } else {
                    // none
                    $classes[] = 'mx-' . $device . $x[$pos];
                }
            }
        }

        return implode(' ', $classes);
    }

    /**
     * Builds the icon markup from iconset.
     *
     * @see BootstrapIconsElement::render()
     * @param string $value '{iconset};{iconclass};;;'
     * @return string
     */
    public static function getIconSetMarkup(string $value): string
    {
        list($iconSet, $iconValue) = explode(';', $value);

        if (!($iconSet && $iconValue)) {
            return '';
        }

        if ($iconSet === 'bsicons') {
            return '<i class="bs ' . $iconValue . '"></i>';
        }

        return '';
    }

    /**
     * Builds the position class from iconset.
     *
     * @see BootstrapIconsElement::render()
     * @param string $value ';;{position};;'
     * @return string
     */
    public static function getIconSetPositionClass(string $value): string
    {
        list(, , $position) = array_merge(explode(';', $value), ['', '', '']);

        if ($position) {
            return 'iconset-' . $position;
        }

        return '';
    }

    /**
     * Builds the size class from iconset.
     *
     * @see BootstrapIconsElement::render()
     * @param string $value ';;;{sizeclass};'
     * @return string
     */
    public static function getIconSetSizeClass(string $value): string
    {
        list(, , , $size) = array_merge(explode(';', $value), ['', '', '', '']);

        if ($size) {
            return $size;
        }

        return '';
    }

    /**
     * Gets the color class from iconset.
     *
     * @see BootstrapIconsElement::render()
     * @param string $value ';;;;{color}'
     * @return string
     */
    public static function getIconSetColorClass(string $value): string
    {
        list(, , , , $color) = array_merge(explode(';', $value), ['', '', '', '', '']);

        if ($color) {
            return $color;
        }

        return '';
    }

    /**
     * Renders a complete iconset like this:
     *
     * @code{.html}
     * <span class="iconset iconset-{position}>
     *      <span class="iconset__icon {sizeclass}">
     *          <i class="bs {iconclass}"></i>
     *      </span>
     *      <span class="iconset__content">
     *          $content
     *      </span>
     * </span>
     * @endcode
     *
     * @see BootstrapIconsElement::render()
     * @see self::renderIconFrame()
     * @param string $value        '{iconset};{iconclass};{position};{sizeclass};{color}'
     * @param string $contentMarkup The html markup beneath the icon.
     * @param array  $configuration Additional parameters like 'additionalClasses' in the wrapper or overwriting the 'positionClasses'.
     * @return string
     */
    public static function renderIconSet(string $value, string $contentMarkup, array $configuration = []): string
    {
        list($iconSet, $iconValue, $position, $sizeClasses, $colorClasses) = array_merge(explode(';', $value), ['', '', '', '', '']);

        if (!($iconSet && $iconValue)) {
            return $contentMarkup;
        }

        /*
         * hook: renderIconSet: Gets the icon HTML markup.
         */
        $iconMarkup = '';
        if (is_array($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][\LBRmedia\Bootstrap\Utility\BootstrapUtility::class]['renderIconSet'] ?? null)) {
            $params = [
                'set' => $iconSet,
                'value' => $iconValue,
            ];
            foreach ($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][\LBRmedia\Bootstrap\Utility\BootstrapUtility::class]['renderIconSet'] as $hookMethod) {
                $iconMarkup .= GeneralUtility::callUserFunction($hookMethod, $params, null);
            }
        }

        if (!$iconMarkup) {
            return $contentMarkup;
        }

        $positionClasses = isset($configuration['positionClasses']) && $configuration['positionClasses']
            ? $configuration['positionClasses']
            : ($position ? ' iconset-' . $position : '');

        return self::renderIconFrame($iconMarkup, $contentMarkup, [
            'positionClasses' => $positionClasses,
            'additionalClasses' => isset($configuration['additionalClasses']) ? 'iconset--font ' . $configuration['additionalClasses'] : 'iconset--font',
            'sizeClasses' => $sizeClasses,
            'colorClasses' => $colorClasses,
        ]);
    }

    /**
     * Renders a complete iconset like this:
     *
     * @code{.html}
     * <span class="iconset {positionClasses} {additionalClasses}">
     *      <span class="iconset__icon {sizeClasses} {colorClasses}">
     *          {iconMarkup}
     *      </span>
     *      <span class="iconset__content">
     *          {contentMarkup}
     *      </span>
     * </span>
     * @endcode
     *
     * @see BootstrapIconsElement::render()
     * @param string $iconMarkup    The html markup for the icon
     * @param string $content       The html markup beneath the icon.
     * @param array  $configuration Additional stuff like 'positionClasses' and 'additionalClasses' in the outer wrapper or 'sizeClasses' and 'colorClasses' in the icon wrapper.
     * @return string
     */
    public static function renderIconFrame(string $iconMarkup, string $contentMarkup, array $configuration = []): string
    {
        if (!$iconMarkup) {
            return $contentMarkup;
        }

        // Create the outer wrap
        $iconWrap = new TagBuilder('span');
        $iconWrap->addAttribute(
            'class',
            'iconset' .
            (isset($configuration['positionClasses']) && $configuration['positionClasses'] ? ' ' . $configuration['positionClasses'] : '') .
            (isset($configuration['additionalClasses']) && $configuration['additionalClasses'] ? ' ' . $configuration['additionalClasses'] : '')
        );

        // Create the icon wrap
        $iconGfx = new TagBuilder('span');
        $iconGfx->addAttribute(
            'class',
            'iconset__icon' .
            (isset($configuration['sizeClasses']) && $configuration['sizeClasses'] ? ' ' . $configuration['sizeClasses'] : '') .
            (isset($configuration['colorClasses']) && $configuration['colorClasses'] ? ' ' . $configuration['colorClasses'] : '')
        );
        $iconGfx->setContent($iconMarkup);

        // Create the content wrap
        $iconContent = new TagBuilder('span');
        $iconContent->addAttribute('class', 'iconset__content');
        $iconContent->setContent($contentMarkup);

        $iconWrap->setContent($iconGfx->render() . $iconContent->render());

        return $iconWrap->render();
    }
}
