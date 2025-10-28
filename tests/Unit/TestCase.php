<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit;

use Illuminate\Foundation\Testing\WithFaker;
use InvalidArgumentException;
use Orchestra\Testbench\TestCase as TestbenchTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Traits\WithCustomAssertions;

/**
 * Unit custom TestCase.
 */
abstract class TestCase extends TestbenchTestCase
{
    use WithCustomAssertions, WithFaker;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpFaker();
    }
    
    /**
     * Get a mocked object.
     *
     * @param string  $class                    The class to mock. 
     * @param array   $mocked_methods           The methods to be replaced.
     * @param boolean $original_constructor     Enable or disable original constructor.
     * @param array   $constructor_arguments    If original constructor is enabled, it passes these arguments.
     * @return \PHPUnit\Framework\MockObject\MockObject
     */
    protected function getMocked(
        string $class,
        array $mocked_methods = [],
        bool $original_constructor = false,
        array $constructor_arguments = []
    ): MockObject
    {
        if (! class_exists($class)) {
            throw new InvalidArgumentException("The class $class does not exist.");
        }
        $builder = $this->getMockBuilder($class)
                        ->disableOriginalConstructor();
        if (!empty($mocked_methods)) {
            $builder->onlyMethods($mocked_methods);
        }
        if ($original_constructor) {
            $builder->enableOriginalConstructor()
                    ->setConstructorArgs($constructor_arguments);
        }
        return $builder->getMock();
    }
}