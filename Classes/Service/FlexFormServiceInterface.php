<?php

namespace LBRmedia\Bootstrap\Service;

interface FlexFormServiceInterface
{
    /**
     * @param string $configurationType One of the constants
     */
    public function getConfiguration(string $xmlString, string $configurationType): array;
}
