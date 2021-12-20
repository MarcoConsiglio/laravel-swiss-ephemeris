<?php
namespace MarcoConsiglio\Ephemeris\Tests\Traits;

trait WithFailureMessage
{
    /**
     * Get a property type failure message.
     *
     * @param string $property
     * @return string
     */
    protected function typeFail(string $property): string
    {
        return "'$property' type not expected.";
    }

    /**
     * Get a getter failure message.
     *
     * @param string $property
     * @return string
     */
    protected function getterFail(string $property): string
    {
        return "'$property' property is not working properly.";
    }
}