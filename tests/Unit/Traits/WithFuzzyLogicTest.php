<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Traits;

use MarcoConsiglio\Goniometry\Angle;
use PHPUnit\Framework\Attributes\TestDox;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;
use MarcoConsiglio\Ephemeris\Traits\WithFuzzyLogic;
use PHPUnit\Framework\Attributes\CoversTrait;

#[TestDox("The trait WithFuzzyLogic")]
#[CoversTrait(WithFuzzyLogic::class)]
class WithFuzzyLogicTest extends TestCase
{
    use WithFuzzyLogic;

    #[TestDox("has isAbout() method that checks if a number is almost equal to another number.")]
    public function test_isAbout_method(): void
    {
        // Arrange
        $delta = 1;
        $epsilon = $delta / 2;
        $expected = 10;

        // Act & Assert
        //      Outside $delta returns false.
        $this->testIsAboutMethod($expected - $delta, $expected, $delta, false);
        $this->testIsAboutMethod($expected + $delta, $expected, $delta, false);
        //      Inside $delta including its limits returns true.
        $this->testIsAboutMethod($expected, $expected, $delta, true);
        $this->testIsAboutMethod($expected - $epsilon, $expected, $delta, true);
        $this->testIsAboutMethod($expected + $epsilon, $expected, $delta, true);
    }

    public function test_isAboutAbsolute_method(): void
    {
        // Arrange
        $delta = 1;
        $epsilon = $delta / 2;
        
        // Act & Assert
        $expected = 180;
        //      Outside of $delta returns false.
        $this->testIsAboutAbsoluteMethod($expected - $delta, $expected, $delta, false);
        $this->testIsAboutAbsoluteMethod($expected + $delta, $expected, $delta, false);
        //      Inside $delta including its limits returns true.
        $this->testIsAboutAbsoluteMethod($expected, $expected, $delta, true);
        $this->testIsAboutAbsoluteMethod($expected - $epsilon, $expected, $delta, true);
        $this->testIsAboutAbsoluteMethod($expected + $epsilon, $expected, $delta, true);
        $expected = 0;
        //      Outside of $delta returns false.
        $this->testIsAboutAbsoluteMethod(Angle::MAX_DEGREES + $expected - $delta, $expected, $delta, false);
        $this->testIsAboutAbsoluteMethod($expected + $delta, $expected, $delta, false);
        //      Inside $delta including its limits returns true.
        $this->testIsAboutAbsoluteMethod($expected, $expected, $delta, true);
        $this->testIsAboutAbsoluteMethod(Angle::MAX_DEGREES + $expected - $epsilon, $expected, $delta, true);
        $this->testIsAboutAbsoluteMethod($expected + $epsilon, $expected, $delta, true);
        $expected = 360;
        //      Outside of $delta returns false.
        $this->testIsAboutAbsoluteMethod($expected - $delta, $expected, $delta, false);
        $this->testIsAboutAbsoluteMethod(-Angle::MAX_DEGREES + $expected + $delta, $expected, $delta, false);
        //      Inside $delta including its limits returns true.
        $this->testIsAboutAbsoluteMethod($expected, $expected, $delta, true);
        $this->testIsAboutAbsoluteMethod($expected - $epsilon, $expected, $delta, true);
        $this->testIsAboutAbsoluteMethod(-Angle::MAX_DEGREES + $expected + $epsilon, $expected, $delta, true);
    }
    
    #[TestDox("has isAboutAngle() method that checks if an angle is nearly equal to another angle.")]
    public function test_isAboutAngle_method(): void
    {
        // Arrange
        $delta_value = 2;
        $expected_value = 180;
        $epsilon_value = $delta_value / 2;
        $delta = Angle::createFromValues($delta_value);
        $expected = Angle::createFromValues($expected_value);

        // Act & Assert
        //      Out of $delta is false.
        $this->testIsAboutAngleMethod(
            Angle::createFromValues($expected_value - $delta_value), 
            $expected, $delta, false
        );
        $this->testIsAboutAngleMethod(
            Angle::createFromValues($expected_value + $delta_value), 
            $expected, $delta, false
        );
        //      Inside $delta including its limits returns true.  
        $this->testIsAboutAngleMethod(
            Angle::createFromValues($expected_value),
            $expected, $delta, true
        );
        $this->testIsAboutAngleMethod(
            Angle::createFromDecimal($expected_value + $epsilon_value), 
            $expected, $delta, true
        );
        $this->testIsAboutAngleMethod(
            Angle::createFromValues($expected_value - $epsilon_value), 
            $expected, $delta, true
        );
    }
    
