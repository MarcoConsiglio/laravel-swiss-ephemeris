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
     */
    public static function assertProperty(string $name, mixed $expected_value, string $expected_type, mixed $actual_value): void
    {
        match ($expected_type) {
            'string' => Assert::assertIsString($actual_value, self::typeFail($name)),
            'float' => Assert::assertIsFloat($actual_value, self::typeFail($name)),
            'array' => Assert::assertIsArray($actual_value, self::typeFail($name)),
            'integer' => Assert::assertIsInt($actual_value, self::typeFail($name)),
            default => Assert::assertInstanceOf($expected_type, $actual_value, self::typeFail($name)),
        };
        Assert::assertEquals($expected_value, $actual_value, self::propertyFail($name));
    }

    /**
     * Assert that $actual_date is equal to $expected_date.
     *
     * @param string $message The failure message in case the assertion is false.
     */
    public static function assertDate(
        CarbonInterface $actual_date, 
        CarbonInterface $expected_date, 
        string $message = ""
    ): void {
        Assert::assertThat($actual_date, self::isDateEqual($expected_date), $message);
    }

    /**
     * Construct a IsDateEqual PHPUnit Constraint.
     */
    protected static function isDateEqual(CarbonInterface $expected_date): Constraint {
        return new IsDateEqual($expected_date);
    }
}