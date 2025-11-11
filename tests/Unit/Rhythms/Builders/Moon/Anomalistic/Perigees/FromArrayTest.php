<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\Moon\Anomalistic\Perigees;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use MarcoConsiglio\Ephemeris\Records\Moon\PerigeeRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\AnomalisticRhythm\Perigees\FromArray;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\Perigees;
use MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\BuilderTestCase;

#[CoversClass(FromArray::class)]
#[UsesClass(Perigees::class)]
#[UsesClass(PerigeeRecord::class)]
#[TestDox("The Moon\Perigees\FromArray builder")]
class FromArrayTest extends BuilderTestCase
{
    #[TestDox("can build Perigees collection from an array of raw ephemeris.")]
    public function test_build_apogees_from_array()
    {
        // Arrange
        $builder_class = $this->getBuilderClass();
        $output = [
            0 => [
                "astral_object" => "Moon",
                "timestamp" => "01.01.2000 00:00:00 TT", 
                "longitude" => "100.0"
            ],
            1 => [
                "astral_object" => "intp. Perigee",
                "timestamp" => "01.01.2000 00:00:00 TT", 
                "longitude" => "100.1"
            ]
        ];

        // Act
        $builder = new $builder_class($output);
        $collection = new Perigees($builder);

        // Assert
        $this->assertContainsOnlyInstancesOf(PerigeeRecord::class, $collection);
        $this->assertCount(1, $collection);
    }

    /**
     * Get the current SUT class.
     * 
     * @return string
     */
    protected function getBuilderClass(): string
    {
        return FromArray::class;
    }

    /**
     * It returns raw data to test the builder.
     *
     * @return array
     */
    public  function getRawData(): array
    {
        // There are x perigee here.
        return [
            0 => [
                "astral_object" => "Moon",
                "timestamp" => "07.01.2025 23:00:00 TT", 
                "longitude" => "30°27'59.8980\""
            ],
            1 => [
                "astral_object" => "intp. Perigee",
                "timestamp" => "07.01.2025 23:00:00 TT", 
                "longitude" => "31° 9' 7.9914\""
            ],
            2 => [
                "astral_object" => "Moon",
                "timestamp" => "08.01.2025 0:00:00 TT", 
                "longitude" => "31° 3'18.2432\""               
            ],
            3 => [
                "astral_object" => "intp. Perigee",
                "timestamp" => "08.01.2025 0:00:00 TT", 
                "longitude" => "31° 4'37.8369\""
            ],
            4 => [
                "astral_object" => "Moon",
                "timestamp" => "08.01.2025 1:00:00 TT", 
                "longitude" => "31°38'36.8118\""               
            ],
            5 => [
                "astral_object" => "intp. Perigee",
                "timestamp" => "08.01.2025 1:00:00 TT", 
                "longitude" => "31° 0' 6.6018\""
            ],
            6 => [
                "astral_object" => "Moon",
                "timestamp" => "02.02.2025 1:00:00 TT", 
                "longitude" => "359°53'23.0422\""               
            ],
            7 => [
                "astral_object" => "intp. Perigee",
                "timestamp" => "02.02.2025 1:00:00 TT", 
                "longitude" => "0°58'37.0294\""
            ],
            8 => [
                "astral_object" => "Moon",
                "timestamp" => "", 
                "longitude" => "\""               
            ],
            9 => [
                "astral_object" => "intp. Perigee",
                "timestamp" => "", 
                "longitude" => "\""
            ],
            10 => [
                "astral_object" => "Moon",
                "timestamp" => "", 
                "longitude" => "215° \""
            ],
            11 => [
                "astral_object" => "intp. Perigee",
                "timestamp" => "", 
                "longitude" => "\""
            ],
            12 => [
                "astral_object" => "Moon",
                "timestamp" => "", 
                "longitude" => "\""
            ],
            13 => [
                "astral_object" => "intp. Perigee",
                "timestamp" => "", 
                "longitude" => "\""
            ],
            14 => [
                "astral_object" => "Moon",
                "timestamp" => "", 
                "longitude" => "\""
            ],
            15 => [
                "astral_object" => "intp. Perigee",
                "timestamp" => "", 
                "longitude" => "\""
            ],
            16 => [
                "astral_object" => "Moon",
                "timestamp" => "", 
                "longitude" => "\""
            ],
            17 => [
                "astral_object" => "intp. Perigee",
                "timestamp" => "", 
                "longitude" => "\""
            ],
        ];
    }
}