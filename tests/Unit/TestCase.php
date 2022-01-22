<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit;

use Faker\Factory;
use InvalidArgumentException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Rule\AnyInvokedCount;
use PHPUnit\Framework\TestCase as FrameworkTestCase;
use ReflectionClass;
use Faker\Generator;

abstract class TestCase extends FrameworkTestCase
{
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
                        ->onlyMethods($mocked_methods)
                        ->disableOriginalConstructor();
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
     * Alias for any method.
     *
     * @return \PHPUnit\Framework\MockObject\Rule\AnyInvokedCount
     */
    public function anyTime(): AnyInvokedCount
    {
        return $this->any();
    }
}