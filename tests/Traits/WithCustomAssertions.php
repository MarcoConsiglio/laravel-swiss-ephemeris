<?php
namespace MarcoConsiglio\Ephemeris\Tests\Traits;

trait WithCustomAssertions
{
    /**
     * Asserts type and value of a variable.
     *
     * @param string $name
     * @param mixed  $expected_value
     * @param string $expected_type
     * @param mixed $actual_value
     * @return void
     */
    public function assertProperty(string $name, mixed $expected_value, string $expected_type, mixed $actual_value)
    {
        switch ($expected_type) {
            case 'string':
                $this->assertIsString($actual_value, $this->typeFail($name));
                break;
            case 'float':
                $this->assertIsFloat($actual_value, $this->typeFail($name));
                break;
            case 'array':
                $this->assertIsArray($actual_value, $this->typeFail($name));
                break;
            case 'integer':
                $this->assertIsInt($actual_value, $this->typeFail($name));
                break;
            default:
                $this->assertInstanceOf($expected_type, $actual_value, $this->typeFail($name));
                break;
        }
        $this->assertEquals($expected_value, $actual_value, $this->getterFail($name));
    }
}