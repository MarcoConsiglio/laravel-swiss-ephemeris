<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Builders\Moon\Anomalies\Perigees;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use MarcoConsiglio\Ephemeris\Records\Moon\PerigeeRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Perigees\FromArray;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\Perigees;
use MarcoConsiglio\Ephemeris\Tests\Unit\Builders\BuilderTestCase;

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
                "astral_object" => "intp. Apogee",
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
}