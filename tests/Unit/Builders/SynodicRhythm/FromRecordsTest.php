<?php

namespace Tests\Unit\Builders\SynodicRhythm;

use Carbon\Carbon;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\SynodicRhythm\FromRecords;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\SynodicRhythm\Interfaces\SynodicRhythmBuilder;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythm;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord;
use PHPUnit\Framework\TestCase;

/**
 * @testdox The SynodicRhythm
 */
class FromRecordsTest extends TestCase
{
    /**
     * The faker instance.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * This method is called before each test.
     */
    protected function setUp(): void
    {
        $this->faker = \Faker\Factory::create();
    }

    /**
     * @testdox can be constructed from an array of SynodicRhythmRecord(s).
     */
    public function test_build_synodic_rhythm_from_records()
    {
        // Arrange
        $t1 = (new Carbon())->hour(12)->minutes(0)->seconds(0);
        $t2 = $t1->copy()->addHour();
        $data = [
            0 => [
                "timestamp" => $t1->format("d.m.Y H:m:i")." UT",
                "angular_distance" => $this->faker->randomFloat(1, -360, 360)
            ],
            1 => [
                "timestamp" => $t2->format("d.m.Y H:m:i")." UT",
                "angular_distance" => $this->faker->randomFloat(1, -360, 360)
            ]
        ];
        $records = [];
        foreach ($data as $index => $item) {
            $records[] = new SynodicRhythmRecord($item["timestamp"], $item["angular_distance"]);
        }
        
        // Act
        $builder = new FromRecords($records);
        $builder->extractArray();
        $builder->validateData();
        $builder->buildRecords();

        // Assert
        $this->assertInstanceOf(SynodicRhythmBuilder::class, $builder, "The FromRecords builder must realize the SynodicRhythmBuilder interface.");
        $this->assertInstanceOf(SynodicRhythm::class, $collection = $builder->fetchCollection(), "A SynodicRhythmBuilder must produce a SynodicRhythm.");       
        $this->assertContainsOnlyInstancesOf(SynodicRhythmRecord::class, $collection, "The SynodicRhythm must consists of SynodicRhythmRecord(s)."); 
    }
}
