<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\DataProcessing;

class VariousProperty
{
    /**
     * @var string property name in $processedData
     */
    public $property;

    /**
     * @var string Either data, flexform, file or files
     */
    public $type;

    /**
     * @var string
     */
    public $field;

    /**
     * @var mixed
     */
    public $defaultValue;

    /**
     * @var string Either string, int, float, bool, object, array, extbase
     */
    public $propertyType;

    /**
     * @var array
     */
    public $settings;

    public function __construct(string $property, string $type, string $field, $defaultValue, string $propertyType, array $settings = [])
    {
        $this->property = $property;
        $this->defaultValue = $defaultValue;
        $this->type = $type;
        $this->field = $field;
        $this->propertyType = $propertyType;
        $this->settings = $settings;
    }
}
