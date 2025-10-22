<?php

namespace MarcoConsiglio\Ephemeris\Tests\Unit\Builders\Moon\SynodicRhythm;

use InvalidArgumentException;
use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\Builder;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\SynodicRhythm\FromRecords;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\SynodicRhythm;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Unit\Builders\BuilderTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use stdClass;
use PHPUnit\Framework\Attributes\TestDox;
use TypeError;

#[TestDox("The Moon\SynodicRhythm\FromRecords builder")]
#[CoversClass(FromRecords::class)]
class FromRecordsTest extends BuilderTestCase
{
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
        parent::setUp();
        $t1 = (new SwissEphemerisDateTime)->minutes(0)->seconds(0);
        $t2 = $t1->copy()->addHour();
        $this->data = [
            0 => [
                "timestamp" => $t1->toGregorianTT(),
                "angular_distance" => $this->faker->randomFloat(1, -360, 360)
            ],
            1 => [
                "timestamp" => $t2->toGregorianTT(),
                "angular_distance" => $this->faker->randomFloat(1, -360, 360)
            ]
        ];
    }

    #[TestDox("can build a Moon\SynodicRhythm collection starting from Moon\SynodicRhythmRecord instances.")]
    public function test_build_synodic_rhythm_from_records()
    {
        // Arrange in setUp()
        $builder_class = $this->getBuilderClass();
        $builder_interface = Builder::class;
        $collection_class = SynodicRhythm::class;
        $record_class = SynodicRhythmRecord::class;
        $records = [];
        foreach ($this->data as $item) {
            $records[] = new SynodicRhythmRecord($item["timestamp"], $item["angular_distance"]);
        }
        
        // Act
        $builder = new $builder_class($records);
        $collection = $builder->fetchCollection();

        // Assert
        $this->assertInstanceOf($builder_interface, $builder, "The $builder_class builder must implement the $builder_interface interface.");
        $this->assertInstanceOf($collection_class, $collection,
            $this->methodMustReturn($builder_class, "fetchCollection", $collection_class)
        );       
        $this->assertContainsOnlyInstancesOf($record_class, $collection,
            $this->iterableMustContains($collection_class, $record_class)
        ); 
    }

    #[TestDox("cannot build a Moon\SynodicRhythm collection without an array.")]
    public function test_from_records_builder_wants_array_data()
    {
        // Arrange
        $data = new SynodicRhythmRecord($this->data[0]["timestamp"], 90);

        // Assert
        $this->expectException(TypeError::class);

        // Act
        $builder = new FromRecords($data);
    }

    #[TestDox("cannot build a Moon\SynodicRhythm collection without Moon\SynodicRhythmRecord instances.")]
    public function test_from_records_builder_wants_synodic_rhythm_records()
    {
        // Arrange
        $builder_class = $this->getBuilderClass();
        $record_class = SynodicRhythmRecord::class;
        $data = [new stdClass, new stdClass];

        // Assert
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("The builder $builder_class must have an array of $record_class.");

        // Act
       new $builder_class($data);
    }

    /**
     * Get the current SUT class.
     *
     * @return string
     */
    protected function getBuilderClass(): string
    {
        return FromRecords::class;
    } 
}
