<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Builders\Moon\Apogees;

use MarcoConsiglio\Ephemeris\Records\Moon\ApogeeRecord;
use PHPUnit\Framework\Attributes\TestDox;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Apogees\FromArray;
use MarcoConsiglio\Ephemeris\Tests\Unit\Builders\BuilderTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[TestDox("The Moon\Apogees\FromArray builder")]
#[CoversClass(FromArray::class)]
class FromArrayTest extends BuilderTestCase
{
    #[TestDox("can build an Apogees collection from an array.")]
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
            ],
        ];

        // Act
        $records = new $builder_class($output)->fetchCollection();

        // Assert
        $this->assertIsArray($records,
            $this->methodMustReturn($builder_class, "fetchCollection", "array")
        );
        $this->assertCount(1, $records);
        $this->assertContainsOnlyInstancesOf(ApogeeRecord::class, $records);
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