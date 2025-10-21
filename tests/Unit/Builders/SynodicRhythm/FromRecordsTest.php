<?php

namespace MarcoConsiglio\Ephemeris\Tests\Unit\Builders\MoonSynodicRhythm;

use InvalidArgumentException;
use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\Builder;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\SynodicRhythm\FromRecords;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\SynodicRhythm;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use stdClass;
use PHPUnit\Framework\Attributes\TestDox;
use TypeError;

#[TestDox("The MoonSynodicRhythm/FromRecords builder")]
#[CoversClass(FromRecords::class)]
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
        $t1 = (new SwissEphemerisDateTime)->minutes(0)->seconds(0);
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

    #[TestDox("can build a MoonSynodicRhythm starting from MoonSynodicRhythmRecord(s).")]
    public function test_build_synodic_rhythm_from_records()
    {
        // Arrange in setUp()
        $records = [];
        foreach ($this->data as $index => $item) {
            $records[] = new SynodicRhythmRecord($item["timestamp"], $item["angular_distance"]);
        }
        
        // Act
        $builder = new FromRecords($records);
        $builder->buildRecords();

        // Assert
        $this->assertInstanceOf(Builder::class, $builder, "The FromRecords builder must realize the MoonSynodicRhythmBuilder interface.");
        $this->assertInstanceOf(SynodicRhythm::class, $collection = $builder->fetchCollection(), "A MoonSynodicRhythmBuilder must produce a MoonSynodicRhythm.");       
        $this->assertContainsOnlyInstancesOf(SynodicRhythmRecord::class, $collection, "The MoonSynodicRhythm must consists of MoonSynodicRhythmRecord(s)."); 
    }

    #[TestDox("cannot build a MoonSynodicRhythm without an array.")]
    public function test_from_records_builder_wants_array_data()
    {
        // Arrange
        $data = new SynodicRhythmRecord($this->data[0]["timestamp"], 90);

        // Act & Assert
        $this->expectException(TypeError::class);
        $builder = new FromRecords($data);
        $builder->validateData();
    }

    #[TestDox("cannot build a MoonSynodicRhythm without MoonSynodicRhythmRecord(s).")]
    public function test_from_records_builder_wants_synodic_rhythm_records()
    {
        // Arrange
        $data = [new stdClass, new stdClass];

        // Act & Assert
        $this->expectException(InvalidArgumentException::class);
        $builder = new FromRecords($data);
    }
}
