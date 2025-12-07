<?php 
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders;

abstract class FromArrayTestCase extends BuilderTestCase
{
    /**
     * Return raw data to test the builder.
     *
     * @return array
     */
    protected abstract function getRawData(): array;
}