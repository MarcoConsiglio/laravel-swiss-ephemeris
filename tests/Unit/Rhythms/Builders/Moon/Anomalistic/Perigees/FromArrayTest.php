<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\Moon\Anomalistic\Perigees;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use MarcoConsiglio\Ephemeris\Records\Moon\PerigeeRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\AnomalisticRhythm\Perigees\FromArray;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\Perigees;
use MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\FromArrayTestCase;

#[CoversClass(FromArray::class)]
#[UsesClass(Perigees::class)]
#[UsesClass(PerigeeRecord::class)]
#[TestDox("The Moon\Perigees\FromArray builder")]
class FromArrayTest extends FromArrayTestCase
{
    #[TestDox("can build Perigees collection from an array of raw ephemeris.")]
    public function test_build_apogees_from_array()
    {
        // Arrange
        $builder_class = $this->getBuilderClass();
        $output = $this->getRawData();

        // Act
        $builder = new $builder_class($output);
        $collection = new Perigees($builder);

        // Assert
        $this->assertContainsOnlyInstancesOf(PerigeeRecord::class, $collection);
        $this->assertCount(3, $collection);
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
        // There are 3 perigee here.
        return [
            0 => [
                "astral_object" => "Moon",
                "timestamp" => "07.01.2025 23:00:00 TT", 
                "longitude" => "30.4666383"
            ],
            1 => [
                "astral_object" => "intp. Perigee",
                "timestamp" => "07.01.2025 23:00:00 TT", 
                "longitude" => "31.1522198"
            ],
            // This is to be selected
            2 => [
                "astral_object" => "Moon",
                "timestamp" => "08.01.2025 0:00:00 TT", 
                "longitude" => "31.0550675"               
            ],
            3 => [
                "astral_object" => "intp. Perigee",
                "timestamp" => "08.01.2025 0:00:00 TT", 
                "longitude" => "31.0771769"
            ],
            // End selection
            4 => [
                "astral_object" => "Moon",
                "timestamp" => "08.01.2025 1:00:00 TT", 
                "longitude" => "31.6435588"               
            ],
            5 => [
                "astral_object" => "intp. Perigee",
                "timestamp" => "08.01.2025 1:00:00 TT", 
                "longitude" => "31.0018338"
            ],
            6 => [
                "astral_object" => "Moon",
                "timestamp" => "02.02.2025 1:00:00 TT", 
                "longitude" => "359.8897340"               
            ],
            7 => [
                "astral_object" => "intp. Perigee",
                "timestamp" => "02.02.2025 1:00:00 TT", 
                "longitude" => "0.9769526"
            ],
            8 => [
                "astral_object" => "Moon",
                "timestamp" => "02.02.2025 2:00:00 TT", 
                "longitude" => "0.4874730"               
            ],
            9 => [
                "astral_object" => "intp. Perigee",
                "timestamp" => "02.02.2025 2:00:00 TT", 
                "longitude" => "0.9722443"
            ],
            // This is to be selected
            10 => [
                "astral_object" => "Moon",
                "timestamp" => "02.02.2025 3:00:00 TT", 
                "longitude" => "1.0851743"
            ],
            11 => [
                "astral_object" => "intp. Perigee",
                "timestamp" => "02.02.2025 3:00:00 TT", 
                "longitude" => "0.9676088"
            ],
            // End selection
            12 => [
                "astral_object" => "Moon",
                "timestamp" => "02.02.2025 4:00:00 TT", 
                "longitude" => "1.6828336"
            ],
            13 => [
                "astral_object" => "intp. Perigee",
                "timestamp" => "02.02.2025 4:00:00 TT", 
                "longitude" => "0.9630462"
            ],
            14 => [
                "astral_object" => "Moon",
                "timestamp" => "01.03.2025 20:00:00 TT", 
                "longitude" => "6.2416814"
            ],
            15 => [
                "astral_object" => "intp. Perigee",
                "timestamp" => "01.03.2025 20:00:00 TT", 
                "longitude" => "7.0755343"
            ],
            // This is to be selected
            16 => [
                "astral_object" => "Moon",
                "timestamp" => "01.03.2025 21:00:00 TT", 
                "longitude" => "6.8588149"
            ],
            17 => [
                "astral_object" => "intp. Perigee",
                "timestamp" => "01.03.2025 21:00:00 TT", 
                "longitude" => "7.0924814"
            ],
            // End selection
            18 => [
                "astral_object" => "Moon",
                "timestamp" => "01.03.2025 22:00:00 TT", 
                "longitude" => "7.4759349"
            ],
            19 => [
                "astral_object" => "intp. Perigee",
                "timestamp" => "01.03.2025 22:00:00 TT", 
                "longitude" => "7.1094414"
            ],
        ];
    }
}