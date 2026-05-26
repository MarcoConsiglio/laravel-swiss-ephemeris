<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\Moon\Draconic;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use MarcoConsiglio\Ephemeris\Records\Moon\DraconicRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\DraconicRhythm\FromArray;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\DraconicRhythm;
use MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\FromArrayTestCase;

#[TestDox("The DraconicRhythm FromArray builder")]
#[CoversClass(FromArray::class)]
class FromArrayTest extends FromArrayTestCase
{
    /**
     * Setup the test environment.
     */
    #[\Override]
    public function setUp(): void
    {
        parent::setUp();
        $this->sampling_rate = 60;
    }

    #[TestDox("can build a Moon DraconicRhythm collection.")]
    public function test_build_draconic_rhythm(): void
    {
        // Arrange
        $builder_class = $this->getBuilderClass();
        $builder = new $builder_class($this->data, $this->sampling_rate);

        // Act
        $rhythm = new DraconicRhythm($builder);

        // Assert
        $this->assertContainsOnlyInstancesOf(DraconicRecord::class, $rhythm);
        $this->assertCount(2, $rhythm);
    }

    #[TestDox("require \"astral_object\" column key in its raw data.")]
    public function test_require_astral_object_column(): void
    {
        // Arrange
        $column = "astral_object";
        $builder_class = $this->getBuilderClass();
        unset($this->data[0][$column]);
        
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
        $builder_class = $this->getBuilderClass();
        unset($this->data[0][$column]);
        
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
        $builder_class = $this->getBuilderClass();
        unset($this->data[0][$column]);
        
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
        $builder_class = $this->getBuilderClass();
        unset($this->data[0][$column]);
        
        // Assert
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($this->getBuilderMissingKeyErrorMessage($builder_class, $column));
        
        // Act
        new $builder_class($this->data, $this->sampling_rate);
    }

    /**
     * Get the current SUT class.
     */
    protected function getBuilderClass(): string
    {
        return FromArray::class;
    }

    protected function getRawData(): array
    {
        return [
            0 => [
                "astral_object" => "Moon",
                "timestamp" => "06.03.2021 00:00:00 TT",
                "longitude" => "254.8083527",
                "daily_speed" => "13.9505680"
            ],
            1 => [
                "astral_object" => "true Node",
                "timestamp" => "06.03.2021 00:00:00 TT",
                "longitude" => "75.3584237",
                "daily_speed" => "0.0000224"
            ],
            // Start selection (south node)
            2 => [
                "astral_object" => "Moon",
                "timestamp" => "06.03.2021 1:00:00 TT",
                "longitude" => "255.3894371",
                "daily_speed" => "13.9414895"
            ],
            3 => [
                "astral_object" => "true Node",
                "timestamp" => "06.03.2021 1:00:00 TT",
                "longitude" => "75.3584255",
                "daily_speed" => "0.0000553"
            ],
            // End selection
            4 => [
                "astral_object" => "Moon",
                "timestamp" => "06.03.2021 2:00:00 TT",
                "longitude" => "255.9701435",
                "daily_speed" => "13.9324199"
            ],
            5 => [
                "astral_object" => "true Node",
                "timestamp" => "06.03.2021 2:00:00 TT",
                "longitude" => "75.3584277",
                "daily_speed" => "0.0000473"
            ],
            6 => [
                "astral_object" => "Moon",
                "timestamp" => "20.03.2021 3:00:00 TT",
                "longitude" => "73.3843113",
                "daily_speed" => "11.8594630"
            ],
            7 => [
                "astral_object" => "true Node",
                "timestamp" => "20.03.2021 3:00:00 TT",
                "longitude" => "73.6451923",
                "daily_speed" => "-0.0002661"
            ],
            // Start selection (north node)  
            8 => [
                "astral_object" => "Moon",
                "timestamp" => "20.03.2021 4:00:00 TT",
                "longitude" => "73.8785588",
                "daily_speed" => "11.8644573"
            ],
            9 => [
                "astral_object" => "true Node",
                "timestamp" => "20.03.2021 4:00:00 TT",
                "longitude" => "73.6451933",
                "daily_speed" => "0.0003051"
            ],
            // End selection
            10 => [
                "astral_object" => "Moon",
                "timestamp" => "20.03.2021 5:00:00 TT",
                "longitude" => "74.3730176",
                "daily_speed" => "11.8696082"
            ],
            11 => [
                "astral_object" => "true Node",
                "timestamp" => "20.03.2021 5:00:00 TT",
                "longitude" => "73.6452173",
                "daily_speed" => "0.0008442"
            ]
        ];
    }
}