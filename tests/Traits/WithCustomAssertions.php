<?php
namespace MarcoConsiglio\Ephemeris\Tests\Traits;

use Carbon\CarbonInterface;
use MarcoConsiglio\Ephemeris\Tests\Constraints\IsDateEqual;
use PHPUnit\Framework\Assert;

trait WithCustomAssertions
{
    use WithFailureMessage;

    /**
     * Asserts type and value of a variable.
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
        Assert::assertEquals($expected_value, $actual_value, self::getterFail($name));
    }

    public static function assertDate(
        CarbonInterface $date, 
        int $year = 1, 
        int $month = 1, 
        int $day = 1, 
        int $hour = 0, 
        int $minute = 0, 
        int $second = 0, 
        string $timezone = "",
        string $message = ""
    ) {
        $constraint = new IsDateEqual($year, $month, $day, $hour, $minute, $second, $timezone);

        Assert::assertThat($date, $constraint, $message);
    }
}