<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\Moon\Anomalistic\Perigees;

use InvalidArgumentException;
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
#[TestDox("The Moon Perigees\FromArray builder")]
class FromArrayTest extends FromArrayTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    #[\Override]
    public function setUp(): void
    {
        parent::setUp();
        $this->sampling_rate = 60;
    }

    #[TestDox("can build Perigees collection from an array of raw ephemeris.")]
    public function test_build_apogees_from_array(): void
    {
        // Arrange
        $builder_class = $this->getBuilderClass();

        // Act
        $builder = new $builder_class($this->data, $this->sampling_rate);
        $collection = new Perigees($builder);

        // Assert
        $this->assertContainsOnlyInstancesOf(PerigeeRecord::class, $collection);
        $this->assertCount(3, $collection);
    }

    #[TestDox("require \"astral_object\" column key in its raw data.")]
    public function test_require_astral_object_column(): void
    {
        // Arrange
        $column = "astral_object";
        unset($this->data[0][$column]);
        $builder_class = $this->getBuilderClass();
        
        // Assert
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($this->getBuilderMissingKeyErrorMessage($builder_class, $column));

        // Act
        new $builder_class($this->data, $this->sampling_rate);
    }

    #[TestDox("require \"timestamp\" column key in its raw data.")]
    public function test_require_timestamp_column(): void
    {
        // Arrange
        $column = "timestamp";
        unset($this->data[0][$column]);
        $builder_class = $this->getBuilderClass();
        
        // Assert
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($this->getBuilderMissingKeyErrorMessage($builder_class, $column));

        // Act
        new $builder_class($this->data, $this->sampling_rate);
    }

    #[TestDox("require \"longitude\" column key in its raw data.")]
    public function test_require_longitude_column(): void
    {
        // Arrange
        $column = "longitude";
        unset($this->data[0][$column]);
        $builder_class = $this->getBuilderClass();
        
        // Assert
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($this->getBuilderMissingKeyErrorMessage($builder_class, $column));

        // Act
        new $builder_class($this->data, $this->sampling_rate);
    }

    #[TestDox("require \"daily_speed\" column key in its raw data.")]
    public function test_require_daily_speed_column(): void
    {
        // Arrange
        $column = "daily_speed";
        unset($this->data[0][$column]);
        $builder_class = $this->getBuilderClass();
        
        // Assert
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($this->getBuilderMissingKeyErrorMessage($builder_class, $column));

        // Act
        new $builder_class($this->data, $this->sampling_rate);
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
     * Return raw ephemeris data to test the builder.
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
                "longitude" => "30.4666383",
                "daily_speed" => "14.1215446"
            ],
            1 => [
                "astral_object" => "intp. Perigee",
                "timestamp" => "07.01.2025 23:00:00 TT", 
                "longitude" => "31.1522198",
                "daily_speed" => "-1.7974075"
            ],
            // This is to be selected
            2 => [
                "astral_object" => "Moon",
                "timestamp" => "08.01.2025 0:00:00 TT", 
                "longitude" => "31.0550675",
                "daily_speed" => "14.1230524"               
            ],
            3 => [
                "astral_object" => "intp. Perigee",
                "timestamp" => "08.01.2025 0:00:00 TT", 
                "longitude" => "31.0771769",
                "daily_speed" => "-1.8046267"
            ],
            // End selection
            4 => [
                "astral_object" => "Moon",
                "timestamp" => "08.01.2025 1:00:00 TT", 
                "longitude" => "31.6435588",
                "daily_speed" => "14.1245248"               
            ],
            5 => [
                "astral_object" => "intp. Perigee",
                "timestamp" => "08.01.2025 1:00:00 TT", 
                "longitude" => "31.0018338",
                "daily_speed" => "-1.8118296"
            ],
            6 => [
                "astral_object" => "Moon",
                "timestamp" => "02.02.2025 1:00:00 TT", 
                "longitude" => "359.8897340",
                "daily_speed" => "14.3461537"               
            ],
            7 => [
                "astral_object" => "intp. Perigee",
                "timestamp" => "02.02.2025 1:00:00 TT", 
                "longitude" => "0.9769526",
                "daily_speed" => "-0.1138835"
            ],
            8 => [
                "astral_object" => "Moon",
                "timestamp" => "02.02.2025 2:00:00 TT", 
                "longitude" => "0.4874730",
                "daily_speed" => "14.3453009"               
            ],
            9 => [
                "astral_object" => "intp. Perigee",
                "timestamp" => "02.02.2025 2:00:00 TT", 
                "longitude" => "0.9722443",
                "daily_speed" => "-0.1121298"
            ],
            // This is to be selected
            10 => [
                "astral_object" => "Moon",
                "timestamp" => "02.02.2025 3:00:00 TT", 
                "longitude" => "1.0851743",
                "daily_speed" => "14.3443452"
            ],
            11 => [
                "astral_object" => "intp. Perigee",
                "timestamp" => "02.02.2025 3:00:00 TT", 
                "longitude" => "0.9676088",
                "daily_speed" => "-0.1103819"
            ],
            // End selection
            12 => [
                "astral_object" => "Moon",
                "timestamp" => "02.02.2025 4:00:00 TT", 
                "longitude" => "1.6828336",
                "daily_speed" => "14.3432880"
            ],
            13 => [
                "astral_object" => "intp. Perigee",
                "timestamp" => "02.02.2025 4:00:00 TT", 
                "longitude" => "0.9630462",
                "daily_speed" => "-0.1086403"
            ],
            14 => [
                "astral_object" => "Moon",
                "timestamp" => "01.03.2025 20:00:00 TT", 
                "longitude" => "6.2416814",
                "daily_speed" => "14.8112960"
            ],
            15 => [
                "astral_object" => "intp. Perigee",
                "timestamp" => "01.03.2025 20:00:00 TT", 
                "longitude" => "7.0755343",
                "daily_speed" => "0.4065744"
            ],
            // This is to be selected
            16 => [
                "astral_object" => "Moon",
                "timestamp" => "01.03.2025 21:00:00 TT", 
                "longitude" => "6.8588149",
                "daily_speed" => "14.8110769"
            ],
            17 => [
                "astral_object" => "intp. Perigee",
                "timestamp" => "01.03.2025 21:00:00 TT", 
                "longitude" => "7.0924814",
                "daily_speed" => "0.4068851"
            ],
            // End selection
            18 => [
                "astral_object" => "Moon",
                "timestamp" => "01.03.2025 22:00:00 TT", 
                "longitude" => "7.4759349",
                "daily_speed" => "14.8106512"
            ],
            19 => [
                "astral_object" => "intp. Perigee",
                "timestamp" => "01.03.2025 22:00:00 TT", 
                "longitude" => "7.1094414",
                "daily_speed" => "0.4071950"
            ],
        ];
    }
}