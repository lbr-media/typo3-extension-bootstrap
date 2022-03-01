<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Utility;

/**
 * Class to get some css classes from flexform values.
 * Used in bootstrap mode.
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
     * @param string $widths Semicolon divided string for xs, sm, md, lg, xl, xxl
     */
    public static function getColClasses(string $widths): string
    {
        if (!trim($widths)) {
            return '';
        }

        $e = explode(';', $widths);

        $classes = [];

        foreach (self::DEVICE_INFIXES as $pos => $device) {
            if (isset($e[$pos]) && $e[$pos]) {
                $classes[] = 'col-' . $device . $e[$pos];
            }
        }

        return count($classes) ? implode(' ', $classes) : 'col';
    }

    /**
     * @param string $paddings       Semicolon divided string for xs, sm, md, lg, xl, xxl
     * @param string $directionInfix just an empty string for all directions or the other bootstrap directions like x, y, l, t, r, b
     */
    public static function getDevicePaddingClasses(string $paddings, string $directionInfix = ''): string
    {
        if (!trim($paddings)) {
            return '';
        }

        $e = explode(';', $paddings);

        $classes = [];

        foreach (self::DEVICE_INFIXES as $pos => $device) {
            if (isset($e[$pos]) && is_numeric($e[$pos])) {
                $classes[] = 'p' . $directionInfix . '-' . $device . $e[$pos];
            }
        }

        return implode(' ', $classes);
    }

    /**
     * @param string $margins        Semicolon divided string for xs, sm, md, lg, xl, xxl
     * @param string $directionInfix just an empty string for all directions or the other bootstrap directions like x, y, l, t, r, b
     */
    public static function getDeviceMarginClasses(string $margins, string $directionInfix = ''): string
    {
        if (!trim($margins)) {
            return '';
        }

        $e = explode(';', $margins);

        $classes = [];

        foreach (self::DEVICE_INFIXES as $pos => $device) {
            if (isset($e[$pos]) && is_numeric($e[$pos])) {
                $classes[] = 'm' . $directionInfix . '-' . $device . $e[$pos];
            }
        }

        return implode(' ', $classes);
    }

    /**
     * @param array $margins [
     *     'xs' => 'left;right;horizontal;top;bottom;vertical;all',
     *     'sm' => ';;;;;;',
     *     'md' => ';;;;;;',
     *     'lg' => ';;;;;;',
     *     'xl' => ';;;;;;',
     *     'xxl' => ';;;;;;',
     * ]
     */
    public static function getMarginClasses(array $margins): string
    {
        return self::getSpaceClasses($margins, 'm');
    }

    /**
     * @param array $paddings [
     *     'xs' => 'left;right;horizontal;top;bottom;vertical;all',
     *     'sm' => ';;;',
     *     'md' => ';;;',
     *     'lg' => ';;;',
     *     'xl' => ';;;',
     *     'xxl' => ';;;',
     * ]
     */
    public static function getPaddingClasses(array $paddings): string
    {
        return self::getSpaceClasses($paddings, 'p');
    }

    /**
     * @param array $spaces [
     *    'xs' => 'left;right;horizontal;top;bottom;vertical;all',
     *    'sm' => ';;;',
     *    'md' => ';;;',
     *    'lg' => ';;;',
     *    'xl' => ';;;',
     *    'xxl' => ';;;',
     * ]
     */
    public static function getSpaceClasses(array $spaces, string $prefix): string
    {
        if (!is_array($spaces)) {
            return '';
        }

        $classes = [];
        $keys = [
            0 => 'l', // left
            1 => 'r', // right
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
     * @param string $borderOptions border-class;border-width-class;border-color-class;rounded-class;shadow-class
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
     * @param string $alignments Semicolon separated list of values: xs;sm;md;lg;xl;xxl => left;right;;center;
     * @param string $prefix     Something like 'text-', 'justify-content-' or 'align-items-'
     */
    public static function getAlignmentClasses(string $alignments, string $prefix): string
    {
        if (!trim($alignments)) {
            return '';
        }

        $e = explode(';', $alignments);
        $classes = [];

        foreach (self::DEVICE_INFIXES as $pos => $device) {
            if (isset($e[$pos]) && $e[$pos]) {
                $classes[] = $prefix . $device . $e[$pos];
            }
        }

        return implode(' ', $classes);
    }

    /**
     * Generates classes for grid elements to get equal space between columns.
     * 
     * @param string $spaceX Six integer values for the devices "xs;sm;md;lg;xl;xxl"
     * @param string $spaceY Six integer values for the devices "xs;sm;md;lg;xl;xxl"
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
     * Generates classes for grid elements to get equal space between columns.
     * 
     * @param string $space Six integer values for the devices "xs;sm;md;lg;xl;xxl"
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
     * Generates classes for grid elements to set the order.
     * Used in tx_base_flexform_grid in Bootstrap environment.
     * <div class="row">
     *      <div class="col-text col order-[0|1]">
     *      <div class="col-media col order-[0|1]">
     * </div>.
     *
     * @param string $orderClasses Five string values either "", "text_media" or "media_text" for the devices "xs;sm;md;lg;xl;xxl"
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
     * @param string $floats Five string values (left|none|right) for the devices "xs;sm;md;lg;xl;xxl"
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
     * @param string $widths   Five int values from 1 to 12 for the devices "xs;sm;md;lg;xl;xxl"
     * @param string $floats   Five string values (left|none|right) for the devices "xs;sm;md;lg;xl;xxl"
     * @param string $spaces_x Five int values from 1 to 15(?) for the devices "xs;sm;md;lg;xl;xxl"
     * @param string $spaces_y Five int values from 1 to 15(?) for the devices "xs;sm;md;lg;xl;xxl"
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
}
