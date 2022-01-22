<?php

namespace MarcoConsiglio\Ephemeris\Tests\Unit\Builders\SynodicRhythm;

use Carbon\Carbon;
use InvalidArgumentException;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\Builder;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\SynodicRhythm\FromRecords;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythm;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\SwissDateTime;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @testdox The SynodicRhythm/FromRecords builder
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
        $t1 = (new SwissDateTime())->minutes(0)->seconds(0);
        $t2 = $t1->copy()->addHour();
        $this->data = [
            0 => [
                "timestamp" => $t1->toGregorianUT(),
                "angular_distance" => $this->faker->randomFloat(1, -360, 360)
            ],
            1 => [
                "timestamp" => $t2->toGregorianUT(),
                "angular_distance" => $this->faker->randomFloat(1, -360, 360)
            ]
        ];
    }

    /**
     * @testdox can build a SynodicRhythm starting from SynodicRhythmRecord(s).
     */
    public function test_build_synodic_rhythm_from_records()
    {
        // Arrange in setUp()
        $records = [];
        foreach ($this->data as $index => $item) {
            $records[] = new SynodicRhythmRecord($item["timestamp"], $item["angular_distance"]);
        }
        
        // Act
        $builder = new FromRecords($records);
        $builder->validateData();
        $builder->buildRecords();

        // Assert
        $this->assertInstanceOf(Builder::class, $builder, "The FromRecords builder must realize the SynodicRhythmBuilder interface.");
        $this->assertInstanceOf(SynodicRhythm::class, $collection = $builder->fetchCollection(), "A SynodicRhythmBuilder must produce a SynodicRhythm.");       
        $this->assertContainsOnlyInstancesOf(SynodicRhythmRecord::class, $collection, "The SynodicRhythm must consists of SynodicRhythmRecord(s)."); 
    }

    /**
     * @testdox cannot build a SynodicRhythm without an array.
     */
    public function test_from_records_builder_wants_array_data()
    {
        // Arrange
        $data = new SynodicRhythmRecord($this->data[0]["timestamp"], 90);

        // Act & Assert
        $builder = new FromRecords($data);
        $this->expectException(InvalidArgumentException::class);
        $builder->validateData();
    }

    /**
     * @testdox cannot build a SynodicRhythm without SynodicRhythmRecord(s).
     */
    public function test_from_records_builder_wants_synodic_rhythm_records()
    {
        // Arrange
        $data = [new stdClass, new stdClass];

        // Act & Assert
        $builder = new FromRecords($data);
        $this->expectException(InvalidArgumentException::class);
        $builder->validateData();
    }
}
