<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\Moon\Anomalistic\Apogees;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use MarcoConsiglio\Ephemeris\Records\Moon\ApogeeRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\AnomalisticRhythm\Apogees\FromArray;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\Apogees;
use MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\FromArrayTestCase;

#[CoversClass(FromArray::class)]
#[UsesClass(Apogees::class)]
#[UsesClass(ApogeeRecord::class)]
#[TestDox("The Moon Apogees\FromArray builder")]
class FromArrayTest extends FromArrayTestCase
{
    /**
     * The file with a raw ephemeris response.
     *
     * @var string
     */
    protected string $response_file = "./tests/SwissEphemerisResponses/Moon/apogees_decimal.txt";
    
    /**
     * Setup the test environment.
     */
    #[\Override]
    public function setUp(): void
    {
        parent::setUp();
        $this->sampling_rate = 60;
    }

    #[TestDox("can build Apogees collection from an array of raw ephemeris.")]
    public function test_build_apogees(): void
    {
        // Arrange
        $builder_class = $this->getBuilderClass();
        
        // Act
        $builder = new $builder_class($this->data, $this->sampling_rate);
        $collection = new Apogees($builder);
        
        // Assert
        $this->assertContainsOnlyInstancesOf(ApogeeRecord::class, $collection);
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
     */
    protected function getBuilderClass(): string
    {
        return FromArray::class;
    }

    /**
     * Return raw ephemeris data to test the builder.
     */
    public function getRawData(): array
    {
        // There are 3 apogees here.
        return [
            0 => [
                "astral_object" => "Moon",
                "timestamp" => "18.02.2025 0:00:00 TT", 
                "longitude" => "209.8363308",
                "daily_speed" => "11.8053928"
            ],
            1 => [
                "astral_object" => "intp. Apogee",
                "timestamp" => "18.02.2025 0:00:00 TT", 
                "longitude" => "210.4194248",
                "daily_speed" => "0.1928701"
            ],
            // This is to be selected
            2 => [
                "astral_object" => "Moon",
                "timestamp" => "18.02.2025 1:00:00 TT", 
                "longitude" => "210.3282165",
                "daily_speed" => "11.8051421"               
            ],
            3 => [
                "astral_object" => "intp. Apogee",
                "timestamp" => "18.02.2025 1:00:00 TT", 
                "longitude" => "210.4274589",
                "daily_speed" => "0.1927676" 
            ],
            // End selection
            4 => [
                "astral_object" => "Moon",
                "timestamp" => "18.02.2025 2:00:00 TT", 
                "longitude" => "210.8200945",
                "daily_speed" => "11.8050240"                
            ],
            5 => [
                "astral_object" => "intp. Apogee",
                "timestamp" => "18.02.2025 2:00:00 TT", 
                "longitude" => "210.4354887",
                "daily_speed" => "0.1926649" 
            ],
            6 => [
                "astral_object" => "Moon",
                "timestamp" => "17.03.2025 16:00:00 TT", 
                "longitude" => "214.1718114",
                "daily_speed" => "11.8140499"                
            ],
            7 => [
                "astral_object" => "intp. Apogee",
                "timestamp" => "17.03.2025 16:00:00 TT", 
                "longitude" => "214.4834832",
                "daily_speed" => "0.0837407" 
            ],
            // This is to be selected.
            8 => [
                "astral_object" => "Moon",
                "timestamp" => "17.03.2025 17:00:00 TT", 
                "longitude" => "214.6640588",
                "daily_speed" => "11.8138420"                
            ],
            9 => [
                "astral_object" => "intp. Apogee",
                "timestamp" => "17.03.2025 17:00:00 TT", 
                "longitude" => "214.4869673",
                "daily_speed" => "0.0834977" 
            ],
            // End selection.
            10 => [
                "astral_object" => "Moon",
                "timestamp" => "17.03.2025 18:00:00 TT", 
                "longitude" => "215.1562994",
                "daily_speed" => "11.8137243" 
            ],
            11 => [
                "astral_object" => "intp. Apogee",
                "timestamp" => "17.03.2025 18:00:00 TT", 
                "longitude" => "214.4904413",
                "daily_speed" => "0.0832545" 
            ],
            12 => [
                "astral_object" => "Moon",
                "timestamp" => "13.04.2025 22:00:00 TT", 
                "longitude" => "213.9806658",
                "daily_speed" => "11.8251566" 
            ],
            13 => [
                "astral_object" => "intp. Apogee",
                "timestamp" => "13.04.2025 22:00:00 TT", 
                "longitude" => "214.3941696",
                "daily_speed" => "-0.0856186" 
            ],
            // This is to be selected
            14 => [
                "astral_object" => "Moon",
                "timestamp" => "13.04.2025 23:00:00 TT", 
                "longitude" => "214.4733895",
                "daily_speed" => "11.8255912" 
            ],
            15 => [
                "astral_object" => "intp. Apogee",
                "timestamp" => "13.04.2025 23:00:00 TT", 
                "longitude" => "214.3905987",
                "daily_speed" => "-0.0857816" 
            ],
            // End selection
            16 => [
                "astral_object" => "Moon",
                "timestamp" => "14.04.2025 0:00:00 TT", 
                "longitude" => "214.9661325",
                "daily_speed" => "11.8260826" 
            ],
            17 => [
                "astral_object" => "intp. Apogee",
                "timestamp" => "14.04.2025 0:00:00 TT", 
                "longitude" => "214.3870211",
                "daily_speed" => "-0.0859437" 
            ],
        ];
    }
}