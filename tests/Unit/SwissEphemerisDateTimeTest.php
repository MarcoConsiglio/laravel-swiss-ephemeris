<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit;

use Carbon\Carbon;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Traits\WithCustomAssertions;
use MarcoConsiglio\Ephemeris\Tests\Traits\WithMockedSwissEphemerisDateTime;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;

#[TestDox("The SwissEphemerisDateTime")]
#[CoversClass(SwissEphemerisDateTime::class)]
class SwissEphemerisDateTimeTest extends TestCase
{
    use WithCustomAssertions, WithMockedSwissEphemerisDateTime;

    /**
     * The Gregorian calendar date time format.
     */
    public const GREGORIAN_DATE = "d.m.Y";

    /**
     * The Julian calendar date time format.
     */
    public const JULIAN_DATE = "d.m.Y\j";
    
    /**
     * The time format.
     */
    public const TIME_FORMAT = "G:i:s";

    /**
     * The wording that says time is in Universal Time format.
     */
    protected const UT = "\U\T";

    /**
     * The wording that says time is in Terrestrial Time format.
     */
    protected const TT = "\T\T";

    /**
     * The format of a Gregorian calendar date expressed in 
     * the Universal Time (UT) aka Greenwich Mean Time (GMT).
     */
    public const GREGORIAN_UT = self::GREGORIAN_DATE." ".self::TIME_FORMAT." ".self::UT;

    /**
     * The format of a Gregorian calendar date expressed in the
     * Terrestrial Time (TT).
     */
    public const GREGORIAN_TT = self::GREGORIAN_DATE." ".self::TIME_FORMAT." ".self::TT;

    /**
     * The format of a Julian calendar date expressed in the 
     * Terrestrial Time (TT).
     */
    public const JULIAN_TT = self::JULIAN_DATE." ".self::TIME_FORMAT." ".self::TT;

    /**
     * The format of a Julian calendar date expressed in the 
     * Universal Time (UT) aka Greenwich Mean Time (GMT).
     */
    public const JULIAN_UT = self::JULIAN_DATE." ".self::TIME_FORMAT." ".self::UT;

    #[TestDox("is a Carbon instance.")]
    public function test_is_a_carbon_instance()
    {
        // Arrange
        
        // Act
        $date = new SwissEphemerisDateTime();

        // Assert
        $this->assertInstanceOf(Carbon::class, $date, 
            "The ".SwissEphemerisDateTime::class." must extends ".Carbon::class." class.");
    }

    #[TestDox("can format a datetime to Universal Time format of the Gregorian calendar.")]
    public function test_ut_greg_format()
    {
        // Arrange
        $expected_format = self::GREGORIAN_UT;
        $expected_date_string = "01.01.2000 0:00:00 UT";
        $date =  $this->getMockedSwissEphemerisDateTime(2000);

        // Act
        $formatted_date = $date->toGregorianUT();

        // Assert
        $this->assertEquals($expected_format, SwissEphemerisDateTime::GREGORIAN_UT, 
            "The Gregorian Universal Time format is $expected_format.");
        $this->assertEquals($expected_date_string, $formatted_date, 
            "The date is bad formatted. It must equals $expected_date_string.");
    }

    #[TestDox("can format a datetime to Terrestrial Time format of the Gregorian calendar.")]
    public function test_tt_greg_format()
    {
        // Arrange
        $expected_format = self::GREGORIAN_TT;
        $expected_date_string = "01.01.2000 0:00:00 TT";
        $date = $this->getMockedSwissEphemerisDateTime(2000);
        
        // Act
        $formatted_date = $date->toGregorianTT();

        // Assert
        $this->assertEquals($expected_format, SwissEphemerisDateTime::GREGORIAN_TT, 
            "The Gregorian Universal Time format is $expected_format.");
        $this->assertEquals($expected_date_string, $formatted_date,
            "The date is bad formatted. It must equals $expected_date_string");
    }

    #[TestDox("can format a datetime to Terrestrial Time format of the Julian calendar.")]
    public function test_tt_jul_format()
    {
        // Arrange
        $expected_format = self::JULIAN_TT;
        $expected_date_string = "01.01.2000j 0:00:00 TT";
        $date = $this->getMockedSwissEphemerisDateTime(2000);

        // Act
        $formatted_date = $date->toJulianTT();

        // Assert
        $this->assertEquals($expected_format, SwissEphemerisDateTime::JULIAN_TT,
            "The Julian Terrestrial Time format is $expected_format.");
        $this->assertEquals($expected_date_string, $formatted_date, 
            "The date is bad formatted. It must equals $expected_date_string");
    }

    #[TestDox("can format a datetime to Terrestrial Time format of the Julian calendar.")]
    public function test_ut_jul_format()
    {
        // Arrange
        $expected_format = self::JULIAN_UT;
        $expected_date_string = "01.01.2000j 0:00:00 UT";
        $date = $this->getMockedSwissEphemerisDateTime(2000);

        // Act
        $formatted_date = $date->toJulianUT();

        // Assert
        $this->assertEquals($expected_format, SwissEphemerisDateTime::JULIAN_UT,
            "The Julian Universal Time format is $expected_format.");
        $this->assertEquals($expected_date_string, $formatted_date,
            "The date is bad formatted. It must equals $expected_date_string.");
    }

    #[TestDox("can format a date to the Gregorian calendar.")]
    public function test_gregorian_date()
    {
        // Arrange
        $expected_format = self::GREGORIAN_DATE;
        $expected_date_string = "01.01.2000";
        $date = $this->getMockedSwissEphemerisDateTime(2000);

        // Act
        $formatted_date = $date->toGregorianDate();

        // Assert
        $this->assertEquals($expected_format, SwissEphemerisDateTime::GREGORIAN_DATE, 
            "The Gregorian format is $expected_format.");
        $this->assertEquals($expected_date_string, $formatted_date, 
            "The date is bad formatted. It must equals $expected_date_string.");
    }

