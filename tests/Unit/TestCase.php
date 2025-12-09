<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use InvalidArgumentException;
use Orchestra\Testbench\TestCase as TestbenchTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Traits\WithCustomAssertions;
use MarcoConsiglio\Goniometry\Angle;

/**
 * Unit custom TestCase.
 */
abstract class TestCase extends TestbenchTestCase
{
    use WithCustomAssertions, WithFaker;

    /**
     * The sampling rate of the ephemeris expressed 
     * in minutes per each step of the ephemeris response.
     *
     * @var integer
     */
    protected int $sampling_rate;

    protected float $delta;


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

    /**
     * Return a fake representation of a SwissEphemerisDateTime instance.
     *
     * @return SwissEphemerisDateTime&MockObject
     */
    protected function getMockedSwissEphemerisDateTime(): SwissEphemerisDateTime&MockObject
    {
        return $this->createMock(SwissEphemerisDateTime::class);
    }

    /**
     * Return a random SwissEphemerisDateTime instance.
     *
     * @param integer $min_year The smallest year of a random date generation.
     * @param integer $max_year The largest year of generating a random date.
     * @return SwissEphemerisDateTime
     */
    protected function getRandomSwissEphemerisDateTime(int $min_year = 1800, int $max_year = 2399): SwissEphemerisDateTime
    {
        $min_year = "$min_year-01-01";
        $max_year = "$max_year-12-31";
        $random_date = new Carbon($this->faker->dateTimeBetween($min_year, $max_year));
        return SwissEphemerisDateTime::createFromCarbon($random_date);
    }

    /**
     * It creates a random Angle.
     *
     * @param float|null $limit It limits the angle to $limit decimal degrees.
     * @return Angle
     */
    protected function getRandomAngle(float|null $limit = null): Angle
    {
        if ($limit != null) {
            $limit = abs($limit);
            if ($limit > Angle::MAX_DEGREES) $limit = Angle::MAX_DEGREES;
        }
        return Angle::createFromDecimal(
            $this->faker->randomFloat(PHP_FLOAT_DIG, 
                $limit ? -$limit : -Angle::MAX_DEGREES,
                $limit ? $limit : Angle::MAX_DEGREES
            )
        );
    }

    /**
     * It creates a specific Angle with $decimal_degrees.
     *
     * @param float $decimal_degrees
     * @return Angle
     */
    protected function getSpecificAngle(float $decimal_degrees): Angle
    {
        if ($decimal_degrees > Angle::MAX_DEGREES) $decimal_degrees = Angle::MAX_DEGREES;
        if ($decimal_degrees < -Angle::MAX_DEGREES) $decimal_degrees = -Angle::MAX_DEGREES;
        return Angle::createFromDecimal($decimal_degrees);
    }

    /**
     * Return a random angular distance.
     * 
     * The angular distance is the angle difference between
     * two stellar objects. Minimum value: -180°. Maximum
     * value: +180°.
     *
     * @return Angle
     */
    protected function getRandomAngularDistance(): Angle
    {
        return $this->getRandomAngle(180);
    }

    /**
     * Return a random Angle between $min° and $max°.
     *
     * @param float $min The minimum degree of the random angle. 
     * @param float $max The maximum degree of the random angle.
     * @return Angle
     */
    protected function getAngleBetween(float $min = -Angle::MAX_DEGREES, float $max = Angle::MAX_DEGREES): Angle
    {
        if ($min < -Angle::MAX_DEGREES) $min = -Angle::MAX_DEGREES;
        if ($min > Angle::MAX_DEGREES) $min = Angle::MAX_DEGREES;
        if ($max > Angle::MAX_DEGREES) $max = Angle::MAX_DEGREES;
        if ($max < -Angle::MAX_DEGREES) $max = -Angle::MAX_DEGREES;
        $real_min = min($min, $max);
        $real_max = max($min, $max);
        return $this->getSpecificAngle(
            $this->faker->randomFloat(PHP_FLOAT_DIG, $real_min, $real_max)
        );
    }

    /**
     * Generate a random speed between $min and $max
     * expressed in degrees per day.
     *
     * @param float $min The slowest speed limit.
     * @param float $max The fastes speed limit.
     * @return float
     */
    protected function getRandomSpeed(float $min, float $max): float
    {
        $real_min = min($min, $max);
        $real_max = max($min, $max);
        return $this->faker->randomFloat(PHP_FLOAT_DIG, $real_min, $real_max);
    }

    /**
     * Return a random daily speed 
     *
     * @return float
     */
    protected function getRandomMoonDailySpeed(): float
    {
        return $this->getRandomSpeed(10, 14);
    }

    /**
     * Get a random sampling rate expressed in minutes
     * per each step of the ephemeris response.
     *
     * @return integer
     */
    protected function getRandomSamplingRate(): int
    {
        return $this->faker->numberBetween(1, 1440);
    }
}