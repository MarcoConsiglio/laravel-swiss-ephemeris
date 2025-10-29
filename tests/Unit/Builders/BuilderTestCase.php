<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Builders;

use PHPUnit\Framework\MockObject\MockObject;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;

abstract class BuilderTestCase extends TestCase
{    
    /**
     * Get the current SUT class.
     * 
     * @return string
     */
    protected abstract function getBuilderClass(): string;
}