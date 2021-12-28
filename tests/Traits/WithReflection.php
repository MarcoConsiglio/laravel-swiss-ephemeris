<?php
namespace MarcoConsiglio\Ephemeris\Tests\Traits;

use ReflectionClass;

/**
 * Provides support to reflection in order to test unaccessible methods.
 */
trait WithReflection
{
    /**
     * Calls a $method of an $object.
     * @param object $object
     * @param string $method
     * @param array $parameters
     * @return mixed
     * @throws \ReflectionException
     */
    protected function callMethod(object $object, string $method , ...$parameters)
    {
        $class = $this->getReflectionClass($object);
        $method = $class->getMethod($method);
        $method->setAccessible(true);
        return $method->invokeArgs($object, ...$parameters);
    }

    /**
     * Gets a $property value from an $object.
     *
     * @param object $object
     * @param string $property
     * @return mixed
     */
    protected function get(object $object, string $property)
    {
        $class = $this->getReflectionClass($object);
        return $class->getProperty($property)->getValue();
    }

    /**
     * Gets the ReflectionClass counterpart of an $instance.
     *
     * @param object $instance
     * @return \ReflectionClass
     */
    private function getReflectionClass(object $instance)
    {
        return new ReflectionClass(get_class($instance));
    }
}