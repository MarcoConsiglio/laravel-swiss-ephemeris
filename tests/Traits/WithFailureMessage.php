<?php
namespace MarcoConsiglio\Ephemeris\Tests\Traits;

use Illuminate\Support\Enumerable;

/**
 * Provides testing failure message helpers.
 */
trait WithFailureMessage
{
    /**
     * Gets a property type failure message.
     *
     * @param string $property The property name
     * @return string
     */
    protected static function typeFail(string $property): string
    {
        return "'$property' type not expected.";
    }

    /**
     * Gets a getter/setter failure message.
     *
     * @param string $property The property name
     * @return string
     */
    protected static function propertyFail(string $property): string
    {
        return "'$property' property is not working properly.";
    }

    /**
     * Gets a function failure message.
     *
     * @param string $name The function name.
     * @return string
     */
    protected static function functionFail(string $name): string
    {
        return "'$name()' method is not working properly.";
    }

    /**
     * Gets an enumeration failure message.
     *
     * @param string $constant The enumeration constant name.
     * @return string
     */
    protected static function enumFail($constant): string
    {
        return "'$constant' enumeration constant is not working properly.";
    }

    /**
     * Gets an instance type failure message.
     *
     * @param [type] $expected_class
     * @param [type] $actual_class
     * @return string
     */
    protected static function instanceTypeFail($expected_class, $actual_class): string
    {
        return "Expected $expected_class class but found $actual_class class instead.";
    }
}