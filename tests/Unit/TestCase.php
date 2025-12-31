<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use InvalidArgumentException;
use Orchestra\Testbench\TestCase as TestbenchTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Traits\WithCustomAssertions;
use MarcoConsiglio\Ephemeris\Tests\Traits\WithRandomData;
use MarcoConsiglio\Goniometry\Angle;

/**
 * Unit custom TestCase.
 */
abstract class TestCase extends TestbenchTestCase
{
    use WithCustomAssertions, WithRandomData;

    /**
     * The sampling rate of the ephemeris expressed 
     * in minutes per each step of the ephemeris response.
     *
     * @var integer
     */
    protected int $sampling_rate;

    /**
     * The angular neighborhood within which to accept a record.
     * 
     * Represents the maximum error accepted to select some
     * angular ephemeris value and discard others.  
     *
     * @var float
     */
    protected float $delta;


    /**
     * Setup the test environment.
     */
    #[\Override]
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
     */
    protected function getMockedSwissEphemerisDateTime(): SwissEphemerisDateTime&MockObject
    {
        return $this->createMock(SwissEphemerisDateTime::class);
    }

    /**
     * Create a specific Angle with $decimal_degrees.
     */
    protected function getSpecificAngle(float $decimal_degrees): Angle
    {
        if ($decimal_degrees > Angle::MAX_DEGREES) $decimal_degrees = Angle::MAX_DEGREES;
        if ($decimal_degrees < -Angle::MAX_DEGREES) $decimal_degrees = -Angle::MAX_DEGREES;
        return Angle::createFromDecimal($decimal_degrees);
    }

}