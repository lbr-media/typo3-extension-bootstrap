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

namespace LBRmedia\Bootstrap\Hooks;

class IconSet
{
    /**
     * Get the HTML markup for bootstrap icons.
     * Is used as hook function.
     *
     * @param array $params Array with keys 'set' and 'value'.
     * @return string The icon markup or an empty string it is not the required icon set
     */
    public function getBootstrapIconMarkup($params): string
    {
        if ($params['set'] === 'bsicons') {
            return  '<i class="bs ' . $params['value'] . '"></i>';
        }

        return '';
    }
}
