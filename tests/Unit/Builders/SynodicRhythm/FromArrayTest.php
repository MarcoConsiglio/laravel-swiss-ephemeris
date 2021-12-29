<?php

namespace MarcoConsiglio\Ephemeris\Tests\Unit\Builders\SynodicRhythm;

use Carbon\Carbon;
use InvalidArgumentException;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\Builder;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\SynodicRhythm\FromArray;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythm;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Tests\Traits\WithReflection;
use PHPUnit\Framework\TestCase;

/**
 * @testdox The SynodicRhythm/FromArray builder
 */
class FromArrayTest extends TestCase
{
    use WithReflection;

    /**
     * The faker instance.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * Test data.
     *
     * @var array
     */
    protected array $data;

    /**
     * This method is called before each test.
     */
    protected function setUp(): void
    {
        $this->faker = \Faker\Factory::create();
        $t1 = (new Carbon())->hour(12)->minutes(0)->seconds(0);
        $t2 = $t1->copy()->addHour();
        $this->data = [
            0 => [
                "timestamp" => $t1->format("d.m.Y H:m:i")." UT",
                "angular_distance" => $this->faker->randomFloat(1, -360, 360)
            ],
            1 => [
                "timestamp" => $t2->format("d.m.Y H:m:i")." UT",
                "angular_distance" => $this->faker->randomFloat(1, -360, 360)
            ]
        ];
    }

    /**
     * @testdox can build a SynodicRhythm starting from an array of raw ephemeris data.
     */
    public function test_build_synodic_rhythm_from_array()
    {
        // Arrange in setUp()

        // Act
        $builder = new FromArray($this->data);
        $builder->validateData();
        $builder->buildRecords();

        // Assert
        $this->assertInstanceOf(Builder::class, $builder, "The FromArray builder must realize the SynodicRhythmBuilder interface.");
        $this->assertInstanceOf(SynodicRhythm::class, $collection = $builder->fetchCollection(), "A SynodicRhythmBuilder must produce a SynodicRhythm.");       
        $this->assertContainsOnlyInstancesOf(SynodicRhythmRecord::class, $collection, "The SynodicRhythm must consists of SynodicRhythmRecord(s)."); 
    }

    /**
     * @testdox require the 'timestamp' ephemeris column.
     */
    public function test_from_array_builder_wants_timestamp_column()
    {
        /**
         * Missing key "timestamp"
         */
        // Arrange
        unset($this->data[0]["timestamp"]);
        
        // Act & Assert
        $this->expectException(InvalidArgumentException::class);
        $builder = new FromArray($this->data);
        $builder->validateData();
    }

    /**
     * @testdox require the 'angular_distance' ephemeris column.
     */
    public function test_from_array_builder_wants_angular_distance_column()
    {   
        /**
         * Missing key "angular_distance"
         */
        // Arrange
        unset($this->data[0]["angular_distance"]);

        // Act & Assert
        $this->expectException(InvalidArgumentException::class);
        $builder = new FromArray($this->data);
        $builder->validateData();
    }

    /**
     * @testdox cannot build a SynodicRhythm with an empty array.
     */
    public function test_validate_data_method()
    {
        // Arrange
        $builder = new FromArray([]);
        
        // Act & Assert
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("The FromArray builder cannot work with an empty array.");
        $builder->validateData();
    }
}
