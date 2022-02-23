<?php

declare(strict_types=1);

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
    public function process(string $xmlString):array;
}
