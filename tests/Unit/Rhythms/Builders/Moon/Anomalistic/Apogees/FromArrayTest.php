<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\Moon\Anomalistic\Apogees;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use MarcoConsiglio\Ephemeris\Records\Moon\ApogeeRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\AnomalisticRhythm\Apogees\FromArray;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\Apogees;
use MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\BuilderTestCase;
use PHPUnit\Framework\Attributes\DataProvider;

#[CoversClass(FromArray::class)]
#[UsesClass(Apogees::class)]
#[UsesClass(ApogeeRecord::class)]
#[TestDox("The Moon\Apogees\FromArray builder")]
class FromArrayTest extends BuilderTestCase
{
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
        $this->assertCount(2, $collection);
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
        // There are 3 apogees here.
        return [
            0 => [
                "astral_object" => "Moon",
                "timestamp" => "18.02.2025 0:00:00 TT", 
                "longitude" => "209°50'10.7909\""
            ],
            1 => [
                "astral_object" => "intp. Apogee",
                "timestamp" => "18.02.2025 0:00:00 TT", 
                "longitude" => "210°25' 9.9291\""
            ],
            // This is to be selected
            2 => [
                "astral_object" => "Moon",
                "timestamp" => "18.02.2025 1:00:00 TT", 
                "longitude" => "210°19'41.5793\""               
            ],
            3 => [
                "astral_object" => "intp. Apogee",
                "timestamp" => "18.02.2025 1:00:00 TT", 
                "longitude" => "210°25'38.8519\""
            ],
            // End selection
            4 => [
                "astral_object" => "Moon",
                "timestamp" => "18.02.2025 2:00:00 TT", 
                "longitude" => "210°49'12.3401\""               
            ],
            5 => [
                "astral_object" => "intp. Apogee",
                "timestamp" => "18.02.2025 2:00:00 TT", 
                "longitude" => "210°26' 7.7593\""
            ],
            6 => [
                "astral_object" => "Moon",
                "timestamp" => "17.03.2025 16:00:00 TT", 
                "longitude" => "214°10'18.5209\""               
            ],
            7 => [
                "astral_object" => "intp. Apogee",
                "timestamp" => "17.03.2025 16:00:00 TT", 
                "longitude" => "214°29' 0.5395\""
            ],
            8 => [
                "astral_object" => "Moon",
                "timestamp" => "17.03.2025 17:00:00 TT", 
                "longitude" => "214°39'50.6116\""               
            ],
            9 => [
                "astral_object" => "intp. Apogee",
                "timestamp" => "17.03.2025 17:00:00 TT", 
                "longitude" => "214°29'13.0823\""
            ],
            10 => [
                "astral_object" => "Moon",
                "timestamp" => "17.03.2025 18:00:00 TT", 
                "longitude" => "215° 9'22.6778\""
            ],
            11 => [
                "astral_object" => "intp. Apogee",
                "timestamp" => "17.03.2025 18:00:00 TT", 
                "longitude" => "214°23'51.8415\""
            ],
            12 => [
                "astral_object" => "Moon",
                "timestamp" => "13.04.2025 22:00:00 TT", 
                "longitude" => "213°58'50.3968\""
            ],
            13 => [
                "astral_object" => "intp. Apogee",
                "timestamp" => "13.04.2025 22:00:00 TT", 
                "longitude" => "214°23'39.0107\""
            ],
            // This is to be selected
            14 => [
                "astral_object" => "Moon",
                "timestamp" => "13.04.2025 23:00:00 TT", 
                "longitude" => "214°28'24.2021\""
            ],
            15 => [
                "astral_object" => "intp. Apogee",
                "timestamp" => "13.04.2025 23:00:00 TT", 
                "longitude" => "214°23'26.1555\""
            ],
            // End selection
            16 => [
                "astral_object" => "Moon",
                "timestamp" => "14.04.2025 0:00:00 TT", 
                "longitude" => "214°57'58.0768\""
            ],
            17 => [
                "astral_object" => "intp. Apogee",
                "timestamp" => "14.04.2025 0:00:00 TT", 
                "longitude" => "214°23'13.2758\""
            ],
        ];
    }
}