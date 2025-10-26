<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit;

use Illuminate\Foundation\Testing\WithFaker;
use InvalidArgumentException;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Traits\WithCustomAssertions;
use Orchestra\Testbench\TestCase as TestbenchTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use ReflectionClass;

/**
 * Unit custom TestCase.
 */
abstract class TestCase extends TestbenchTestCase
{
    use WithCustomAssertions, WithFaker;

    /**
     * This method is called before each test.
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

    /**
     * Sets a $property $value in $object.
     *
     * @param object $object
     * @param string $property
     * @param mixed  $value
     * @return void
     */
    protected function setObjectProperty(object $object, string $property, mixed $value)
    {
        $ref_class = new ReflectionClass($object);
        $ref_property = $ref_class->getProperty($property);
        $ref_property->setValue($object, $value);
    }

    /**
     * Sets $properties to $object.
     *
     * @param object $object
     * @param array  $properties
     * @return void
     */
    protected function setObjectProperties(object $object, array $properties)
    {
        foreach ($properties as $property => $value) {
            $this->setObjectProperty($object, $property, $value);
        }
    }

    /**
     * Creates a mocked SwissEphemerisDateTime.
     *
     * @param integer $year
     * @param integer $month
     * @param integer $day
     * @param integer $hour
     * @param integer $minute
     * @param integer $second
     * @param ?string|null $tz
     * @return SwissEphemerisDateTime
     */
    protected function getSwissEphemerisDateTime(
        int $year = 0, 
        int $month = 1, 
        int $day = 1, 
        int $hour = 0, 
        int $minute = 0, 
        int $second = 0, 
        ?string $tz = null): SwissEphemerisDateTime
    {
        return SwissEphemerisDateTime::create(
            $year,
            $month,
            $day,
            $hour,
            $minute,
            $second,
            $tz
        );
    }
}