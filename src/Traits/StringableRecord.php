<?php
namespace MarcoConsiglio\Ephemeris\Traits;

/**
 * Support for objects that implements the Stringable interface.
 */
trait StringableRecord
{
    /**
     * Procude a string representation of the object
     * which class has the Stringable trait.
     */
    protected function toString(): string
    {
        $class_name = class_basename($this->getClassName());
        $properties = $this->packProperties();
        ksort($properties, SORT_STRING);
        $output = $class_name.PHP_EOL;
        foreach($properties as $property_name => $property_value) {
            $output .= "$property_name: $property_value".PHP_EOL;
        }
        return $output;
    }

    /**
     * Implementation of the Stringable interface.
     * 
     * @return string
     */
    public function __tostring() 
    {
        return $this->toString();
    }

    /**
     * Pack the object properties in an associative array.
     *
     * The keys are the object properties names. The values
     * are the object properties already formatted values.
     * It is the responsibility of the Stringable class to
     * format its properties correctly.
     */
    abstract protected function packProperties(): array;

    /**
     * Get the parent properties packed in an associative
     * array.
     *
     * The keys are the object properties names. The values
     * are the object properties already formatted values.
     * It is the responsibility of the Stringable class to
     * merge the properties of the parent class into its
     * own properties.
     */
    abstract protected function getParentProperties(): array;

    /**
     * Return the class name of the Stringable class.
     *
     * The Stringable class means every class with the
     * trait Stringable.
     */
    protected function getClassName(): string
    {
        return static::class;
    }

    /**
     * Cast a pure enum constant to string.
     */
    protected function enumToString(mixed $enum_constant): string
    {
        return ((array) $enum_constant)["name"];
    }
}