<?php

declare(strict_types=1);

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
    public function getBootstrapIconMarkup($params):string {
        if ($params['set'] === 'bsicons') {
            return  '<i class="bs ' . $params['value'] . '"></i>';
        }

        return '';
    }
}
