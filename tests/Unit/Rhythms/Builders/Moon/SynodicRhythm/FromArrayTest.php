<?php

namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\Moon\SynodicRhythm;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\Builder;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\SynodicRhythm\FromArray;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\MoonBuilderTestCase;

#[TestDox("The Moon\SynodicRhythm\FromArray builder")]
#[CoversClass(FromArray::class)]
#[UsesClass(SwissEphemerisDateTime::class)]
#[UsesClass(SynodicRhythmRecord::class)]
class FromArrayTest extends MoonBuilderTestCase
{
    /**
     * Test data.
     *
     * @var array
     */
    protected array $data;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $t1 = SwissEphemerisDateTime::create();
        $t2 = $t1->copy()->addHour();
        $limit = 180;
        $this->data = [
            0 => [
                "timestamp" => $t1->toGregorianTT(),
                "angular_distance" => $this->faker->randomFloat(PHP_FLOAT_DIG, -$limit, $limit),
                "daily_speed" => $this->getRandomMoonDailySpeed()
            ],
            1 => [
                "timestamp" => $t2->toGregorianTT(),
                "angular_distance" => $this->faker->randomFloat(PHP_FLOAT_DIG, -$limit, $limit),
                "daily_speed" => $this->getRandomMoonDailySpeed()
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
        $this->checkBuilderInterface(Builder::class, $builder);
        $synodic_rhythm_records = $builder->fetchCollection();

        // Assert
        $this->assertIsArray($synodic_rhythm_records, 
            $this->methodMustReturn($builder_class, "fetchCollection", "array")
        );
        $this->assertContainsOnlyInstancesOf($record_class, $synodic_rhythm_records,
            $this->iterableMustContains("array", $record_class)
        );
        $this->assertCount(count($this->data), $synodic_rhythm_records, 
            "The $builder_class builder must produce the same ammount of records as the array input."
        );
    }

    #[TestDox("require the \"timestamp\" column.")]
    public function test_from_array_builder_wants_timestamp_column()
    {
        /**
         * Missing key "timestamp"
         */
        // Arrange
        $column = "timestamp";
        unset($this->data[0][$column]);
        $builder_class = $this->getBuilderClass();
        
        // Assert
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("The $builder_class builder must have \"$column\" key in its raw array data.");

        // Act
        new $builder_class($this->data);
    }

    #[TestDox("require the \"angular_distance\" column")]
    public function test_from_array_builder_wants_angular_distance_column()
    {   
        /**
         * Missing key "angular_distance"
         */
        // Arrange
        $column = "angular_distance";
        unset($this->data[0][$column]);
        $builder_class = $this->getBuilderClass();

        // Assert
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("The $builder_class builder must have \"$column\" key in its raw array data.");

        // Act
        new $builder_class($this->data);
    }

    #[TestDox("require the \"daily_speed\" column")]
    public function test_from_array_builder_wants_daily_speed_column()
    {   
        /**
         * Missing key "daily_speed"
         */
        // Arrange
        $column = "daily_speed";
        unset($this->data[0][$column]);
        $builder_class = $this->getBuilderClass();

        // Assert
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("The $builder_class builder must have \"$column\" key in its raw array data.");

        // Act
        new $builder_class($this->data);
    }

    #[TestDox("cannot build a Moon\SynodicRhythm with an empty array.")]
    public function test_validate_data_method()
    {
        // Act
        $builder_class = $this->getBuilderClass();
        
        // Assert
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("The $builder_class builder cannot work with empty array data.");
        
        // Arrange
        new $builder_class([]);
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
