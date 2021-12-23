<?php

namespace Tests\Unit\Builders\SynodicRhythm;

use Carbon\Carbon;
use InvalidArgumentException;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\SynodicRhythm\FromArray;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\SynodicRhythm\Interfaces\SynodicRhythmBuilder;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythm;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord;
use PHPUnit\Framework\TestCase;

/**
 * @testdox The SynodicRhythm
 */
class FromArrayTest extends TestCase
{
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
     * @testdox can be constructed from an array.
     */
    public function test_build_synodic_rhythm_from_array()
    {
        // Arrange in setUp()

        // Act
        $builder = new FromArray($this->data);
        $builder->validateData();
        $builder->buildRecords();

        // Assert
        $this->assertInstanceOf(SynodicRhythmBuilder::class, $builder, "The FromArray builder must realize the SynodicRhythmBuilder interface.");
        $this->assertInstanceOf(SynodicRhythm::class, $collection = $builder->fetchCollection(), "A SynodicRhythmBuilder must produce a SynodicRhythm.");       
        $this->assertContainsOnlyInstancesOf(SynodicRhythmRecord::class, $collection, "The SynodicRhythm must consists of SynodicRhythmRecord(s)."); 
    }

    /**
     * @testdox can't be built without timestamp.
     */
    public function test_from_array_builder_wants_timestamp_column()
    {
        /**
         * Missing key "timestamp"
         */
        // Arrange
        $data1 = [
            0 => [
                "angular_distance" => "anything",
                "hello" => null
            ]
        ];
        
        // Act & Assert
        $this->expectException(InvalidArgumentException::class);
        $builder = new FromArray($data1);
        $builder->validateData();
    }

    /**
     * @testdox can't be built without angular_distance.
     */
    public function test_from_array_builder_wants_angular_distance_column()
    {   
        /**
         * Missing key "angular_distance"
         */
        // Arrange
        $data2 = [
            0 => [
                "timestamp" => "somewhat",
                "hello" => null
            ]
        ];

        // Act & Assert
        $this->expectException(InvalidArgumentException::class);
        $builder = new FromArray($data2);
        $builder->validateData();
    }
}
