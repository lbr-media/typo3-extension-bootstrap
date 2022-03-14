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

namespace LBRmedia\Bootstrap\Service;

interface FlexFormServiceInterface
{
    /**
     * Transforms the xml string into an array and stores in cache.
     *
     * @param string $xmlString One of the constants
     * @return array The data array from xml string.
     */
    public function getConfiguration(string $xmlString): array;

    /**
     * Transforms the xml string into an array, stores it in cache.
     * After that the data array will be processed to use in template files.
     *
     * @param string $xmlString One of the constants
     * @return array The data array from xml string.
     */
    public function process(string $xmlString): array;
}
