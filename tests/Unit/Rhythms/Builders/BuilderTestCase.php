<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders;

use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use PHPUnit\Framework\MockObject\MockObject;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;
use MarcoConsiglio\Goniometry\Angle;

abstract class BuilderTestCase extends TestCase
{    
    /**
     * The file with a raw ephemeris response.
     *
     * @var string
     */
    protected string $response_file;

    /**
     * The sampling rate of the ephemeris.
     *
     * @var integer
     */
    protected int $sampling_rate;

    /**
     * Get the current SUT class.
     * 
     * @return string
     */
    protected abstract function getBuilderClass(): string;

    /**
     * This is a Guard Assertion that checks if the builder
     * implements a specific interface.
     *
     * @param string $builder_interface
     * @param object $builder
     * @return void
     */
    protected function checkBuilderInterface(string $builder_interface, object $builder): void
    {
        $builder_class = get_class($builder);
        $this->assertInstanceOf($builder_interface, $builder, 
            "The $builder_class builder must implement the $builder_interface interface."
        );
    }

    /**
     * It creates a random datetime in the Swiss Ephemeris format.
     *
     * @return SwissEphemerisDateTime
     */
    protected function getRandomSwissEphemerisDateTime(): SwissEphemerisDateTime
    {
        return new SwissEphemerisDateTime($this->faker->dateTimeAD());
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
}