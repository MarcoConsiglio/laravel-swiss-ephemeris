<?php

namespace MarcoConsiglio\Ephemeris\Tests\Unit\Builders\Moon\SynodicRhythm;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\SynodicRhythm\FromArray;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Unit\Builders\BuilderTestCase;

#[TestDox("The Moon\SynodicRhythm\FromArray builder")]
#[CoversClass(FromArray::class)]
#[UsesClass(InvalidArgumentException::class)]
#[UsesClass(SwissEphemerisDateTime::class)]
#[UsesClass(SynodicRhythmRecord::class)]
class FromArrayTest extends BuilderTestCase
{
    /**
     * Test data.
     *
     * @var array
     */
    protected array $data;

    /**
     * This method is called before each test.
     * 
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $t1 = SwissEphemerisDateTime::create();
        $t2 = $t1->copy()->addHour();
        $this->data = [
            0 => [
                "timestamp" => $t1->toGregorianTT(),
                "angular_distance" => fake()->randomFloat(1, -360, 360)
            ],
            1 => [
                "timestamp" => $t2->toGregorianTT(),
                "angular_distance" => fake()->randomFloat(1, -360, 360)
            ]
        ];
    }

    #[TestDox("can build an array of Moon\SynodicRhythmRecords starting from an array of raw ephemeris data.")]
    public function test_build_synodic_rhythm_from_array()
    {
        // Arrange
        $builder_class = $this->getBuilderClass();
        $record_class = SynodicRhythmRecord::class;

        // Act
        /** @var FromArray $builder */
        $builder = new $builder_class($this->data);
        $synodic_rhythm_records = $builder->fetchCollection();

        // Assert
        $this->assertIsArray($synodic_rhythm_records, 
            $this->methodMustReturn($builder_class, "fetchCollection", "array")
        );
        $this->assertContainsOnlyInstancesOf($record_class, $synodic_rhythm_records,
            $this->iterableMustContains("array", $record_class)
        );
        $this->assertCount(count($this->data), $synodic_rhythm_records, 
            "The $builder_class builder must produce the same ammount of records as the input."
        );
    }

    #[TestDox("require the \"timestamp\" column.")]
    public function test_from_array_builder_wants_timestamp_column()
    {
        /**
         * Missing key "timestamp"
         */
        // Arrange
        unset($this->data[0]["timestamp"]);
        $builder_class = $this->getBuilderClass();
        
        // Assert
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("The $builder_class builder must have \"timestamp\" column.");

        // Act
        $builder = new $builder_class($this->data);
        $builder->validateData();
    }

    #[TestDox("require the \"angular_distance\" column")]
    public function test_from_array_builder_wants_angular_distance_column()
    {   
        /**
         * Missing key "angular_distance"
         */
        // Arrange
        unset($this->data[0]["angular_distance"]);
        $builder_class = $this->getBuilderClass();

        // Assert
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("The $builder_class builder must have \"angular_distance\" column.");

        // Act
        $builder = new $builder_class($this->data);
        $builder->validateData();
    }

    #[TestDox("cannot build a Moon\SynodicRhythm with an empty array.")]
    public function test_validate_data_method()
    {
        // Act
        $builder_class = $this->getBuilderClass();
        
        // Assert
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("The $builder_class builder cannot work with an empty array.");
        
        // Arrange
        $builder = new $builder_class([]);
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
