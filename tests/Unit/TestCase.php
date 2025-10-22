<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit;

use Faker\Factory;
use Faker\Generator;
use InvalidArgumentException;
use MarcoConsiglio\Ephemeris\Tests\Traits\WithCustomAssertions;
use MarcoConsiglio\Ephemeris\Tests\Traits\WithMockedSwissEphemerisDateTime;
use Orchestra\Testbench\TestCase as TestbenchTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Rule\AnyInvokedCount;
use ReflectionClass;

/**
 * Unit custom TestCase.
 */
abstract class TestCase extends TestbenchTestCase
{
    use WithMockedSwissEphemerisDateTime, WithCustomAssertions;

    /**
     * The faker instance.
     *
     * @var \Faker\Generator
     */
    protected Generator $faker;

    /**
     * This method is called before each test.
     * 
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
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
}