    #[TestDox("can format a date to the Julian calendar.")]
    public function test_julian_date()
    {
        // Arrange
        $expected_format = self::JULIAN_DATE;
        $expected_date_string = "01.01.2000j";
        $date = $this->getMockedSwissEphemerisDateTime(2000);

        // Act
        $formatted_date = $date->toJulianDate();

        // Assert
        $this->assertEquals($expected_format, SwissEphemerisDateTime::JULIAN_DATE);
        $this->assertEquals($expected_date_string, $formatted_date, 
            "The date is bad formatted. It must equals $expected_date_string");
    }

    #[TestDox("can be created from a Gregorian date and Universal Time.")]
    public function test_can_create_from_gregorian_ut()
    {
        // Arrange
        $date = "01.01.2000 0:00:00 UT";

        // Act
        $ephemeris_date = SwissEphemerisDateTime::createFromGregorianUT($date);
        $is_universal_time = $ephemeris_date->isUT();
        $is_gregorian_date = $ephemeris_date->isGregorianDate();

        // Assert
        $this->assertInstanceOf(SwissEphemerisDateTime::class, $ephemeris_date);
        $this->assertDate($ephemeris_date, Carbon::create(2000));
        $this->assertTrue($is_universal_time, 
            "A SwissEphemerisDateTime createdFromGregorianUT() must have Universal Time.");
        $this->assertTrue($is_gregorian_date, 
            "A SwissEphemerisDateTime createdFromGregorianUT() must have a Gregorian calendar date.");
    }

    #[TestDox("can be created from a Gregorian date and Terrestrial Time.")]
    public function test_can_create_from_gregorian_tt()
    {
        // Arrange
        $date = "01.01.2000 0:00:00 TT";

        // Act
        $ephemeris_date = SwissEphemerisDateTime::createFromGregorianTT($date);
        $is_terrestrial_time = $ephemeris_date->isTT();
        $is_gregorian_date = $ephemeris_date->isGregorianDate();

        // Assert
        $this->assertInstanceOf(SwissEphemerisDateTime::class, $ephemeris_date);
        $this->assertDate($ephemeris_date, Carbon::create(2000));
        $this->assertTrue($is_terrestrial_time, 
            "A SwissEphemerisDateTime createdFromGregorianTT() must have Terrestrial Time.");
        $this->assertTrue($is_gregorian_date, 
            "A SwissEphemerisDateTime createdFromGregorianTT() must have a Gregorian calendar date.");
    }

    #[TestDox("can be created from a Julian date and Universal Time.")]
    public function test_can_create_from_julian_ut()
    {
        // Arrange
        $date = "01.01.2000j 0:00:00 UT";

        // Act
        $ephemeris_date = SwissEphemerisDateTime::createFromJulianUT($date);
        $is_universal_time = $ephemeris_date->isUT();
        $is_julian_date = $ephemeris_date->isJulianDate();

        // Assert
        $this->assertInstanceOf(SwissEphemerisDateTime::class, $ephemeris_date);
        $this->assertDate($ephemeris_date, Carbon::create(2000));
        $this->assertTrue($is_universal_time, 
            "A SwissEphemerisDateTime createFromJulianUT() must have Universal Time.");
        $this->assertTrue($is_julian_date, 
            "A SwissEphemerisDateTime createFromJulianUT() must have a Julian calendar date.");
    }

    #[TestDox("can be created from a Julian date and Terrestrial Time.")]
    public function test_can_create_from_julian_tt()
    {
        // Arrange
        $date = "01.01.2000j 0:00:00 TT";

        // Act
        $ephemeris_date = SwissEphemerisDateTime::createFromJulianTT($date);
        $is_terrestrial_time = $ephemeris_date->isTT();
        $is_julian_date = $ephemeris_date->isJulianDate();

        // Assert
        $this->assertInstanceOf(SwissEphemerisDateTime::class, $ephemeris_date);
        $this->assertDate($ephemeris_date, Carbon::create(2000));
        $this->assertTrue($is_terrestrial_time, 
            "A SwissEphemerisDateTime createFromJulianTT() must have Terrestrial Time.");
        $this->assertTrue($is_julian_date, 
            "A SwissEphemerisDateTime createFromJulianUT() must have a Julian calendar date.");
    }

    #[TestDox("can return all available datetime formats used by the Swiss Ephemeris.")]
    public function test_can_return_all_available_formats()
    {
        // Arrange
        $expected_formats = [
            self::GREGORIAN_TT,
            self::GREGORIAN_UT,
            self::JULIAN_TT,
            self::JULIAN_UT
        ];

        // Act
        $available_formats = SwissEphemerisDateTime::availableFormats();

        // Assert
        $this->assertIsArray($available_formats, SwissEphemerisDateTime::class." must return an array of available formats.");
        $this->assertEquals($expected_count = count($expected_formats), $actual_count = count($available_formats), 
            SwissEphemerisDateTime::class." class must return $expected_count available formats, but found $actual_count formats.");
        $this->assertContains($expected_formats[0], $available_formats, 
            SwissEphemerisDateTime::class." class must have {$expected_formats[0]} format.");
        $this->assertContains($expected_formats[1], $available_formats, 
            SwissEphemerisDateTime::class." class must have {$expected_formats[1]} format.");
        $this->assertContains($expected_formats[2], $available_formats, 
            SwissEphemerisDateTime::class." class must have {$expected_formats[2]} format.");
        $this->assertContains($expected_formats[3], $available_formats, 
            SwissEphemerisDateTime::class." class must have {$expected_formats[3]} format.");
    }
}