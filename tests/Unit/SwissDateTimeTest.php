<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit;

use Carbon\Carbon;
use MarcoConsiglio\Ephemeris\SwissDateTime;
use MarcoConsiglio\Ephemeris\Tests\Traits\WithCustomAssertions;

/**
 * @testdox The SwissDateTime
 */
class SwissDateTimeTest extends TestCase
{
    use WithCustomAssertions;

    /**
     * The Gregorian calendar date time format.
     */
    protected const GREGORIAN_CALENDAR = "d.m.Y G:i:s";

    /**
     * The Julian calendar date time format.
     */
    protected const JULIAN_CALENDAR = "d.m.Y\j G:i:s";

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
    protected const GREGORIAN_UT = self::GREGORIAN_CALENDAR." ".self::UT;

    /**
     * The format of a Gregorian calendar date expressed in the
     * Terrestrial Time (TT).
     */
    protected const GREGORIAN_TT = self::GREGORIAN_CALENDAR." ".self::TT;

    /**
     * The format of a Julian calendar date expressed in the 
     * Terrestrial Time (TT).
     */
    protected const JULIAN_TT = self::JULIAN_CALENDAR." ".self::TT;

    /**
     * The format of a Julian calendar date expressed in the 
     * Universal Time (UT) aka Greenwich Mean Time (GMT).
     */
    protected const JULIAN_UT = self::JULIAN_CALENDAR." ".self::UT;

    /**
     * @testdox is a Carbon instance.
     */
    public function test_is_a_carbon_instance()
    {
        // Arrange
        
        // Act
        $date = new SwissDateTime();

        // Assert
        $this->assertInstanceOf(Carbon::class, $date, 
            "The ".SwissDateTime::class." must extends ".Carbon::class." class.");
    }

    /**
     * @testdox can format a date to Universal Time format of the Gregorian calendar.
     */
    public function test_ut_greg_format()
    {
        // Arrange
        $expected_format = self::GREGORIAN_UT;
        $expected_date_string = "01.01.2000 0:00:00 UT";
        $date =  $this->getMockedSwissDateTime(2000);

        // Act
        $formatted_date = $date->toGregorianUT();

        // Assert
        $this->assertEquals($expected_format, SwissDateTime::GREGORIAN_UT, 
            "The Gregorian Universal Time format is $expected_format.");
        $this->assertEquals($expected_date_string, $formatted_date, 
            "The date is bad formatted. It must equals $expected_date_string.");
    }

    /**
     * @testdox can format a date to Universal Time format of the Gregorian calendar.
     */
    public function test_tt_greg_format()
    {
        // Arrange
        $expected_format = self::GREGORIAN_TT;
        $expected_date_string = "01.01.2000 0:00:00 TT";
        $date = $this->getMockedSwissDateTime(2000);
        
        // Act
        $formatted_date = $date->toGregorianTT();

        // Assert
        $this->assertEquals($expected_format, SwissDateTime::GREGORIAN_TT, 
            "The Gregorian Universal Time format is $expected_format.");
        $this->assertEquals($expected_date_string, $formatted_date,
            "The date is bad formatted. It must equals $expected_date_string");
    }

    /**
     * @testdox can format a date to Terrestrial Time format of the Julian calendar.
     */
    public function test_tt_jul_format()
    {
        // Arrange
        $expected_format = self::JULIAN_TT;
        $expected_date_string = "01.01.2000j 0:00:00 TT";
        $date = $this->getMockedSwissDateTime(2000);

        // Act
        $formatted_date = $date->toJulianTT();

        // Assert
        $this->assertEquals($expected_format, SwissDateTime::JULIAN_TT,
            "The Julian Terrestrial Time format is $expected_format.");
        $this->assertEquals($expected_date_string, $formatted_date, 
            "The date is bad formatted. It must equals $expected_date_string");
    }

    /**
     * @testdox can format a date to Terrestrial Time format of the Julian calendar.
     */
    public function test_ut_jul_format()
    {
        // Arrange
        $expected_format = self::JULIAN_UT;
        $expected_date_string = "01.01.2000j 0:00:00 UT";
        $date = $this->getMockedSwissDateTime(2000);

        // Act
        $formatted_date = $date->toJulianUT();

        // Assert
        $this->assertEquals($expected_format, SwissDateTime::JULIAN_UT,
            "The Julian Universal Time format is $expected_format.");
        $this->assertEquals($expected_date_string, $formatted_date,
            "The date is bad formatted. It must equals $expected_date_string.");
    }

    /**
     * @testdox can be created from a Gregorian date and Universal Time.
     */
    public function test_can_create_from_gregorian_ut()
    {
        // Arrange
        $date = "01.01.2000 0:00:00 UT";

        // Act
        $ephemeris_date = SwissDateTime::createFromGregorianUT($date);

        // Assert
        $this->assertInstanceOf(SwissDateTime::class, $ephemeris_date);
        $this->assertDate($ephemeris_date, 2000);
    }

    /**
     * @testdox can be created from a Gregorian date and Terrestrial Time.
     */
    public function test_can_create_from_gregorian_tt()
    {
        // Arrange
        $date = "01.01.2000 0:00:00 TT";

        // Act
        $ephemeris_date = SwissDateTime::createFromGregorianTT($date);

        // Assert
        $this->assertInstanceOf(SwissDateTime::class, $ephemeris_date);
        $this->assertDate($ephemeris_date, 2000);
    }

    /**
     * @testdox can be created from a Julian date and Universal Time.
     */
    public function test_can_create_from_julian_ut()
    {
        // Arrange
        $date = "01.01.2000j 0:00:00 UT";

        // Act
        $ephemeris_date = SwissDateTime::createFromJulianUT($date);

        // Assert
        $this->assertInstanceOf(SwissDateTime::class, $ephemeris_date);
        $this->assertDate($ephemeris_date, 2000);
    }

    /**
     * @testdox can be created from a Julian date and Terrestrial Time.
     */
    public function test_can_create_from_julian_tt()
    {
        // Arrange
        $date = "01.01.2000j 0:00:00 TT";

        // Act
        $ephemeris_date = SwissDateTime::createFromJulianTT($date);

        // Assert
        $this->assertInstanceOf(SwissDateTime::class, $ephemeris_date);
        $this->assertDate($ephemeris_date, 2000);
    }



    /**
     * Creates a mocked SwissDateTime.
     *
     * @param integer $year
     * @param integer $month
     * @param integer $day
     * @param integer $hour
     * @param integer $minute
     * @param integer $second
     * @param [type]  $tz
     * @return \MarcoConsiglio\Ephemeris\SwissDateTime
     */
    protected function getMockedSwissDateTime($year = 0, $month = 1, $day = 1, $hour = 0, $minute = 0, $second = 0, $tz = null): SwissDateTime
    {
        $date = SwissDateTime::create($year, $month, $day, $hour, $minute, $second, $tz);
        SwissDateTime::setTestNow($date);
        return $date;
    }
}