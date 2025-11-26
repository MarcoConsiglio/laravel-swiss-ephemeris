<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Records\Moon;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use MarcoConsiglio\Ephemeris\Records\Moon\ApogeeRecord;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;
use MarcoConsiglio\Goniometry\Angle;
use PHPUnit\Framework\MockObject\MockObject;

#[CoversClass(ApogeeRecord::class)]
#[UsesClass(Angle::class)]
#[UsesClass(SwissEphemerisDateTime::class)]
#[TestDox("The Moon\ApogeeRecord")]
class ApogeeRecordTest extends TestCase
{
    #[TestDox("has a \"timestamp\" property which is a SwissEphemerisDateTime.")]
    public function test_timestamp_property()
    {
        // Arrange
        $timestamp = SwissEphemerisDateTime::create();
        /** @var Angle&MockObject $moon_longitude */
        $moon_longitude = $this->getMocked(Angle::class);
        /** @var Angle&MockObject $apogee_longitude */
        $apogee_longitude= $this->getMocked(Angle::class);
        $record = new ApogeeRecord($timestamp, $moon_longitude, $apogee_longitude, 12.0);

        // Act & Assert
        $this->assertProperty("timestamp", $timestamp, SwissEphemerisDateTime::class, $record->timestamp);
    }

    #[TestDox("has \"moon_longitude\" and \"apogee_longituded\" property which are Angle.")]
    public function test_moon_and_apogee_longitude_properties()
    {
        // Arrange
        /** @var SwissEphemerisDateTime&MockObject $timestamp */
        $timestamp = $this->getMocked(SwissEphemerisDateTime::class);
        $moon_longitude = Angle::createFromDecimal(179.9);
        $apogee_longitude= Angle::createFromDecimal(180.0);
        $record = new ApogeeRecord($timestamp, $moon_longitude, $apogee_longitude, 12.0);

        // Act & Assert
        $this->assertProperty("moon_longitude", $moon_longitude, Angle::class, $record->moon_longitude);
        $this->assertProperty("apogee_longituded", $apogee_longitude, Angle::class, $record->apogee_longitude);
    }

    #[TestDox("has \"daily_speed\" property which is a float.")]
    public function test_moon_daily_speed_property()
    {
        // Arrange
        $timestamp = SwissEphemerisDateTime::create();
        /** @var Angle&MockObject $moon_longitude */
        $moon_longitude = $this->getMocked(Angle::class);
        /** @var Angle&MockObject $apogee_longitude */
        $apogee_longitude= $this->getMocked(Angle::class);
        $moon_daily_speed = $this->faker->randomFloat(7, 10, 14);
        $record = new ApogeeRecord($timestamp, $moon_longitude, $apogee_longitude, $moon_daily_speed);

        // Act & Assert
        $this->assertProperty("daily_speed", $moon_daily_speed, "float", $record->daily_speed);
    }

    #[TestDox("can establish equality with another record of the same type.")]
    public function test_is_equal()
    {
        // Arrange
        $angle_1 = Angle::createFromDecimal(90.0);
        $angle_2 = Angle::createFromDecimal(180.0);
        $date_1 = SwissEphemerisDateTime::create(2000);
        $date_2 = clone $date_1;
        $date_2->hour = 2;
        $speed_1 = 12.0;
        $speed_2 = 13.0;

        $property_A_is_equal = [false, true];
        $property_B_is_equal = [false, true];
        $property_C_is_equal = [false, true];
        $property_D_is_equal = [false, true];
        $A = [ 
            0 => [$date_1, $date_2],
            1 => [$date_1, $date_1]
        ];
        $B = [
            0 => [$angle_1, $angle_2],
            1 => [$angle_1, $angle_1]
        ];
        $C = [
            0 => [$angle_1, $angle_2],
            1 => [$angle_1, $angle_1]
        ];
        $D = [
            0 => [$speed_1, $speed_2],
            1 => [$speed_1, $speed_1]
        ];
        $first_record = 0;
        $second_record = 1;
        $records = [];
        foreach ($property_A_is_equal as $A_index => $A_is_equal) {
            foreach ($property_B_is_equal as $B_index => $B_is_equal) {
                foreach ($property_C_is_equal as $C_index => $C_is_equal) {
                    foreach ($property_D_is_equal as $D_index => $D_is_equal) { 
                        $records[] = [
                            new ApogeeRecord(
                                $A[$A_index][$first_record], 
                                $B[$B_index][$first_record], 
                                $C[$C_index][$first_record],
                                $D[$D_index][$first_record]
                            ),
                            new ApogeeRecord(
                                $A[$A_index][$second_record], 
                                $B[$B_index][$second_record], 
                                $C[$C_index][$second_record],
                                $D[$D_index][$second_record]
                            )
                        ];     
                    }
                }
            }
        }
        
        // Guard Assertion that count all possible cases.
        $this->assertCount(16, $records);
        
        // Act & Assert
        $i = 0;
        $failure_message = function (int $i, array $record_couple) {
            return <<<HEREDOC
Checking the {$i}° case.
"timestamp":\t\t{$record_couple[0]->timestamp->toGregorianTT()}\t\t{$record_couple[1]->timestamp->toGregorianTT()}
"moon_longitude":\t\t{$record_couple[0]->moon_longitude->__toString()}\t\t{$record_couple[1]->moon_longitude->__toString()}
"apogee_longitude":\t\t{$record_couple[0]->apogee_longitude->__toString()}\t\t{$record_couple[1]->apogee_longitude->__toString()}
"daily_speed":\t\t{$record_couple[0]->daily_speed}\t\t{$record_couple[1]->daily_speed}
HEREDOC;
        };
        
        for ($i=0; $i < 15; $i++) { 
            $this->assertObjectNotEquals(
                $records[$i][$first_record], 
                $records[$i][$second_record],
                "equals",
                $failure_message($i, $records[$i])
            );
        }
        $this->assertObjectEquals(
            $records[$i][$first_record],
            $records[$i][$second_record],
            "equals",
            $failure_message($i, $records[$i])
        );
    }
}