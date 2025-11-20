<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\Moon\Anomalistic\Apogees;

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
#[TestDox("The Moon\Apogees\FromArray builder")]
class FromArrayTest extends FromArrayTestCase
{
    /**
     * The file with a raw ephemeris response.
     *
     * @var string
     */
    protected string $response_file = "./tests/SwissEphemerisResponses/Moon/apogees_decimal.txt";

    #[TestDox("can build Apogees collection from an array of raw ephemeris.")]
    public function test_build_apogees_from_array()
    {
        // Arrange
        $builder_class = $this->getBuilderClass();
        $array = $this->getRawData();
        
        // Act
        $builder = new $builder_class($array);
        $collection = new Apogees($builder);
        
        // Assert
        $this->assertContainsOnlyInstancesOf(ApogeeRecord::class, $collection);
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
    public function getRawData(): array
    {
        // There are 3 apogees here.
        return [
            0 => [
                "astral_object" => "Moon",
                "timestamp" => "18.02.2025 0:00:00 TT", 
                "longitude" => "209.8363308"
            ],
            1 => [
                "astral_object" => "intp. Apogee",
                "timestamp" => "18.02.2025 0:00:00 TT", 
                "longitude" => "210.4194248"
            ],
            // This is to be selected
            2 => [
                "astral_object" => "Moon",
                "timestamp" => "18.02.2025 1:00:00 TT", 
                "longitude" => "210.3282165"               
            ],
            3 => [
                "astral_object" => "intp. Apogee",
                "timestamp" => "18.02.2025 1:00:00 TT", 
                "longitude" => "210.4274589"
            ],
            // End selection
            4 => [
                "astral_object" => "Moon",
                "timestamp" => "18.02.2025 2:00:00 TT", 
                "longitude" => "210.8200945"               
            ],
            5 => [
                "astral_object" => "intp. Apogee",
                "timestamp" => "18.02.2025 2:00:00 TT", 
                "longitude" => "210.4354887"
            ],
            6 => [
                "astral_object" => "Moon",
                "timestamp" => "17.03.2025 16:00:00 TT", 
                "longitude" => "214.1718114"               
            ],
            7 => [
                "astral_object" => "intp. Apogee",
                "timestamp" => "17.03.2025 16:00:00 TT", 
                "longitude" => "214.4834832"
            ],
            // This is to be selected.
            8 => [
                "astral_object" => "Moon",
                "timestamp" => "17.03.2025 17:00:00 TT", 
                "longitude" => "214.6640588"               
            ],
            9 => [
                "astral_object" => "intp. Apogee",
                "timestamp" => "17.03.2025 17:00:00 TT", 
                "longitude" => "214.4869673"
            ],
            // End selection.
            10 => [
                "astral_object" => "Moon",
                "timestamp" => "17.03.2025 18:00:00 TT", 
                "longitude" => "215.1562994"
            ],
            11 => [
                "astral_object" => "intp. Apogee",
                "timestamp" => "17.03.2025 18:00:00 TT", 
                "longitude" => "214.4904413"
            ],
            12 => [
                "astral_object" => "Moon",
                "timestamp" => "13.04.2025 22:00:00 TT", 
                "longitude" => "213.9806658"
            ],
            13 => [
                "astral_object" => "intp. Apogee",
                "timestamp" => "13.04.2025 22:00:00 TT", 
                "longitude" => "214.3941696"
            ],
            // This is to be selected
            14 => [
                "astral_object" => "Moon",
                "timestamp" => "13.04.2025 23:00:00 TT", 
                "longitude" => "214.4733895"
            ],
            15 => [
                "astral_object" => "intp. Apogee",
                "timestamp" => "13.04.2025 23:00:00 TT", 
                "longitude" => "214.3905987"
            ],
            // End selection
            16 => [
                "astral_object" => "Moon",
                "timestamp" => "14.04.2025 0:00:00 TT", 
                "longitude" => "214.9661325"
            ],
            17 => [
                "astral_object" => "intp. Apogee",
                "timestamp" => "14.04.2025 0:00:00 TT", 
                "longitude" => "214.3870211"
            ],
        ];
    }
}