    #[TestDox("has getDeltaExtremes method that calculates the min and max extremes for a fuzzy condition.")]
    public function test_getDeltaExtremes_method(): void
    {
        // Arrange
        $delta = 2;
        $epsilon = $delta / 2;
        $center = 180;
        $limit = 180;

        // Act & Assert
        //      Without limits.
        $this->testGetDeltaExtremesMethod($delta, $center, 
            ($center - $epsilon), // Expected min
            ($center + $epsilon)  // Expected max
        );
        $this->testGetDeltaExtremesMethod($delta, -$center, 
            (-$center - $epsilon), // Expected min
            (-$center + $epsilon)  // Expected max
        );
        $this->testGetDeltaExtremesMethod(-$delta, $center, 
            ($center - $epsilon), // Expected min
            ($center + $epsilon)  // Expected max
        );
        $this->testGetDeltaExtremesMethod(-$delta, -$center, 
            (-$center - $epsilon), // Expected min
            (-$center + $epsilon)  // Expected max
        );
        $this->testGetDeltaExtremesMethod(361, $center, 
            0, // Expected min
            360  // Expected max
        );
        $this->testGetDeltaExtremesMethod(360, 271, 
            91, // Expected min
            360  // Expected max
        );
        $this->testGetDeltaExtremesMethod(360, -271, 
            -360, // Expected min
            -91  // Expected max
        );
        //      With limits.
        $center = -179.5;
        $this->testGetDeltaExtremesMethod($delta, $center, -$limit, $center + $epsilon, $limit);
        $center = 179.5;
        $this->testGetDeltaExtremesMethod($delta, $center, $center - $epsilon, $limit, $limit);
        $delta = 2; $center = 180; $epsilon = $delta / 2;
        $this->testGetDeltaExtremesMethod($delta, $center, $center - $epsilon, $limit, $limit);
        $center = -180;
        $this->testGetDeltaExtremesMethod($delta, $center, -$limit, -179, $limit);
    }

    /**
     * Tests isAbout() method.
     *
     * This is a Parameterized Test.
     *
     *
     * @return void
     */
    protected function testIsAboutMethod(
        float $first_nuber, 
        float $second_number, 
        float $delta,
        bool $boolean_assertion = true,
        string $error_message = ""
    ) {
        $result = $this->isAbout($first_nuber, $second_number, $delta);
        $this->assertSame($boolean_assertion, $result, $error_message);
    }

    /**
     * Tests isAboutAbsolute() method.
     *
     * This is a Parameterized Test.
     *
     * @return void
     */
    protected function testIsAboutAbsoluteMethod(
        float $first_nuber,
        float $second_number,
        float $delta,
        bool $bolean_assertion = true,
        string $error_message = ""
    ) {
        $result = $this->isAboutAbsolute($first_nuber, $second_number, $delta);
        $this->assertSame($bolean_assertion, $result, $error_message);
    }

    /**
     * This is a Parameterized Test.
     *
     * It tests isAboutAngle method present in
     * the WithFuzzyLogic trait.
     *
     * @return void
     */
    protected function testIsAboutAngleMethod(
        Angle $alfa,
        Angle $beta,
        Angle $delta,
        bool $boolean_assertion = true,
        string $error_message = ""
    ) {
        $result = $this->isAboutAngle($alfa, $beta, $delta);
        $this->assertSame($boolean_assertion, $result, $error_message);
    }

    /**
     * This is a Parameterized Test.
     * It tests getDeltaExtremes method present in
     * the WithFuzzyLogic trait.
     *
     * @param boolean $bolean_assertion
     * @return void
     */
    protected function testGetDeltaExtremesMethod(
        float $delta,
        float $number,
        float $expected_min,
        float $expected_max,
        float|null $limit = null,
        string $error_message = ""
    ) {
        [$actual_min, $actual_max] = $this->getDeltaExtremes($delta, $number, $limit);
        $this->assertEquals($expected_min, $actual_min, $error_message);
        $this->assertEquals($expected_max, $actual_max, $error_message);
    }
}