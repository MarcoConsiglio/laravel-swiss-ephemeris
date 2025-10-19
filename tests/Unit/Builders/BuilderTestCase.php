<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Builders;

use MarcoConsiglio\Ephemeris\Tests\Traits\WithMockedSwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

abstract class BuilderTestCase extends TestCase
{
    use WithMockedSwissEphemerisDateTime;
    
    /**
     * Implemented in a concrete BuilderTestCase, returns the
     * concrete rhythm builder to test.
     * 
     * @return string
     */
    protected abstract function getBuilderClass(): string;

    /**
     * Constructs a mocked Rhythm\Builder based on the getBuilderClass method.
     *
     * @param array $mocked_methods The methods you want to hide or mock.
     * @param boolean $original_constructor Wheater you want to enable the original class constructor or a mocked one.
     * @param mixed $constructor_arguments If $oroginal_constructor = true pass here the constructor arguments.
     * @return \PHPUnit\Framework\MockObject\MockObject
     */
    protected function getMockedRhythmBuilder(array $mocked_methods = [], $original_constructor = false, mixed $constructor_arguments = []): MockObject
    {
        return $this->getMocked($this->getBuilderClass(), $mocked_methods, $original_constructor, $constructor_arguments);
    }

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void {
        parent::setUp();
    }
}