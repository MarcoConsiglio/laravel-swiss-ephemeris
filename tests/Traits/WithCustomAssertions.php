<?php
namespace MarcoConsiglio\Ephemeris\Tests\Traits;

use Carbon\CarbonInterface;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Constraint\Constraint;
use MarcoConsiglio\Ephemeris\Tests\Constraints\IsDateEqual;

/**
 * This trait provides Custom Assertions for tests.
 */
trait WithCustomAssertions
{
    use WithFailureMessage;

    /**
     * Asserts type and value of an object property.
     *
     * @param string $name
     * @param mixed  $expected_value
     * @param string $expected_type
     * @param mixed $actual_value
     * @return void
     */
    public static function assertProperty(string $name, mixed $expected_value, string $expected_type, mixed $actual_value)
    {
        switch ($expected_type) {
            case 'string':
                Assert::assertIsString($actual_value, self::typeFail($name));
                break;
            case 'float':
                Assert::assertIsFloat($actual_value, self::typeFail($name));
                break;
            case 'array':
                Assert::assertIsArray($actual_value, self::typeFail($name));
                break;
            case 'integer':
                Assert::assertIsInt($actual_value, self::typeFail($name));
                break;
            default:
                Assert::assertInstanceOf($expected_type, $actual_value, self::typeFail($name));
                break;
        }
        Assert::assertEquals($expected_value, $actual_value, self::propertyFail($name));
    }

    /**
     * Assert that $actual_date is equal to $expected_date.
     *
     * @param \Carbon\CarbonInterface $actual_date
     * @param \Carbon\CarbonInterface $expected_date
     * @param string $message The failure message in case the assertion is false.
     * @return void
     */
    public static function assertDate(
        CarbonInterface $actual_date, 
        CarbonInterface $expected_date, 
        string $message = ""
    ) {
        Assert::assertThat($actual_date, self::isDateEqual($expected_date), $message);
    }

    /**
     * Construct a IsDateEqual PHPUnit Constraint.
     *
     * @param \Carbon\CarbonInterface $expected_date
     * @return \PHPUnit\Framework\Constraint\Constraint
     */
    protected static function isDateEqual(CarbonInterface $expected_date): Constraint {
        return new IsDateEqual($expected_date);
    }
}