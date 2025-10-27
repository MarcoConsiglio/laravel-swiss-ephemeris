<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Builders\Moon\Apogees;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use MarcoConsiglio\Ephemeris\Records\Moon\ApogeeRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Apogees\FromArray;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\Apogees;
use MarcoConsiglio\Ephemeris\Tests\Unit\Builders\BuilderTestCase;

#[CoversClass(FromArray::class)]
#[UsesClass(Apogees::class)]
#[UsesClass(ApogeeRecord::class)]
#[TestDox("The Moon\Apogees\FromArray builder")]
class FromArrayTest extends BuilderTestCase
{
    #[TestDox("can build Apogees collection from an array.")]
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
        $collection = new Apogees($builder);

        // Assert
        $this->assertContainsOnlyInstancesOf(ApogeeRecord::class, $collection);
        $this->assertCount(1, $collection);
    }

    protected function getBuilderClass(): string
    {
        return FromArray::class;
    }
}