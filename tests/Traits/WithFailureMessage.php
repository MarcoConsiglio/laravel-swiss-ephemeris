<?php
namespace MarcoConsiglio\Ephemeris\Tests\Traits;

/**
 * This trait provides testing failure message helpers.
 */
trait WithFailureMessage
{
    /**
     * Get a property type failure message.
     *
     * @param string $property The property name
     */
    protected static function typeFail(string $property): string
    {
        return "'$property' type not expected.";
    }

    /**
     * Get a getter/setter failure message.
     *
     * @param string $property The property name
     */
    protected static function propertyFail(string $property): string
    {
        return "'$property' property is not working properly.";
    }

    /**
     * Get a function failure message.
     *
     * @param string $name The function name.
     */
    protected static function functionFail(string $name): string
    {
        return "'$name()' method is not working properly.";
    }

    /**
     * Get an enumeration failure message.
     *
     * @param string $constant The enumeration constant name.
     */
    protected static function enumFail($constant): string
    {
        return "'$constant' enumeration constant is not working properly.";
    }

    /**
     * Get an instance type failure message.
     *
     * @param [type] $expected_class
     * @param [type] $actual_class
     */
    protected static function instanceTypeFail($expected_class, $actual_class): string
    {
        return "Expected $expected_class class but found $actual_class class instead.";
    }

    /**
     * Produce a failure message when calling $called_class::$method doesn't return
     * the expected $return_type.
     */
    protected static function methodMustReturn(string $called_class, string $method, string $return_type): string
    {
        return "Calling $called_class::$method() must return a $return_type instance.";
    }

    /**
     * Produce a failure message when calling $called_class::$method doesn't return
     * the expected $return_type in case the $condition is verified.
     */
    protected static function methodMustReturnIf(string $called_class, string $method, string $return_type, string $condition): string
    {
        return "Calling $called_class::$method() must return a $return_type instance if $condition.";
    }

    /**
     * It produces a failure message when an iterable $collection_class has at least
     * one item different than $expected_items_type
     */
    protected static function iterableMustContains(string $collection_class, string $expected_items_type): string
    {
        return "The iterable $collection_class must contain all elements of type $expected_items_type.";
    }

    /**
     * It produces a failure message when the $expected_format
     * is not equal to the $actual_format.
     *
     * @param string $expected_type The expected datetime format type,
     * i.e. "Gregorian Terrestrial Time" or others.
     */
    protected static function incorrectDateTimeFormat(
        string $expected_format, 
        string $expected_type, 
        string $actual_format): string
    {
        return "The $expected_type format must be $expected_format but found $actual_format.";
    }

    /**
     * It produces a failure message when $class don't implements $interface.
     */
    protected static function mustImplement(string $class, string $interface): string
    {
        return "The $class class must implement $interface interface.";
    }

    /**
     * It produces a failure message when $class don't extends $parent_class.
     */
    protected static function mustExtend(string $class, string $parent_class): string
    {
        return "The $class class must extends $parent_class class.";
    }
}